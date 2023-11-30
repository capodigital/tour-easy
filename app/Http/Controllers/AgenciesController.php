<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgenciesResource;
use App\Models\Agencies;
use Illuminate\Http\Request;

class AgenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $agencies = Agencies::all();
        return AgenciesResource::collection($agencies);
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
    public function show(Agencies $agencies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agencies $agencies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agencies $agencies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agencies $agencies)
    {
        //
    }
}
