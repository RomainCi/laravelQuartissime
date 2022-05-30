<?php

namespace App\Http\Controllers;

use App\Models\Comite;
use Illuminate\Http\Request;
use App\Models\Association;
use Illuminate\Support\Facades\DB;


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
    // FONCTION ASSOCIATIONS
    public function affichageAssociations()
    {
        $associations = Association::all();

        return response()->json([
            "associations" => $associations,
        ]);
    }

    // public function showDetailsAssociation($id)
    // {

    //     $detailsComite = Association::findOrFail($id);
    //     return response()->json([
    //         "detailsassociation" => $detailsAssociation,
    //     ]);
    // }

    public function calcultop3assocomite(Request $request)
    {
        $request->validate([
            'lon' => 'required|numeric',
            'lat' => 'required|numeric',
        ]);
        $lon = $request->input("lon");
        $lat = $request->input("lat");

        $haversine = "(6371 * acos(cos(radians($lat)) 
        * cos(radians(comites.latitude))
        * cos(radians(comites.longitude))
        - radians($lon)) 
        + sin(radians($lat)) 
        * sin(radians(comites.latitude)))";

        $comites =  DB::table('comites')
            ->select("*") //pick the columns you want here.
            ->selectRaw("{$haversine} AS distance")
            ->orderBy('distance')
            ->limit(3)
            ->get();

        return response()->json(['comites' => $comites]);
    }
}
