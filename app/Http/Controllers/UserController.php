<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
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
            'email' => 'required|email|unique:user',
            'password' => [
                'required',
                'string',
            ],
            'confirm_password' => 'required|same:password'

        ]);
        $data = $request->only(['email', 'name', 'agency_id']);
        $data['password'] = bcrypt($request->password);
       

        //Almacenar los datos en la base de datos
        $user = User::create($data);
       

        

        

        $user->refresh();
        return new UserResource($user);
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
            'email' => ['required', 'email', 'unique:user,email,' . $user->id],

        ]);

        $data = $request->only(['stagename', 'email', 'lastname', 'name', 'birthday', 'tags', 'notes']);


        //Almacenar los datos en la base de datos
        $user->update($data);

        $user->refresh();
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json($user);
    }
}
