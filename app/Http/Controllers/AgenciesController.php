<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgenciesResource;
use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Documents;
use App\Models\Socialmedias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AgenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $agencies = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $agencies[] = Agencies::find($user->agency_id)->first();
            } else {
                $agencies = Agencies::withTrashed()->whereNull('deleted_at')->get();
            }
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
            $agencies[] = Agencies::where('id', $request->user()->id)->first();
        } else {
            $agencies[] = Artists::find($request->user()->id)->agency()->first();
        }
        return AgenciesResource::collection($agencies);
    }

    /**
     * Display a listing of the resource.
     */
    public function landing(Request $request)
    {
        return AgenciesResource::collection(Agencies::all());
    }

    public function all()
    {
        $agencies = Agencies::withTrashed()->get();
        return AgenciesResource::collection($agencies);
    }
    public function deleted()
    {
        $agencies = Agencies::onlyTrashed()->get();
        return AgenciesResource::collection($agencies);
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
            'tradename' => 'required',
            'email' => 'required|email|unique:agencies',
            'password' => [
                'required',
                'string',
            ],
            'image' => ['required', 'image'],

        ]);

        $data = $request->only([
            'tradename',
            'email',
            'taxname',
            'taxcode',
            'owner',
            'address',
            'notes',
            'phone',
            'city_id',
            'typeagency_id'
        ]);

        $data['password'] = bcrypt($request->password);
        $image = $request->file('image')->store('agencies', 'src');
        $data['image'] = "src/$image";
        //Almacenar los datos en la base de datos
        $agency = Agencies::create($data);

        if ($request->has('socialmedias')) {
            Socialmedias::where('socialmediaable_id', $agency->id)->delete();
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $agency->id,
                        'socialmediaable_type' => 'App\Models\Agencies'
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
                    'documentable_id' => $agency->id,
                    'documentable_type' => 'App\Models\Agencies'
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
                        'documentable_id' => $agency->id,
                        'documentable_type' => 'App\Models\Agencies'
                    ]);
                }
            }
        }
        $agency->refresh();
        return new AgenciesResource($agency);
    }

    /**
     * Display the specified resource.
     */
    public function show(Agencies $agencies)
    {
        //
    }
    public function updatePassword(Request $request, $agency)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        // dd($artist);
        $agencia = DB::table('agencies')
            ->where('id', $agency)
            ->update(['password' => bcrypt($request->password)]);
        //$artist->password = bcrypt($request->password);
        //$artist->save();
        //$artist->update(['password' => bcrypt($request->password)]);
        return response('');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agencies $agencies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agencies $agency)
    {
        $request->validate([
            'tradename' => 'required',
            'email' => ['required', 'email', 'unique:agencies,email,' . $agency->id],

        ]);

        $data = $request->only([
            'tradename',
            'email',
            'taxname',
            'taxcode',
            'owner',
            'address',
            'notes',
            'phone',
            'city_id',
            'typeagency_id'
        ]);

        if ($request->has('image')) {
            //Eliminar la vieja foto de perfil
            if ($agency->image != null) {
                Storage::disk('src')->delete($agency->image);
            }
            //Almacenar la nueva foto de perfil
            $image = $request->file('image')->store('agencies', 'src');
            $data['image'] = "src/$image";
        }


        //Almacenar los datos en la base de datos
        $agency->update($data);

        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $agency->id,
                        'socialmediaable_type' => 'App\Models\Agencies'
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
                    'documentable_id' => $agency->id,
                    'documentable_type' => 'App\Models\Agencies'
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
                        'documentable_id' => $agency->id,
                        'documentable_type' => 'App\Models\Agencies'
                    ]);
                }
            }
        }
        $agency->refresh();
        return new AgenciesResource($agency);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agencies $agency)
    {
        $agency->delete();

        return response()->json($agency);
    }

    public function restore(Agencies $agency)
    {
        $agency->restore();

        return response()->json($agency);
    }

    public function agencyByUser(Request $request)
    {
        $user = User::find($request->id);
        $agency = $user->agency()->get();

        return new AgenciesResource($agency);
    }
}
