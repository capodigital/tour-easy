<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgenciesResource;
use App\Models\Agencies;
use App\Models\Documents;
use App\Models\Socialmedias;
use App\Models\User;
use Illuminate\Http\Request;

class AgenciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $agencies = Agencies::withTrashed()->whereNull('deleted_at')->get();
        return AgenciesResource::collection($agencies);
    }
    public function all()
    {

        $agencies = Agencies::withTrashed()->get();
        return AgenciesResource::collection($agencies);
    }
    public function deleted()
    {

        $agencies = Agencies::onlyTrashed()->get();
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
        $request->validate([
            'tradename' => 'required',
            'email' => 'required|email|unique:agencies',
            'password' => [
                'required',
                'string',
            ],
            'confirm_password' => 'required|same:password'
            
        ]);

        $data = $request->only(['tradename', 'email', 'taxname', 'taxcode', 'owner', 'address',
        'notes', 'phone', 'city_id', 'typeagency_id']);

        $data['password'] = bcrypt($request->password);
        //Almacenar los datos en la base de datos
        $agency = Agencies::create($data);

        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typeredes_id' => $socialmedia->typeredes_id,
                'socialmediaable_id' => $agency->id,
                'socialmediaable_type' => 'App\Models\Agencies'
            ]);
        }
        foreach ($request->documents as $document) {
            Documents::create([
                'url' => $document->url,
                'name' => $document->name,
                'document_path' => $document->document_path,
                'size' => $document->size,
                'ext' => $document->ext,
                'documentable_id' => $agency->id,
                'documentable_type' => 'App\Models\Agencies'
            ]);
        }

        $agency->refresh();
        return new AgenciesResource($agency);
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
    public function update(Request $request, Agencies $agency)
    {
        $request->validate([
            'tradename' => 'required',
            'email' => ['required', 'email', 'unique:agencies,email,' . $agency->id],
            
        ]);

        $data = $request->only(['tradename', 'email', 'taxname', 'taxcode', 'owner', 'address',
        'notes', 'phone', 'city_id', 'typeagency_id']);

       
        //Almacenar los datos en la base de datos
        $agency->update($data);
        
        Socialmedias::where('socialmediaable_id', $agency->id)->delete();
        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typeredes_id' => $socialmedia->typeredes_id,
                'socialmediaable_id' => $agency->id,
                'socialmediaable_type' => 'App\Models\Agencies'
            ]);
        }
        Documents::where('documentable_id', $agency->id)->delete();
        foreach ($request->documents as $document) {
            Documents::create([
                'url' => $document->url,
                'name' => $document->name,
                'document_path' => $document->document_path,
                'size' => $document->size,
                'ext' => $document->ext,
                'documentable_id' => $agency->id,
                'documentable_type' => 'App\Models\Agencies'
            ]);
        }

        $agency->refresh();
        return new AgenciesResource($agency);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agencies $agency)
    {
        $agency->delete();

        return response()->json($agency);
    }

    public function restore(Agencies $agency)
    {
        $agency->restore();

        return response()->json($agency);
    }

    public function agencyByUser(Request $request)
    {
        $user = User::find($request->id);
        $agency = $user->agency()->get();

        return new AgenciesResource($agency);
    }
}
