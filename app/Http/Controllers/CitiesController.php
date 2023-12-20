<?php

namespace App\Http\Controllers;

use App\Http\Resources\CitiesResource;
use App\Http\Resources\CountriesResource;
use App\Models\Cities;
use App\Models\Countries;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
    public function show(Cities $cities)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cities $cities)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cities $cities)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cities $cities)
    {
        //
    }

    public function citiesByCountry(Request $request)
    {
        $country = Countries::where('code',$request->code)->first();
        $cities = $country->cities()->get()->sortBy('name');

        return response()->json($cities);
    }

}
