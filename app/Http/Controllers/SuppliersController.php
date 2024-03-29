<?php

namespace App\Http\Controllers;

use App\Http\Resources\SuppliersResource;
use App\Models\Agencies;
use App\Models\Documents;
use App\Models\Socialmedias;
use App\Models\Suppliers;
use App\Models\User;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $suppliers = Agencies::find($user->agency_id)->suppliers()->get();
            } else
                $suppliers = suppliers::withTrashed()->whereNull('deleted_at')->get();
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
            $suppliers = Agencies::where('id', $request->user()->id)->first()->suppliers()->get();
        } else {
            $suppliers[] = suppliers::find($request->user()->id);
        }
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
        // $request->validate([
        //     'company_name' => 'required',


        // ]);

        $data = $request->only([
            'agency_id',
            'tradename',
            'email',
            'address',
            'notes',
            'extra_phone',
            'phone',
            'email',
            'manager',
            'manager_phone',
            'manager_email',
            'contact',
            'contact_phone',
            'contact_email',
            'city_id',
            'paydata',
            'taxname',
            'taxcode'
        ]);

        // $data['agency_id'] = $request->user()->id;

        //Almacenar los datos en la base de datos
        $supplier = Suppliers::create($data);

        if ($request->has('socialmedias')) {
            Socialmedias::where('socialmediaable_id', $supplier->id)->delete();
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $supplier->id,
                        'socialmediaable_type' => 'App\Models\Suppliers'
                    ]);
                }
            }
        }

        if ($request->has('documents')) {
            foreach ($request->file('documents') as $document) {
                $sizeInBytes = $document->getSize();
                $sizeInMB = $sizeInBytes / 1024 / 1024;
                $extension = $document->getClientOriginalExtension();
                $name = $document->getClientOriginalName();
                $path = $document->store('documents', 'src');
                Documents::create([
                    'url' => null,
                    'name' => $name,
                    'document_path' => $path,
                    'size' => $sizeInMB,
                    'ext' => $extension,
                    'documentable_id' => $supplier->id,
                    'documentable_type' => 'App\Models\Suppliers'
                ]);
            }
        }

        if ($request->has('urls')) {
            foreach ($request->urls as $url) {
                if ($url != "") {
                    Documents::create([
                        'url' => $url,
                        'name' => null,
                        'document_path' => null,
                        'size' => null,
                        'ext' => null,
                        'documentable_id' => $supplier->id,
                        'documentable_type' => 'App\Models\Suppliers'
                    ]);
                }
            }
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
    public function update(Request $request, Suppliers $supplier)
    {
        $data = $request->only([
            'agency_id',
            'tradename',
            'email',
            'address',
            'notes',
            'extra_phone',
            'phone',
            'email',
            'manager',
            'manager_phone',
            'manager_email',
            'contact',
            'contact_phone',
            'contact_email',
            'city_id',
            'paydata',
            'taxname',
            'taxcode'
        ]);

        //Almacenar los datos en la base de datos
        $supplier->update($data);

        if ($request->has('socialmedias')) {
            Socialmedias::where('socialmediaable_id', $supplier->id)->delete();
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $supplier->id,
                        'socialmediaable_type' => 'App\Models\Suppliers'
                    ]);
                }
            }
        }

        if ($request->has('documents')) {
            foreach ($request->file('documents') as $document) {
                $sizeInBytes = $document->getSize();
                $sizeInMB = $sizeInBytes / 1024 / 1024;
                $extension = $document->getClientOriginalExtension();
                $name = $document->getClientOriginalName();
                $path = $document->store('documents', 'src');
                Documents::create([
                    'url' => null,
                    'name' => $name,
                    'document_path' => $path,
                    'size' => $sizeInMB,
                    'ext' => $extension,
                    'documentable_id' => $supplier->id,
                    'documentable_type' => 'App\Models\Suppliers'
                ]);
            }
        }

        if ($request->has('urls')) {
            foreach ($request->urls as $url) {
                if ($url != "") {
                    Documents::create([
                        'url' => $url,
                        'name' => null,
                        'document_path' => null,
                        'size' => null,
                        'ext' => null,
                        'documentable_id' => $supplier->id,
                        'documentable_type' => 'App\Models\Suppliers'
                    ]);
                }
            }
        }

        $supplier->refresh();
        return new SuppliersResource($supplier);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suppliers $supplier)
    {
        $supplier->delete();
        Socialmedias::where('socialmediaable_id', $supplier->id)->delete();
        Documents::where('documentable_id', $supplier->id)->delete();

        return response()->json($supplier);
    }

    public function suppliersByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $suppliers = $agency->suppliers()->get();

        return SuppliersResource::collection($suppliers);
    }
}
