<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteForgetJob;
use App\Jobs\ForgetJob;
use App\Models\Admin;
use App\Models\UserComite;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Forgetpassword;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
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
    public function forgetpassword(Request $request)
    {
        try {
            $request->validate([
                "email" => 'required|email',
            ]);

            $mail = UserComite::select('identifiant', 'id')
                ->where('identifiant', $request->email)
                ->get();
            $trueMail = $mail[0]['identifiant'];

            $token = Str::random(30);

            Forgetpassword::create([
                "email" => $trueMail,
                "token" => $token,
            ]);
            $idArray = Forgetpassword::select('id')
                ->where('token', $token)
                ->get();
            $id = $idArray[0]['id'];
            dispatch(new ForgetJob($token, $trueMail))->delay(now()->addSeconds(3));
            dispatch(new DeleteForgetJob($id))->delay(now()->addMinutes(5));
            return response()->json([
                "message" => "oki"
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function repassword($token)
    {
        try {
            $email = Forgetpassword::select('email')
                ->where('token', $token)
                ->get();
            $mail = $email[0]['email'];
            return view('emails.nono', compact('mail'));
        } catch (\Exception $e) {
            return view('emails.erreur');
        }
    }

    public function pass(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|string',
                'email' => 'required|string',
            ]);
            $password = Hash::make($request->password);
            UserComite::where('identifiant', $request->email)
                ->update(['password' => $password]);
            $id = Forgetpassword::select('id')
                ->where('email', $request->email)
                ->get();
            $admin = Forgetpassword::findOrFail($id[0]['id']);
            $admin->delete();
            return view('emails.ok');
        } catch (\Exception $e) {
            return view('emails.probleme');
        }
    }
}
