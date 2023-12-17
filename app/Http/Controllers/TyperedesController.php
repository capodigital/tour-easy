<?php

namespace App\Http\Controllers;

use App\Http\Resources\TyperedesResource;
use App\Models\Typeredes;
use Illuminate\Http\Request;

class TyperedesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeredes = Typeredes::all();
        return TyperedesResource::collection($typeredes);
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
    public function show(Typeredes $typeredes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Typeredes $typeredes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Typeredes $typeredes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Typeredes $typeredes)
    {
        //
    }
}
