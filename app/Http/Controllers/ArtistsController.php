<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArtistsResource;
use App\Models\Agencies;
use App\Models\Artists;
use App\Models\Socialmedias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artists::withTrashed()->whereNull('deleted_at')->get();
        return ArtistsResource::collection($artists);
    }
    public function all()
    {
        $artists = Artists::withTrashed()->get();
        return ArtistsResource::collection($artists);
    }
    public function deleted()
    {
        $artists = Artists::onlyTrashed()->get();
        return ArtistsResource::collection($artists);
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
            'email' => 'required|email|unique:artists',
            'password' => [
                'required',
                'string',
            ],
            'image' => ['required', 'image'],
            'confirm_password' => 'required|same:password'

        ]);

        $data = $request->only(['stagename', 'email', 'lastname', 'name', 'birthday', 'tags']);

        $data['password'] = bcrypt($request->password);
        $data['agency_id'] = $request->user()->id;
        $image = $request->file('image')->store('artists');
        $data['image'] = $image;

        //Almacenar los datos en la base de datos
        $artist = Agencies::create($data);

        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typeredes_id' => $socialmedia->typeredes_id,
                'socialmediaable_id' => $artist->id,
                'socialmediaable_type' => 'App\Models\Artists'
            ]);
        }

        $artist->refresh();
        return new ArtistsResource($artist);
    }

    /**
     * Display the specified resource.
     */
    public function show(Artists $artists)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artists $artists)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artists $artist)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:artists,email,' . $artist->id],
            
        ]);

        $data = $request->only(['stagename', 'email', 'lastname', 'name', 'birthday', 'tags']);

        if ($request->has('image')) {
            //Eliminar la vieja foto de perfil
            Storage::disk('src')->delete($artist->image);
            //Almacenar la nueva foto de perfil
            $image = $request->file('image')->store('girls');
            $data['image'] = $image;
        }
       
        //Almacenar los datos en la base de datos
        $artist->update($data);
        
        Socialmedias::where('socialmediaable_id', $artist->id)->delete();
        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typeredes_id' => $socialmedia->typeredes_id,
                'socialmediaable_id' => $artist->id,
                'socialmediaable_type' => 'App\Models\Artists'
            ]);
        }

        $artist->refresh();
        return new ArtistsResource($artist);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artists $artist)
    {
        $artist->delete();

        return response()->json($artist);
    }
    public function restore(Artists $artist)
    {
        $artist->restore();

        return response()->json($artist);
    }

    public function artistsByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $artists = $agency->artists()->get();

        return response()->json($artists);
    }
}
