<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
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
            $admin = Admin::where('email', $email)->first();

            if (Hash::check($password, $admin->password)) {

                return response()->json([
                    'token' => $admin->createToken(time())->plainTextToken
                ], 200);
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
    public function dashboard()
    {
    }
    public function inscription(Request $request)
    {
        try {
            $request->validate([
                "email" => 'email|required',
                "password" => ['required', 'confirmed', Password::min(8)->numbers()->mixedCase()->symbols()],
                "password_confirmation" => 'required'
            ]);
            $password = Hash::make($request->password);
            $email = $request->email;
            Admin::create([
                "email" => $email,
                "password" => $password
            ]);
            return response()->json([
                "message" => "inscription effectue"
            ]);
        } catch (\Exception $e) {

            return response()->json([
                "message" => "erreur lors de l'inscription"
            ]);
        }
    }
    public function showAdmin()
    {
        $userAdmin = Admin::all();
        return response()->json([
            "admin" => $userAdmin
        ]);
    }
    public function udpateAdmin(Request $request)
    {

        try {
            $request->validate([
                "emailTrue" => "email|required",
                "id" => "integer|required"
            ]);
            $email = $request->emailTrue;
            $id = $request->id;
            Admin::where("id", $id)
                ->update(['email' => $email]);

            return response()->json([
                "message" => "udpate ok"
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function deleteAdmin(Request $request)
    {
        try {
            $request->validate([
                "id" => "integer|required"
            ]);
            $id = $request->id;
            $admin = Admin::findOrFail($id);
            $admin->delete();

            return response()->json([
                "message" => "compte delete"
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
