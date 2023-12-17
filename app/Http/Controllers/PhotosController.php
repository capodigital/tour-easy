<?php

namespace App\Http\Controllers;

use App\Http\Resources\PhotosResource;
use App\Models\Photos;
use App\Models\Tours;
use Illuminate\Http\Request;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photos::all();
        return PhotosResource::collection($photos);
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
    public function show(Photos $photos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photos $photos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Photos $photos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photos $photos)
    {
        //
    }

    public function photosByTour(Request $request)
    {
        $tour = Tours::find($request->id);
        $photos = $tour->photos()->get();

        return PhotosResource::collection($photos);
    }
}
