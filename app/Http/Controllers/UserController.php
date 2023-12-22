<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgenciesResource;
use App\Http\Resources\UserResource;
use App\Models\Agencies;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'agency_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
            ],
            'confirm_password' => 'required|same:password'

        ]);
        $data = $request->only(['email', 'name', 'agency_id']);
        $data['password'] = bcrypt($request->password);
        //Almacenar los datos en la base de datos
        User::create($data);
        return new AgenciesResource(Agencies::find($request->agency_id));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'agency_id' => 'required',
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);
        $data = $request->except(['password']);
        //Almacenar los datos en la base de datos
        $user->update($data);
        if ($user->agency_id != null) {
            return new AgenciesResource(Agencies::find($request->agency_id));
        } else {
            return new UserResource($user);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        if ($user->agency_id != null) {
            return new AgenciesResource(Agencies::find($user->agency_id));
        } else {
            return response('');
        }
    }
}
