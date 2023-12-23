<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlacesResource;
use App\Models\Agencies;
use App\Models\Documents;
use App\Models\Places;
use App\Models\Socialmedias;
use Illuminate\Http\Request;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Places::all();
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
        if(!$request->has('agency_id')) {
            $data['agency_id'] = $request->user()->id;
        }

        //Almacenar los datos en la base de datos
        $place = Places::create($data);

        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                Socialmedias::create([
                    'url' => $socialmedia['url'],
                    'description' => $socialmedia['description'],
                    'typeredes_id' => $socialmedia['typeredes_id'],
                    'socialmediaable_id' => $place->id,
                    'socialmediaable_type' => 'App\Models\Places'
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
            foreach ($request->socialmedias as $socialmedia) {
                Socialmedias::create([
                    'url' => $socialmedia['url'],
                    'description' => $socialmedia['description'],
                    'typeredes_id' => $socialmedia['typeredes_id'],
                    'socialmediaable_id' => $place->id,
                    'socialmediaable_type' => 'App\Models\Places'
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
     * Remove the specified resource from storage.
     */
    public function destroy(Places $place)
    {
        $place->delete();

        return response()->json($place);
    }

    public function placesByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $places = $agency->places()->get();

        return PlacesResource::collection($places);
    }
}
