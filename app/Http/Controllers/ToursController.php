<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToursResource;
use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Documents;
use App\Models\Photos;
use App\Models\Socialmedias;
use App\Models\Tours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tours = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $tours = Tours::withTrashed()->whereNull('deleted_at')->get()->sortBy('startdate');
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
            $tours[] = Agencies::find($request->user()->id)->tours()->get();
        } else {
            $tours[] = Tours::find($request->user()->id);
        }
        
        return ToursResource::collection($tours);
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
        $request->validate([
            'tourname' => 'required',
            'tourcartel' => ['required', 'image'],


        ]);

        $data = $request->only([
            'tourname', 'startdate', 'enddate', 'artist_id', 'notes',
            'spotify_list', 'youtube_list'
        ]);

        $data['agency_id'] = $request->agency_id;
        $image = $request->file('tourcartel')->store('tours', 'src');
        $data['tourcartel'] = "src/$image";

        //Almacenar los datos en la base de datos
        $tour = Tours::create($data);

        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                Socialmedias::create([
                    'url' => $socialmedia['url'],
                    'description' => $socialmedia['description'],
                    'typeredes_id' => $socialmedia['typeredes_id'],
                    'socialmediaable_id' => $tour->id,
                    'socialmediaable_type' => 'App\Models\Tours'
                ]);
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
        $request->validate([
            'tourname' => 'required',
        ]);

        $data = $request->only([
            'tourname', 'startdate', 'enddate', 'artist_id', 'notes',
            'spotify_list', 'youtube_list'
        ]);
        if ($request->has('tourcartel')) {
            //Eliminar la vieja foto de perfil
            Storage::disk('src')->delete($tour->tourcartel);
            //Almacenar la nueva foto de perfil
            $image = $request->file('tourcartel')->store('tours');
            $data['tourcartel'] = $image;
        }

        //Almacenar los datos en la base de datos
        $tour->update($data);

        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                Socialmedias::create([
                    'url' => $socialmedia['url'],
                    'description' => $socialmedia['description'],
                    'typeredes_id' => $socialmedia['typeredes_id'],
                    'socialmediaable_id' => $tour->id,
                    'socialmediaable_type' => 'App\Models\Tours'
                ]);
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
}
