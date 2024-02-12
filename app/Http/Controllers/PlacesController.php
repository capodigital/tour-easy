<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlacesResource;
use App\Models\Agencies;
use App\Models\Documents;
use App\Models\Places;
use App\Models\Socialmedias;
use App\Models\User;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $places = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $places = Agencies::find($user->agency_id)->places()->get();
            } else
                $places = places::withTrashed()->whereNull('deleted_at')->get();
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
            $places = Agencies::where('id', $request->user()->id)->first()->places()->get();
        } else {
            $places[] = places::find($request->user()->id);
        }

        return PlacesResource::collection($places);
    }
    public function all()
    {
        $places = Places::withTrashed()->get();
        return PlacesResource::collection($places);
    }
    public function deleted()
    {
        $places = Places::onlyTrashed()->get();
        return PlacesResource::collection($places);
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

        ]);

        $data = $request->only([
            'name', 'google_id', 'phone', 'extra_phone', 'manager', 'email',
            'gis', 'notes', 'address', 'typeplace_id', 'city_id', 'agency_id'
        ]);
        if (!$request->has('agency_id')) {
            if ($request->user()->getMorphClass() == 'App\\Models\\User') {
                $data['agency_id'] = $request->user()->agency_id;
            } else {
                $data['agency_id'] = $request->user()->id;
            }
        }

        //Almacenar los datos en la base de datos
        $place = Places::create($data);

        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $place->id,
                        'socialmediaable_type' => 'App\Models\Places'
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
                    'documentable_id' => $place->id,
                    'documentable_type' => 'App\Models\Places'
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
                    'documentable_id' => $place->id,
                    'documentable_type' => 'App\Models\Places'
                ]);
            }
        }

        $place->refresh();
        return new PlacesResource($place);
    }

    /**
     * Display the specified resource.
     */
    public function show(Places $places)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Places $places)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Places $place)
    {
        $request->validate([
            'name' => 'required',

        ]);

        $data = $request->only([
            'name', 'google_id', 'phone', 'extra_phone', 'manager', 'email',
            'gis', 'notes', 'address', 'typeplace_id', 'city_id', 'agency_id'
        ]);


        //Almacenar los datos en la base de datos
        $place->update($data);

        if ($request->has('socialmedias')) {
            Socialmedias::where('socialmediaable_id',$place->id)->delete();
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $place->id,
                        'socialmediaable_type' => 'App\Models\Places'
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
                    'documentable_id' => $place->id,
                    'documentable_type' => 'App\Models\Places'
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
                        'documentable_id' => $place->id,
                        'documentable_type' => 'App\Models\Places'
                    ]);
                }
            }
        }

        $place->refresh();
        return new PlacesResource($place);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Places $place)
    {
        $place->delete();

        return response()->json($place);
    }
    public function restore(Places $place)
    {
        $place->restore();

        return response()->json($place);
    }

    public function placesByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $places = $agency->places()->get();

        return PlacesResource::collection($places);
    }
}
