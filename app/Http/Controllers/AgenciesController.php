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
            
        ]);

        $agency = new Agencies($request->input());
        $agency->save();

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
            
        ]);

        $agency->update($request->all());
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
}
