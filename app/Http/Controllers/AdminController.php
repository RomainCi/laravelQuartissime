<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\UserComite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function connexion(Request $request)
    {
        try {
            $request->validate([
                "email" => 'required|email',
                "password" => 'string|required',
            ]);
            $password = $request->password;
            $email = $request->email;
            $admin = UserComite::where('identifiant', $email)->first();

            if (Hash::check($password, $admin->password)) {
                if ($admin['roles'] === 1) {
                    return response()->json([
                        'token' => $admin->createToken(time())->plainTextToken,
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "vous n'avez pas la persmission",

                    ], 404);
                }
            } else {
                return response()->json([
                    "message" => "erreur lors des saisies",

                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => "adresse email inconnue"

            ], 404);
        }
    }

    public function inscription(Request $request)
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $request->validate([
                    "email" => 'email|required',
                    "password" => ['required', 'confirmed', Password::min(8)->numbers()->mixedCase()->symbols()],
                    "password_confirmation" => 'required'
                ]);
                $password = Hash::make($request->password);
                $email = $request->email;
                $roles = 1;
                UserComite::create([
                    "identifiant" => $email,
                    "roles" => $roles,
                    "password" => $password
                ]);

                return response()->json([
                    "message" => "inscription effectue"
                ]);
            } else {
                return response()->json([
                    "message" => "pas la permission"
                ], 404);
            }
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                "message" => "erreur lors de l'inscription"
            ]);
        }
    }
    public function showAdmin()
    {
        $accord = $this->securite();
        if ($accord == true) {
            $userAdmin = UserComite::where('roles', 1)->get();


            return response()->json([
                "admin" => $userAdmin
            ]);
        } else {
            return response()->json([
                "message" => "pas la permission"
            ], 404);
        }
    }
    public function udpateAdmin(Request $request)
    {

        try {
            $accord = $this->securite();
            if ($accord == true) {
                $request->validate([
                    "emailTrue" => "email|required",
                    "id" => "integer|required"
                ]);
                $email = $request->emailTrue;
                $id = $request->id;
                UserComite::where('id', $id)
                    ->update(['identifiant' => $email]);
                return response()->json([
                    "message" => "udpate ok"
                ]);
            } else {
                return response()->json([
                    "message" => "pas la permission"
                ], 404);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function deleteAdmin(Request $request)
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $request->validate([
                    "id" => "integer|required"
                ]);
                $id = $request->id;
                $admin = UserComite::findOrFail($id);
                $admin->delete();

                return response()->json([
                    "message" => "compte delete"
                ]);
            } else {
                return response()->json([
                    "message" => "pas la permission"
                ], 404);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function securite()
    {
        $id_admin = Auth::User()->id;
        $admin = UserComite::findOrFail($id_admin);
        if ($admin['roles'] === 1) {
            return true;
        } else {
            return false;
        }
    }
}
