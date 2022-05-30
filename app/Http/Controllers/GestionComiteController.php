<?php

namespace App\Http\Controllers;

use App\Models\Comite;
use App\Models\UserComite;
use App\Models\ComitePhoto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class GestionComiteController extends Controller
{
    public function showComite()
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $comite = Comite::all();
                $comiteUser = UserComite::where("roles", 0)->get();
                return response()->json([
                    "comite" => $comite,
                    "comiteUser" => $comiteUser,
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
    public function inscription(Request $request)
    {

        try {
            $accord = $this->securite();
            if ($accord == true) {
                $request->validate([
                    "identifiant" => 'required|string',
                    "password" => ['required', Password::min(8)->numbers()->mixedCase()->symbols()],
                    "description" => 'string|required',
                    "telephone" => 'nullable|regex:/(0)[0-9]{9}/',
                    "prenomP" => "required|string",
                    "nomP" => "required|string",
                    "adresse" => "required|string",
                    'site' => 'url|nullable',
                    "facebook" => 'url|nullable',
                ]);
                $password = Hash::make($request->password);
                UserComite::create([
                    "identifiant" => $request->identifiant,
                    "password" => $password,
                ]);
                $idArray = UserComite::select('id')
                    ->where('identifiant', $request->identifiant)
                    ->get();
                $id = $idArray[0]['id'];
                Comite::create([
                    "user_comite_id" => $id,
                    "comiteName" => $request->nom,
                    "firstnamePresident" => $request->prenomP,
                    "lastnamePresident" => $request->nomP,
                    "adress" => $request->adresse,
                    "email" => $request->email,
                    "phone" => $request->telephone,
                    "facebookLink" => $request->facebook,
                    "webSite" => $request->site,
                    "description" => $request->description,
                    "latitude" => $request->latitude,
                    "longitude" => $request->longitude,
                ]);
                $idArraye = Comite::select('id')
                    ->where('user_comite_id', $id)
                    ->get();

                $ide = $idArraye[0]['id'];
                if ($request->hasFile('images')) {
                    $request->validate([
                        "images" => 'array|max:10',
                        "images.*" => 'file|mimes:jpeg,png,jpg|max:2000'
                    ]);

                    foreach ($request->images as $index => $file) {
                        $fileName = Str::random(10) . '.' . $file->getClientOriginalName();
                        $chemin = $file->move(public_path($request->nom . "image"), $fileName);

                        ComitePhoto::create([
                            "comites_id" => $ide,
                            "pathPhoto" => $chemin,
                        ]);
                    };
                }
                return response()->json([
                    "message" => "oki"
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
    public function udpateComite(Request $request)
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $request->validate([
                    "nom" => 'required|string',
                    "description" => 'string|required',
                    "telephone" => 'nullable|regex:/(0)[0-9]{9}/',
                    "prenomP" => "required|string",
                    "nomP" => "required|string",
                    "adresse" => "required|string",
                    'site' => 'url|nullable',
                    "facebook" => 'nullable|url',
                ]);
                Comite::where('id', $request->id)
                    ->update([
                        'comiteName' => $request->nom,
                        'firstnamePresident' => $request->prenomP,
                        'lastnamePresident' => $request->nomP,
                        'adress' => $request->adresse,
                        'email' => $request->email,
                        'phone' => $request->telephone,
                        'facebookLink' => $request->facebook,
                        "webSite" => $request->site,
                        "description" => $request->description,
                        "latitude" => $request->lat,
                        "longitude" => $request->long,
                    ]);
                return response()->json([
                    "message" => "modification ok"
                ]);
            } else {
                return response()->json([
                    "message" => "pas la permission"
                ], 404);
            }
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                "message" => "erreur"
            ], 404);
        }
    }
    public function deleteComite(Request $request)
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $request->validate([
                    "id" => 'integer|required'
                ]);
                $idArray = Comite::select('user_comite_id')
                    ->where('id', $request->id)
                    ->get();
                $id = $idArray[0]['user_comite_id'];
                $userComite = UserComite::findOrfail($id);
                $userComite->delete();
                $comite = Comite::findOrFail($request->id);
                $comite->delete();
                return response()->json([
                    "message" => "suppression ok"
                ]);
            } else {
                return response()->json([
                    "message" => "pas la permission"
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                "message" => "erreur"
            ], 404);
        }
    }

    public function udpateUserComite(Request $request)
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $request->validate([
                    "id" => 'integer|required',
                    "emailTrue" => 'required|string',
                    "password" => ['required', Password::min(8)->numbers()->mixedCase()->symbols()],
                ]);

                $password = Hash::make($request->password);

                UserComite::where('id', $request->id)
                    ->update([
                        "identifiant" => $request->emailTrue,
                        "password" => $password
                    ]);
                return response()->json([
                    "message" => "modification ok"
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
    public function deleteUserComite(Request $request)
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $request->validate([
                    "id" => 'integer|required'
                ]);
                $userComite = UserComite::findOrfail($request->id);
                $userComite->delete();
                $idArray = Comite::select('id')
                    ->where("user_comite_id", $request->id)
                    ->get();
                $id = $idArray[0]['id'];
                $comite = Comite::findOrfail($id);
                $comite->delete();
                return response()->json([
                    "message" => "suppression ok"
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
