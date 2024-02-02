<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToursResource;
use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Documents;
use App\Models\Photos;
use App\Models\Socialmedias;
use App\Models\TourContact;
use App\Models\Tours;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tours = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $tours = Agencies::find($user->agency_id)->tours()->get()->sortBy('startdate');
            } else
                $tours = Tours::withTrashed()->get()->sortBy('startdate');
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
            $tours = Agencies::find($request->user()->id)->tours()->get()->sortBy('startdate');
        } else {
            $tours = Tours::where('artist_id', $request->user()->id)->get();
        }

        return ToursResource::collection($tours);
    }

    /**
     * Display a listing of the resource.
     */
    public function landing(Request $request)
    {
        return ToursResource::collection(Tours::where('active', 1)->get());
    }

    public function all()
    {
        $tours = Tours::withTrashed()->orderBy('startdate')->get()->sortBy('startdate');
        return ToursResource::collection($tours);
    }
    public function deleted()
    {
        $tours = Tours::onlyTrashed()->orderBy('startdate')->get()->sortBy('startdate');
        return ToursResource::collection($tours);
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

        $rules = [
            'tourname' => 'required',
            'tourcartel' => ['required', 'image'],
            'startdate' => 'date|after_or_equal:today'

        ];

        $customMessages = [
            'startdate.after_or_equal' => 'El campo fecha debe ser una fecha posterior a hoy',
        ];

        $request->validate($rules, $customMessages);

        $data = $request->only([
            'tourname',
            'startdate',
            'enddate',
            'artist_id',
            'notes',
            'spotify_list',
            'youtube_list'
        ]);

        if (Carbon::parse($request->startdate) > Carbon::parse($request->enddate)) {
            throw ValidationException::withMessages([
                'enddate' => ['La fecha de fin no puede ser menor que la fecha de inicio.'],
            ]);
        }

        if (!$request->has('agency_id')) {
            if ($request->user()->getMorphClass() == 'App\\Models\\User') {
                $data['agency_id'] = $request->user()->agency_id;
            } else {
                $data['agency_id'] = $request->user()->id;
            }
        }
        $data['active'] = true;
        $image = $request->file('tourcartel')->store('tours', 'src');
        $data['tourcartel'] = "src/$image";

        //Almacenar los datos en la base de datos
        $tour = Tours::create($data);

        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $tour->id,
                        'socialmediaable_type' => 'App\Models\Tours'
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
                    'documentable_id' => $tour->id,
                    'documentable_type' => 'App\Models\Tours'
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
                        'documentable_id' => $tour->id,
                        'documentable_type' => 'App\Models\Tours'
                    ]);
                }
            }
        }

        $tour->refresh();
        return new ToursResource($tour);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tours $tour)
    {
        return response()->json($tour);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tours $tours)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tours $tour)
    {
        $rules = [
            'tourname' => 'required',
            'startdate' => 'date|after_or_equal:today'

        ];

        $customMessages = [
            'startdate.after_or_equal' => 'El campo fecha debe ser una fecha posterior a hoy',
        ];

        $request->validate($rules, $customMessages);


        if (Carbon::parse($request->startdate) > Carbon::parse($request->enddate)) {
            throw ValidationException::withMessages([
                'enddate' => ['La fecha de fin no puede ser menor que la fecha de inicio.'],
            ]);
        }

        $data = $request->only([
            'tourname',
            'startdate',
            'enddate',
            'artist_id',
            'notes',
            'spotify_list',
            'youtube_list'
        ]);
        if ($request->has('tourcartel')) {
            //Eliminar la vieja foto de perfil
            Storage::disk('src')->delete($tour->tourcartel);
            //Almacenar la nueva foto de perfil
            $image = $request->file('tourcartel')->store('tours');
            $data['tourcartel'] = "src/$image";
        }


        //Almacenar los datos en la base de datos
        $tour->update($data);

        if ($request->has('socialmedias')) {
            Socialmedias::where('socialmediaable_id', $tour->id)->delete();
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $tour->id,
                        'socialmediaable_type' => 'App\Models\Tours'
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
                    'documentable_id' => $tour->id,
                    'documentable_type' => 'App\Models\Tours'
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
                        'documentable_id' => $tour->id,
                        'documentable_type' => 'App\Models\Tours'
                    ]);
                }
            }
        }

        $tour->refresh();
        return new ToursResource($tour);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tours $tour)
    {
        $tour->delete();

        return response()->json($tour);
    }
    public function restore(Tours $tour)
    {
        $tour->restore();

        return response()->json($tour);
    }

    public function toursByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);

        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $tours = Tours::all()->sortBy('startdate');
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
            $tours = $agency->tours()->get()->sortBy('startdate');
        } else {
            $artist = Artists::find($request->user()->id);
            $tours = $artist->tours()->get()->sortBy('startdate');
        }


        return ToursResource::collection($tours);
    }

    public function tour(Request $request)
    {
        $tour = Tours::find($request->id);

        return new ToursResource($tour);
    }
    public function noactive(Request $request)
    {
        $tour = Tours::find($request->id);

        $tour->active = false;
        $tour->save();
        $tour->refresh();
        return new ToursResource($tour);
    }
    public function photos(Request $request)
    {
        $agency_id = $request->agency_id;
        foreach ($request->photos as $photo) {
            $image = $photo->store('documents', 'photo');
            $photo1 = new Photos();
            $photo1->url = "src/$image";
            $photo1->agency_id = $agency_id;
            $photo1->save();
        }
    }
    public function contacts(Request $request)
    {

        $tour = Tours::find($request->tour_id);
        // $tour->persons()->detach();
        TourContact::where('tour_id', $tour->id)->delete();
        foreach ($request->contacts as $contact) {
            TourContact::create([
                'tour_id' => $tour->id,
                'person_id' => $contact
            ]);
            // $tour->persons()->attach($contact);
        }
        // $tour->persons()->sync($request->contacts);
        $tour->refresh();
        return new ToursResource($tour);
    }
}
