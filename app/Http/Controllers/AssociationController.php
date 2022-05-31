<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Association;
use App\Models\Comite;
use Illuminate\Support\Facades\DB;

class AssociationController extends Controller
{


    public function linkassociationtocomite(Request $request)
    {
<<<<<<< HEAD
      
        // $request->validate([
        //     'id' => 'required|numeric',
=======

        $request->validate([
            'id' => 'required|numeric',
>>>>>>> main

        // ]);
        // $comite_id = $request->input("id");

<<<<<<< HEAD
        // // dd($comite_id);
   
=======
        // dd($comite_id);

>>>>>>> main

        // $associations = Comite::findOrFail($comite_id)->associations;

        // return response()->json(["associations" => $associations]);
    }
}
