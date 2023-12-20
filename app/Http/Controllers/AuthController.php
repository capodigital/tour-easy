<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Agencies;
use App\Models\Artists;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        //Verificar si el usuario es un administrador
        if(!$user) {
            //Verificar si el usuario es una agencia
            $user = Agencies::where('email', $request->email)->first();
            if(!$user) {
                //Verificar si el usuario es un artista
                $user = Artists::where('email', $request->email)->first();
                if(!$user) {
                    throw ValidationException::withMessages([
                        'email' => ['No se encontró ningún usuario registrado con este correo.'],
                    ]);
                }
            }
        }
        //Verificar si la contraseña es correcta
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas.'],
            ]);
        }
        //Retornar los datos y el token
        $token = $user->createToken('f8b7c4a2e6d9c0a1b3f5')->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response('');
    }


}
