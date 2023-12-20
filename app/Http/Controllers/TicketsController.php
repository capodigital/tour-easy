<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketsResource;
use App\Models\Tickets;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Tickets::all();
        return TicketsResource::collection($tickets);
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
            'name' => 'required',
        ]);

       $ticket = new Tickets($request->input());
       $ticket->save();

       $ticket->refresh();
        

      
        return new TicketsResource($ticket);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tickets $tickets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tickets $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tickets $ticket)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $ticket->update($request->all());

        return new TicketsResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tickets $ticket)
    {
        $ticket->delete();

        return response()->json($ticket);
    }
}
