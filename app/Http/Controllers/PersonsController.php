<?php

namespace App\Http\Controllers;

use App\Http\Resources\PersonsResource;
use App\Models\Agencies;
use App\Models\Documents;
use App\Models\Persons;
use App\Models\Socialmedias;
use App\Models\Tours;
use App\Models\User;
use Illuminate\Http\Request;

class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $persons = [];
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $user = User::find($request->user()->id);
            if ($user->agency_id != null) {
                $persons = Agencies::find($user->agency_id)->persons()->get();
            } else
                $persons = Persons::withTrashed()->whereNull('deleted_at')->get();
        } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
            $persons = Agencies::where('id', $request->user()->id)->first()->persons()->get();
        } else {
            $persons[] = Persons::find($request->user()->id);
        }

        return PersonsResource::collection($persons);

    }
    public function all()
    {
        $persons = Persons::withTrashed()->get();
        return PersonsResource::collection($persons);
    }
    public function deleted()
    {
        $persons = Persons::onlyTrashed()->get();
        return PersonsResource::collection($persons);
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
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:persons',
            'birthday' => 'required|before:today',
            'passport_expiry' => 'required|after:today'
        ];

        $customMessages = [
            'birthday.before' => 'El campo fecha de nacimiento debe ser una fecha anterior a hoy',
            'passport_expiry.after' => 'El campo fecha de expiración del pasaporte debe ser una fecha mayor a hoy',
        ];

        $request->validate($rules, $customMessages);

        $data = $request->only([
            'birthday',
            'name',
            'lastname',
            'notes',
            'extra_phone',
            'phone',
            'email',
            'lang',
            'position',
            'notify',
            'typecontact_id',
            'country_id',
            'agency_id',
            'passport',
            'passport_expiry',
            'notify_type',
            'group_id'
        ]);
        if ($data['group_id'] == '0') {
            $data['group_id'] = null;
        }

        if (!$request->has('agency_id')) {
            if ($request->user()->getMorphClass() == 'App\\Models\\User') {
                $data['agency_id'] = $request->user()->agency_id;
            } else {
                $data['agency_id'] = $request->user()->id;
            }
        }
        //Almacenar los datos en la base de datos
        $person = Persons::create($data);

        if ($request->has('socialmedias')) {
            Socialmedias::where('socialmediaable_id', $person->id)->delete();
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $person->id,
                        'socialmediaable_type' => 'App\Models\Persons'
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
                    'documentable_id' => $person->id,
                    'documentable_type' => 'App\Models\Persons'
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
                        'documentable_id' => $person->id,
                        'documentable_type' => 'App\Models\Persons'
                    ]);
                }
            }
        }

        $person->refresh();
        return new PersonsResource($person);
    }

    /**
     * Display the specified resource.
     */
    public function show(Persons $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Persons $person)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Persons $person)
    {
        $request->validate([
            'name' => 'required',
            'birthday' => 'required|before:today'
        ]);

        $data = $request->only([
            'birthday',
            'name',
            'lastname',
            'notes',
            'extra_phone',
            'phone',
            'email',
            'lang',
            'position',
            'notify',
            'typecontact_id',
            'country_id',
            'passport',
            'passport_expiry',
            'notify_type',
            'group_id'
        ]);
        if ($data['group_id'] == '0') {
            $data['group_id'] = null;
        }

        //Almacenar los datos en la base de datos
        $person->update($data);

        Socialmedias::where('socialmediaable_id', $person->id)->delete();
        if ($request->has('socialmedias')) {
            foreach ($request->socialmedias as $socialmedia) {
                if (isset($socialmedia['typesocialmedia_id'])) {
                    Socialmedias::create([
                        'url' => $socialmedia['url'],
                        'description' => $socialmedia['description'],
                        'typesocialmedia_id' => $socialmedia['typesocialmedia_id'],
                        'socialmediaable_id' => $person->id,
                        'socialmediaable_type' => 'App\Models\Persons'
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
                    'documentable_id' => $person->id,
                    'documentable_type' => 'App\Models\Persons'
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
                        'documentable_id' => $person->id,
                        'documentable_type' => 'App\Models\Persons'
                    ]);
                }
            }
        }
        $person->refresh();
        return new PersonsResource($person);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Persons $person)
    {
        $person->delete();
        Socialmedias::where('socialmediaable_id', $person->id)->delete();
        Documents::where('documentable_id', $person->id)->delete();

        return response()->json($person);
    }
    public function restore(Persons $person)
    {
        $person->restore();

        return response()->json($person);
    }

    public function personsByAgency(Request $request)
    {
        $agency = Agencies::find($request->id);
        $persons = $agency->persons()->get();

        return PersonsResource::collection($persons);
    }
    public function personsByTour(Request $request)
    {
        $tour = Tours::find($request->id);
        $persons = $tour->persons()->get();

        return PersonsResource::collection($persons);
    }
}
