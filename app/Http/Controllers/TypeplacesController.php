<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeplacesResource;
use App\Models\Typeplaces;
use Illuminate\Http\Request;

class TypeplacesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeplaces = Typeplaces::all();
        return TypeplacesResource::collection($typeplaces);
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
    public function show(Typeplaces $typeplaces)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Typeplaces $typeplaces)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Typeplaces $typeplaces)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Typeplaces $typeplaces)
    {
        //
    }
}
