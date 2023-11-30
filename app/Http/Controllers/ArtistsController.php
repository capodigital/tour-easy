<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistsResource;
use App\Models\Artists;
use Illuminate\Http\Request;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artists::all();
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
            'name' => 'name',

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artists $artists)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artists $artists)
    {
        //
    }
}
