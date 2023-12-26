<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistsResource;
use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Documents;
use App\Models\Socialmedias;
use App\Models\User;
use Illuminate\Http\Request;
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:artists',
            'password' => ['required', 'string'],
            'image' => ['required', 'image'],
            'confirm_password' => 'required|same:password'

        ]);
        $data = $request->only(['stagename', 'email', 'lastname', 'name', 'birthday', 'tags', 'agency_id']);
        if (!$request->has('agency_id')) {
            if ($request->user()->getMorphClass() == 'App\\Models\\User') {
                $data['agency_id'] = $request->user()->agency_id;
            } else {
                $data['agency_id'] = $request->user()->id;
            }
        }
        $data['password'] = bcrypt($request->password);

        $image = $request->file('image')->store('documents', 'src');
        $data['image'] = "src/$image";

        //Almacenar los datos en la base de datos
        $artist = Artists::create($data);
        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                Socialmedias::create([
                    'url' => $socialmedia['url'],
                    'description' => $socialmedia['description'],
                    'typeredes_id' => $socialmedia['typeredes_id'],
                    'socialmediaable_id' => $artist->id,
                    'socialmediaable_type' => 'App\Models\Artists'
                ]);
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

        $artist->refresh();
        return new ArtistsResource($artist);
    }

    /**
     * Display the specified resource.
     */
    public function show(Artists $artists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artists $artists)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artists $artist)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:artists,email,' . $artist->id],
            'password' => ['required', 'string'],
            'confirm_password' => 'required|same:password'
        ]);

        $data = $request->only(['stagename', 'email', 'lastname', 'name', 'birthday', 'tags', 'notes']);

        if ($request->has('image')) {
            //Eliminar la vieja foto de perfil
            Storage::disk('src')->delete($artist->image);
            //Almacenar la nueva foto de perfil
            $image = $request->file('image')->store('girls');
            $data['image'] = $image;
        }

        $data['password'] = bcrypt($request->password);

        //Almacenar los datos en la base de datos
        $artist->update($data);

        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                Socialmedias::create([
                    'url' => $socialmedia['url'],
                    'description' => $socialmedia['description'],
                    'typeredes_id' => $socialmedia['typeredes_id'],
                    'socialmediaable_id' => $artist->id,
                    'socialmediaable_type' => 'App\Models\Artists'
                ]);
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
