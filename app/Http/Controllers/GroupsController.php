<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupsResource;
use App\Models\Groups;
use Illuminate\Http\Request;

class GroupsController extends Controller
{

   public function index()
   {
       $groups = Groups::all();
       return GroupsResource::collection($groups);
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
           'name'
       ]);


       //Almacenar los datos en la base de datos
       $group = Groups::create($data);

       $group->refresh();
       return new GroupsResource($group);
   }

 
   public function update(Request $request, Groups $group)
   {
       $request->validate([
           'name' => 'required',
       ]);

       $data = $request->only([
           'name'
       ]);

       //Almacenar los datos en la base de datos
       $group->update($data);

       $group->refresh();
       return new GroupsResource($group);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(Groups $group)
   {
       $group->delete();
      

       return response()->json($group);
   }
}
