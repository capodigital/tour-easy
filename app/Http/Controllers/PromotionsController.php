<?php

namespace App\Http\Controllers;

use App\Http\Resources\PromotionsResource;
use App\Models\Documents;
use App\Models\Promotions;
use App\Models\Socialmedias;
use Illuminate\Http\Request;

class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promotions = Promotions::all();
        return PromotionsResource::collection($promotions);
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
            'platform' => 'required',
            

        ]);

        $data = $request->only(['platform', 'notes', 'itinerary_id', 'tour_id']);

       

        //Almacenar los datos en la base de datos
        $promotion = Promotions::create($data);

        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typesocialmedia_id' => $socialmedia->typesocialmedia_id,
                'socialmediaable_id' => $promotion->id,
                'socialmediaable_type' => 'App\Models\Promotions'
            ]);
        }
        foreach ($request->documents as $document) {
            Documents::create([
                'url' => $document->url,
                'name' => $document->name,
                'document_path' => $document->document_path,
                'size' => $document->size,
                'ext' => $document->ext,
                'documentable_id' => $promotion->id,
                'documentable_type' => 'App\Models\Promotions'
            ]);
        }

        $promotion->refresh();
        return new PromotionsResource($promotion);
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotions $promotions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotions $promotions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotions $promotion)
    {
        $request->validate([
            'platform' => 'required',
            
        ]);

        $data = $request->only(['platform', 'notes', 'itinerary_id', 'tour_id']);

      
       
        //Almacenar los datos en la base de datos
        $promotion->update($data);
        
        Socialmedias::where('socialmediaable_id', $promotion->id)->delete();
        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typesocialmedia_id' => $socialmedia->typesocialmedia_id,
                'socialmediaable_id' => $promotion->id,
                'socialmediaable_type' => 'App\Models\Promotions'
            ]);
        }
        Documents::where('documentable_id', $promotion->id)->delete();
        foreach ($request->documents as $document) {
            Documents::create([
                'url' => $document->url,
                'name' => $document->name,
                'document_path' => $document->document_path,
                'size' => $document->size,
                'ext' => $document->ext,
                'documentable_id' => $promotion->id,
                'documentable_type' => 'App\Models\Promotions'
            ]);
        }

        $promotion->refresh();
        return new PromotionsResource($promotion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotions $promotion)
    {
        $promotion->delete();

        return response()->json($promotion);
    }
}
