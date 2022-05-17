<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeolocController extends Controller
{
    public function sendcoordsdata(Request $request) {
        $lon = $request->input("lon");
        $lat = $request->input("lat");

      }
}
