<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistsResource;
use App\Models\Agencies;
use App\Models\Artists;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artists::withTrashed()->whereNull('deleted_at')->get();
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

        ]);

        $artist = new Artists($request->input());
        $artist->save();

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
            
        ]);

        $artist->update($request->all());
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

        return response()->json($artists);
    }
}
