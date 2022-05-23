<?php

namespace App\Http\Controllers;

use App\Models\UserComite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserComiteController extends Controller
{
    public function authentificate (Request $request): JsonResponse{

        $userComite = UserComite::where ('identifiant', $request->identifiant)->first();

        if (Hash::check($request->password, $userComite->password)){
            return response()->json([
                'token' => $userComite->createToken(time())->plainTextToken
            ]);
        }
    }

    public function userProfil(): JsonResponse
    {
        return response()->json([
            'success' => 'bienvenue!'
        ]);
    }
}
