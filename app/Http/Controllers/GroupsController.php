<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupsResource;
use App\Models\Agencies;
use App\Models\Groups;
use App\Models\User;
use Illuminate\Http\Request;

class GroupsController extends Controller
{

   public function index(Request $request)
   {
    $groups = [];
    if ($request->user()->getMorphClass() == 'App\\Models\\User') {
        $user = User::find($request->user()->id);
        if ($user->agency_id != null) {
            $groups = Agencies::find($user->agency_id)->groups()->get();
        } else
            $groups = groups::withTrashed()->whereNull('deleted_at')->get();
    } else if ($request->user()->getMorphClass() == 'App\\Models\\Agencies') {
        $groups = Agencies::where('id', $request->user()->id)->first()->groups()->get();
    } else {
        $groups[] = groups::find($request->user()->id);
    }
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
       if (!$request->has('agency_id')) {
        if ($request->user()->getMorphClass() == 'App\\Models\\User') {
            $data['agency_id'] = $request->user()->agency_id;
        } else {
            $data['agency_id'] = $request->user()->id;
        }
    }


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
