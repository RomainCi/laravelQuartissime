<?php

namespace App\Http\Controllers;

use App\Models\Comite;
use App\Models\Association; 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function affichageComites()
    {
        $comites = Comite::all();

        return response()->json([
            "comites" => $comites,
        ]);
    }
    public function showDetailsComite($id)
    {

        $detailsComite = Comite::findOrFail($id);
        return response()->json([
            "detailsComite" => $detailsComite,
        ]);
    }
    public function affichageAssociations()
    {
        $associations = Association::all();

        return response()->json([
            "associations" => $associations,
        ]);
    }
    public function showDetailsAssociation($id)
    {

        $detailsComite = Association::findOrFail($id);
        return response()->json([
            "detailsassociation" => $detailsAssociation,
        ]);
    }
    
        
    public function calcultop3assocomite(Request $request) 
    {   
        $request->validate([
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);
        $longitude = $request->input("longitude");
        $latitude = $request->input("latitude");

        $haversine = "(6371 * acos(cos(radians($latitude)) 
        * cos(radians(comites.latitude))
        * cos(radians(comites.longitude)  
        - radians($longitude)) 
        + sin(radians($latitude)) 
        * sin(radians(comites.latitude))))";

        $comites =  DB::table('comites')
        ->select("*") //pick the columns you want here.
        ->selectRaw("{$haversine} AS distance")
        ->orderBy('distance', 'asc')
        ->limit(3)
        ->get();

        return response()->json(['comites' => $comites]);
    }


    
}
