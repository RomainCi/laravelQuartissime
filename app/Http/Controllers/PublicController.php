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
}
