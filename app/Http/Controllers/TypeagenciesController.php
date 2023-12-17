<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeagenciesResource;
use App\Models\Typeagencies;
use Illuminate\Http\Request;

class TypeagenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeagency = Typeagencies::all();
        return TypeagenciesResource::collection($typeagency);
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
    public function show(Typeagencies $typeagencies)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Typeagencies $typeagencies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Typeagencies $typeagencies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Typeagencies $typeagencies)
    {
        //
    }
}
