<?php

namespace App\Http\Controllers;

use App\Http\Resources\SuppliersResource;
use App\Models\Documents;
use App\Models\Socialmedias;
use App\Models\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Suppliers::all();
        return SuppliersResource::collection($suppliers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
           

        ]);

        $data = $request->only([
            'company_name', 'supplier_name', 'tax_code', 'address', 'notes', 'extra_phone',
            'phone', 'email', 'contact_manager', 'contact_phone', 'contact_email', 'city_id'
        ]);

        $data['agency_id'] = $request->user()->id;

        //Almacenar los datos en la base de datos
        $supplier = Suppliers::create($data);

        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typeredes_id' => $socialmedia->typeredes_id,
                'socialmediaable_id' => $supplier->id,
                'socialmediaable_type' => 'App\Models\Suppliers'
            ]);
        }
        foreach ($request->documents as $document) {
            Documents::create([
                'url' => $document->url,
                'name' => $document->name,
                'document_path' => $document->document_path,
                'size' => $document->size,
                'ext' => $document->ext,
                'documentable_id' => $supplier->id,
                'documentable_type' => 'App\Models\Suppliers'
            ]);
        }

        $supplier->refresh();
        return new SuppliersResource($supplier);
    }

    /**
     * Display the specified resource.
     */
    public function show(Suppliers $suppliers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suppliers $suppliers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suppliers $suppliers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suppliers $suppliers)
    {
        //
    }
}
