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

        $data = $request->only(['name', 'google_id', 'phone', 'extra_phone', 'manager', 'email',
        'gis', 'notes', 'address', 'typeplace_id', 'city_id']);

        $data['agency_id'] = $request->user()->id;
        //Almacenar los datos en la base de datos
        $place = Places::create($data);

        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typeredes_id' => $socialmedia->typeredes_id,
                'socialmediaable_id' => $place->id,
                'socialmediaable_type' => 'App\Models\Places'
            ]);
        }
        foreach ($request->documents as $document) {
            Documents::create([
                'url' => $document->url,
                'name' => $document->name,
                'document_path' => $document->document_path,
                'size' => $document->size,
                'ext' => $document->ext,
                'documentable_id' => $place->id,
                'documentable_type' => 'App\Models\Places'
            ]);
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

        $data = $request->only(['name', 'google_id', 'phone', 'extra_phone', 'manager', 'email',
        'gis', 'notes', 'address', 'typeplace_id', 'city_id']);
       
       
        //Almacenar los datos en la base de datos
        $place->update($data);
        
        Socialmedias::where('socialmediaable_id', $place->id)->delete();
        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typeredes_id' => $socialmedia->typeredes_id,
                'socialmediaable_id' => $place->id,
                'socialmediaable_type' => 'App\Models\Places'
            ]);
        }
        Documents::where('documentable_id', $place->id)->delete();
        foreach ($request->documents as $document) {
            Documents::create([
                'url' => $document->url,
                'name' => $document->name,
                'document_path' => $document->document_path,
                'size' => $document->size,
                'ext' => $document->ext,
                'documentable_id' => $place->id,
                'documentable_type' => 'App\Models\Places'
            ]);
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
