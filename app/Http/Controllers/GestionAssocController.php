<?php

namespace App\Http\Controllers;

use App\Models\Comite;
use App\Models\UserComite;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GestionAssocController extends Controller
{
    public function securite()
    {
        try {
            $id_admin = Auth::User()->id;
            $admin = UserComite::findOrFail($id_admin);
            if ($admin['roles'] === 1) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function showAssoc()
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $association = Association::select('associations.*', 'comites.comiteName')
                    ->join('comites', 'comites.id', '=', 'associations.comite_id')
                    ->get();

                return response()->json([
                    "association" => $association,

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
    public function updateAssoc(Request $request)
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {

                Association::where('id', $request->id)
                    ->update([
                        'nom' => $request->nom,
                        'adresse' => $request->adresse,
                        'status' => $request->status,
                        'email' => $request->email,
                        'telephone' => $request->telephone,
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
        }
    }
    public function deleteAssoc(Request $request)
    {
        try {
            $accord = $this->securite();
            if ($accord == true) {
                $assoc = Association::findOrFail($request->id);
                $assoc->delete();
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
}
