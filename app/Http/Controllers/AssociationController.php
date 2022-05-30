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

        $request->validate([
            'id' => 'required|numeric',

        ]);
        $comite_id = $request->input("id");

        // dd($comite_id);


        $associations = Comite::findOrFail($comite_id)->associations;

        return response()->json(["associations" => $associations]);
    }
}
