<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItinerariesResource;
use App\Models\Itineraries;
use App\Models\Tours;
use Illuminate\Http\Request;

class ItinerariesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itineraries = Itineraries::all();
        return ItinerariesResource::collection($itineraries);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Itineraries $itineraries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itineraries $itineraries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itineraries $itineraries)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itineraries $itineraries)
    {
        //
    }

    public function itinerariesByTour(Request $request)
    {
        $tour = Tours::find($request->id);
        $itineraries = $tour->itineraries()->orderBy('startdate')->get();

        return ItinerariesResource::collection($itineraries);
    }
}
