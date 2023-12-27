<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItinerariesResource;
use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Itineraries;
use App\Models\Tours;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItinerariesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($request)
    {
        $itineraries = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $agency = Agencies::find($user->agency_id);
                $itineraries = $agency->tours()->with('itineraries')->get();
            } else
                $itineraries = Itineraries::all();
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {

            $agency = Agencies::find($request->user()->id);
            $itineraries = $agency->tours()->with('itineraries')->get();
        } else {
            $artist = Artists::find($request->user()->id);
            $itineraries = $artist->tours()->with('itineraries')->get();
        }

        return ItinerariesResource::collection($itineraries);
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

        if(Carbon::parse($request->startdate) > Carbon::parse($request->enddate)) {
            throw ValidationException::withMessages([
                'enddate' => ['La fecha de fin no puede ser menor que la fecha de inicio.'],
            ]);
        }

        $itinerary = new Itineraries($request->input());
        $itinerary->save();

        $itinerary->refresh();



        return new ItinerariesResource($itinerary);
    }

    /**
     * Display the specified resource.
     */
    public function show(Itineraries $itineraries)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Itineraries $itineraries)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Itineraries $itinerary)
    {
        $request->validate([
            'name' => 'required',
        ]);
        if(Carbon::parse($request->startdate) > Carbon::parse($request->enddate)) {
            throw ValidationException::withMessages([
                'enddate' => ['La fecha de fin no puede ser menor que la fecha de inicio.'],
            ]);
        }
        $itinerary->update($request->all());

        return new ItinerariesResource($itinerary);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Itineraries $itinerary)
    {
        $itinerary->delete();

        return response()->json($itinerary);
    }

    public function itinerariesByTour(Request $request)
    {
        $tour = Tours::find($request->id);
        $itineraries = $tour->itineraries()->get()->sortBy('startdate');

        return ItinerariesResource::collection($itineraries);
    }

    public function month(Request $request, $month, $year)
    {
        $itineraries = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $agency = Agencies::find($user->agency_id);
                $itineraries = $agency->tours()->with(['itineraries' => function ($query) use ($month, $year) {
                    $query->whereMonth('startdate', $month)->whereYear('startdate', $year);
                }])->get()
                ->pluck('itineraries')->collapse();
            } else
                $itineraries = Itineraries::whereYear('startdate', $year)->whereMonth('startdate', $month)->get();
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {

            $agency = Agencies::find($request->user()->id);
            $itineraries = $agency->tours()->with(['itineraries' => function ($query) use ($month, $year) {
                $query->whereMonth('startdate', $month)->whereYear('startdate', $year);
            }])
                ->get()
                ->pluck('itineraries')->collapse();
        } else {
            $artist = Artists::find($request->user()->id);
            $itineraries = $artist->tours()->with(['itineraries' => function ($query) use ($month, $year) {
                $query->whereMonth('startdate', $month)->whereYear('startdate', $year);
            }])->get()
                ->pluck('itineraries')->collapse();
        }
        return ItinerariesResource::collection($itineraries);
    }
    public function day(Request $request, $day, $month, $year)
    {
        $itineraries = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $agency = Agencies::find($user->agency_id);
                $itineraries = $agency->tours()->with(['itineraries' => function ($query) use ($month, $year, $day) {
                    $query->whereMonth('startdate', $month)->whereYear('startdate', $year)->whereDay('startdate', $day);
                }])->get()->pluck('itineraries')->collapse();
            } else
                $itineraries = Itineraries::whereYear('startdate', $year)->whereMonth('startdate', $month)->whereDay('startdate', $day)->get();
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {

            $agency = Agencies::find($request->user()->id);
            $itineraries = $agency->tours()->with(['itineraries' => function ($query) use ($month, $year, $day) {
                    $query->whereMonth('startdate', $month)->whereYear('startdate', $year)->whereDay('startdate', $day);
                }])->get()->pluck('itineraries')->collapse();
        } else {
            $artist = Artists::find($request->user()->id);
            $itineraries = $artist->tours()->with(['itineraries' => function ($query) use ($month, $year, $day) {
                    $query->whereMonth('startdate', $month)->whereYear('startdate', $year)->whereDay('startdate', $day);
                }])->get()->pluck('itineraries')->collapse();
        }
        return ItinerariesResource::collection($itineraries);
    }
}
