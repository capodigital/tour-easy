<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypesocialmediasResource;
use App\Models\Typesocialmedias;

class TypesocialmediasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typesocialmedias = Typesocialmedias::all();
        return TypesocialmediasResource::collection($typesocialmedias);
    }

   

   
}
