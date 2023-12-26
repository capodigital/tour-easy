<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketsResource;
use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Tickets;
use App\Models\User;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($request)
    {
        $tickets = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $agency = Agencies::find($user->agency_id);
                $tickets = $agency->tours()->with(['itineraries.tickets'])->get()->pluck('itineraries')->collapse()->pluck('tickets')->collapse();
            } else
                $tickets = Tickets::all();
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
           
            $agency = Agencies::find($request->user()->id);
            $tickets = $agency->tours()->with(['itineraries.tickets'])->get()->pluck('itineraries')->collapse()->pluck('tickets')->collapse();

        } else {
            $artist = Artists::find($request->user()->id);
            $tickets = $artist->tours()->where('active', true)->with(['itineraries.tickets'])->get()->pluck('itineraries')->collapse()->pluck('tickets')->collapse();
        }

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
