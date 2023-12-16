<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToursResource;
use App\Models\Agencies;
use App\Models\Tours;
use Illuminate\Http\Request;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tours = Tours::withTrashed()->whereNull('deleted_at')->get()->orderBy('startdate');
        return ToursResource::collection($tours);
    }
    public function all()
    {
        $tours = Tours::withTrashed()->get()->orderBy('startdate');
        return ToursResource::collection($tours);
    }
    public function deleted()
    {
        $tours = Tours::onlyTrashed()->get()->orderBy('startdate');
        return ToursResource::collection($tours);
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
    public function show(Tours $tour)
    {
        return response()->json($tour);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tours $tours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tours $tours)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tours $tour)
    {
        $tour->delete();

        return response()->json($tour);
    }
    public function restore(Tours $tour)
    {
        $tour->restore();

        return response()->json($tour);
    }

    public function toursByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $tours = $agency->tours()->get()->orderBy('startdate');

        return ToursResource::collection($tours);
    }
}
