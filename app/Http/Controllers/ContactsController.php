<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContactsResource;
use App\Models\Agencies;
use App\Models\Contacts;
use App\Models\Documents;
use App\Models\Socialmedias;
use App\Models\Tours;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contacts::all();
        return ContactsResource::collection($contacts);
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
            'name' => 'required',

        ]);

        $data = $request->only([
            'birthday', 'name', 'lastname', 'notes', 'extra_phone', 'phone',
            'email', 'lang', 'position', 'notify', 'typecontact_id', 'city_id'
        ]);

        $data['agency_id'] = $request->user()->id;
        //Almacenar los datos en la base de datos
        $contact = Contacts::create($data);


        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                Socialmedias::create([
                    'url' => $socialmedia->url,
                    'description' => $socialmedia->description,
                    'typeredes_id' => $socialmedia->typeredes_id,
                    'socialmediaable_id' => $contact->id,
                    'socialmediaable_type' => 'App\Models\Contacts'
                ]);
            }
        }
        if ($request->has('documents')) {
            foreach ($request->documents as $document) {
                $sizeInBytes = $document->getSize();
                $sizeInMB = $sizeInBytes / 1024 / 1024;
                $extension = $document->getClientOriginalExtension();
                Documents::create([
                    'url' => null,
                    'name' => $document->name,
                    'document_path' => $document->document_path,
                    'size' => $sizeInMB,
                    'ext' => $extension,
                    'documentable_id' => $contact->id,
                    'documentable_type' => 'App\Models\Contacts'
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
                    'documentable_id' => $contact->id,
                    'documentable_type' => 'App\Models\Contacts'
                ]);
            }
        }



        $contact->refresh();
        return new ContactsResource($contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contacts $contacts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contacts $contacts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contacts $contact)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->only([
            'birthday', 'name', 'lastname', 'notes', 'extra_phone', 'phone',
            'email', 'lang', 'position', 'notify', 'typecontact_id', 'city_id'
        ]);

        //Almacenar los datos en la base de datos
        $contact->update($data);

        Socialmedias::where('socialmediaable_id', $contact->id)->delete();
        foreach ($request->socialmedias as $socialmedia) {
            Socialmedias::create([
                'url' => $socialmedia->url,
                'description' => $socialmedia->description,
                'typeredes_id' => $socialmedia->typeredes_id,
                'socialmediaable_id' => $contact->id,
                'socialmediaable_type' => 'App\Models\Contacts'
            ]);
        }
        Documents::where('documentable_id', $contact->id)->delete();
        foreach ($request->documents as $document) {
            $sizeInBytes = $document->getSize();
            $sizeInMB = $sizeInBytes / 1024 / 1024;
            $extension = $document->getClientOriginalExtension();
            Documents::create([
                'url' => null,
                'name' => $document->name,
                'document_path' => $document->document_path,
                'size' => $sizeInMB,
                'ext' => $extension,
                'documentable_id' => $contact->id,
                'documentable_type' => 'App\Models\Contacts'
            ]);
        }
        foreach ($request->urls as $url) {
            Documents::create([
                'url' => $url,
                'name' => null,
                'document_path' => null,
                'size' => null,
                'ext' => null,
                'documentable_id' => $contact->id,
                'documentable_type' => 'App\Models\Contacts'
            ]);
        }

        $contact->refresh();
        return new ContactsResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contacts $contact)
    {
        $contact->delete();

        return response()->json($contact);
    }

    public function contactsByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $contacts = $agency->contacts()->get();

        return ContactsResource::collection($contacts);
    }
    public function contactsByTour(Request $request)
    {
        $tour = Tours::find($request->id);
        $contacts = $tour->contacts()->get();

        return ContactsResource::collection($contacts);
    }
}
