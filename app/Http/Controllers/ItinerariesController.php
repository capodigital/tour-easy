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
        $request->validate([
            'name' => 'required',
        ]);

       $itinerary = new Itineraries($request->input());
       $itinerary->save();

       $itinerary->refresh();
        

      
        return new ItinerariesResource($itinerary);
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
    public function update(Request $request, Itineraries $itinerary)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $itinerary->update($request->all());

        return new ItinerariesResource($itinerary);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itineraries $itinerary)
    {
        $itinerary->delete();

        return response()->json($itinerary);
    }

    public function itinerariesByTour(Request $request)
    {
        $tour = Tours::find($request->id);
        $itineraries = $tour->itineraries()->get()->sortBy('startdate');

        return ItinerariesResource::collection($itineraries);
    }

    public function month(Request $request, $month, $year)
    {
        return ItinerariesResource::collection(Itineraries::whereYear('startdate', $year)->whereMonth('startdate', $month)->get());
    }
    public function day(Request $request, $day, $month, $year)
    {
        return ItinerariesResource::collection(Itineraries::whereYear('startdate', $year)->whereMonth('startdate', $month)->whereDay('startdate', $day)->get());
    }
}
