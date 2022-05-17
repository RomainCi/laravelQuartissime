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

    public function sendcoordsdata(Request $request) {
        $lon = $request->input("lon");
        $lat = $request->input("lat");

      }

    public function affichageTop3($lat, $long)
    {
    }
}
