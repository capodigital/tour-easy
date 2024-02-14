<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistsResource;
use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Documents;
use App\Models\Socialmedias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $artists = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $artists = Agencies::find($user->agency_id)->artists()->get();
            } else
                $artists = Artists::withTrashed()->whereNull('deleted_at')->get();
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
            $artists = Agencies::find($request->user()->id)->artists()->get();
        } else {
            $artists[] = Artists::find($request->user()->id);
        }

        return ArtistsResource::collection($artists);
    }

    /**
     * Display a listing of the resource.
     */
    public function landing(Request $request)
    {
        return ArtistsResource::collection(Artists::all());
    }

    public function all()
    {
        $artists = Artists::withTrashed()->get();
        return ArtistsResource::collection($artists);
    }
    public function deleted()
    {
        $artists = Artists::onlyTrashed()->get();
        return ArtistsResource::collection($artists);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:artists',
            //'password' => ['required', 'string'],
            'image' => ['required', 'image'],
            //'confirm_password' => 'required|same:password',
            'birthday' => 'required|before:today'

        ];

        $customMessages = [
            'birthday.before' => 'El campo fecha debe ser una fecha anterior a hoy',
            'email.unique' => 'El email ya existe'
        ];

        $request->validate($rules, $customMessages);
        $data = $request->only(['stagename', 'email', 'lastname', 'name', 'birthday', 'tags', 'agency_id', 'notes']);
        if (!$request->has('agency_id')) {
            if ($request->user()->getMorphClass() == 'App\\Models\\User') {
                $data['agency_id'] = $request->user()->agency_id;
            } else {
                $data['agency_id'] = $request->user()->id;
            }
        }
        //$data['password'] = bcrypt($request->password);

        $image = $request->file('image')->store('artists', 'src');
        $data['image'] = "src/$image";

        //Almacenar los datos en la base de datos
        $artist = Artists::create($data);
        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $artist->id,
                        'socialmediaable_type' => 'App\Models\Artists'
                    ]);
                }
            }
        }

        if ($request->has('documents')) {
            foreach ($request->file('documents') as $document) {
                $sizeInBytes = $document->getSize();
                $sizeInMB = $sizeInBytes / 1024 / 1024;
                $extension = $document->getClientOriginalExtension();
                $name = $document->getClientOriginalName();
                $path = $document->store('documents', 'src');
                Documents::create([
                    'url' => null,
                    'name' => $name,
                    'document_path' => $path,
                    'size' => $sizeInMB,
                    'ext' => $extension,
                    'documentable_id' => $artist->id,
                    'documentable_type' => 'App\Models\Artists'
                ]);
            }
        }

        if ($request->has('urls')) {
            foreach ($request->urls as $url) {
                if ($url != "") {
                    Documents::create([
                        'url' => $url,
                        'name' => null,
                        'document_path' => null,
                        'size' => null,
                        'ext' => null,
                        'documentable_id' => $artist->id,
                        'documentable_type' => 'App\Models\Artists'
                    ]);
                }
            }
        }

        $artist->refresh();
        return new ArtistsResource($artist);
    }

    /**
     * Display the specified resource.
     */
    public function show(Artists $artists)
    {
        return response()->json(new ArtistsResource($artists));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artists $artists)
    {
    }

    public function updatePassword(Request $request, $artist)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        // dd($artist);
        $artista = DB::table('artists')
            ->where('id', $artist)
            ->update(['password' => bcrypt($request->password)]);
        //$artist->password = bcrypt($request->password);
        //$artist->save();
        //$artist->update(['password' => bcrypt($request->password)]);
        return response('');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artists $artist)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:artists,email,' . $artist->id,
            'birthday' => 'required|before:today'

        ];

        $customMessages = [
            'birthday.before' => 'El campo fecha debe ser una fecha anterior a hoy',
            'email.unique' => 'El email ya existe'
        ];

        $request->validate($rules, $customMessages);

        $data = $request->only(['stagename', 'email', 'lastname', 'name', 'birthday', 'tags', 'notes']);

        if ($request->has('image')) {
            //Eliminar la vieja foto de perfil
            Storage::disk('src')->delete($artist->image);
            //Almacenar la nueva foto de perfil
            $image = $request->file('image')->store('src');
            $data['image'] = "src/$image";
        }

        //$data['password'] = bcrypt($request->password);

        //Almacenar los datos en la base de datos
        $artist->update($data);

        if ($request->has('socialmedias')) {
            Socialmedias::where('socialmediaable_id', $artist->id)->delete();
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $artist->id,
                        'socialmediaable_type' => 'App\Models\Artists'
                    ]);
                }
            }
        }

        if ($request->has('documents')) {
            foreach ($request->file('documents') as $document) {
                $sizeInBytes = $document->getSize();
                $sizeInMB = $sizeInBytes / 1024 / 1024;
                $extension = $document->getClientOriginalExtension();
                $name = $document->getClientOriginalName();
                $path = $document->store('documents', 'src');
                Documents::create([
                    'url' => null,
                    'name' => $name,
                    'document_path' => $path,
                    'size' => $sizeInMB,
                    'ext' => $extension,
                    'documentable_id' => $artist->id,
                    'documentable_type' => 'App\Models\Artists'
                ]);
            }
        }

        if ($request->has('urls')) {
            foreach ($request->urls as $url) {
                if ($url != "") {
                    Documents::create([
                        'url' => $url,
                        'name' => null,
                        'document_path' => null,
                        'size' => null,
                        'ext' => null,
                        'documentable_id' => $artist->id,
                        'documentable_type' => 'App\Models\Artists'
                    ]);
                }
            }
        }

        $artist->refresh();
        return new ArtistsResource($artist);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artists $artist)
    {
        $artist->delete();

        return response()->json($artist);
    }
    public function restore(Artists $artist)
    {
        $artist->restore();

        return response()->json($artist);
    }

    public function artistsByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $artists = $agency->artists()->get();

        return ArtistsResource::collection($artists);
    }
}
