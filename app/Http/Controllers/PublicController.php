<?php

namespace App\Http\Controllers;

use App\Models\Comite;
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
    /* public function sendcoordsdata(Request $request)
    {

        $request->validate([
            'lon' => 'required|numeric',
            'lat' => 'required|numeric',
        ]);
        $lon = $request->input("lon");
        $lat = $request->input("lat");
    } */
}
