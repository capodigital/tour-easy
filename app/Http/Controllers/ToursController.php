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
        $tours = Tours::all();
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
    public function show(Tours $tours)
    {
        //
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
    public function destroy(Tours $tours)
    {
        //
    }

    public function toursByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $tours = $agency->tours()->get();

        return ToursResource::collection($tours);
    }
}
