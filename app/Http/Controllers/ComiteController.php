<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comite;


class ComiteController extends Controller
{

    public function affichageComites()
    {
        $comites = Comite::all();

        return response()->json([
            "comites" => $comites,
        ]);
    }
}
