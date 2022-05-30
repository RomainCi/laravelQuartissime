<?php

namespace App\Http\Controllers;

use App\Models\Comite;
use App\Models\VerifAssoc;
use App\Jobs\EmailAssocJob;
use App\Models\Association;
use Illuminate\Support\Str;
use App\Mail\InfoAssocEmail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AssociationPhoto;
use App\Models\VerifAssocPhotos;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AssocController extends Controller
{

    public function store(Request $request)
    {

        try {

            $request->validate([
                "nomAssoc" => 'required|string',
                "adresse" => 'string|required',
                "status" => ['required', Rule::in(['publique', 'prive'])],
                "email" => 'email|required',
                "telephone" => 'nullable|regex:/(0)[0-9]{9}/',
                "description" => 'string|required',
                "accord" => ['required', Rule::in(['true'])],
                "id" => 'integer|required'
            ]);

            $nomAssoc = $request->nomAssoc;
            $adresse = $request->adresse;
            $status = $request->status;
            $email = $request->email;
            $telephone = $request->telephone;
            $description = $request->description;
            $idComite = $request->id;
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $token = Str::random(30);

            VerifAssoc::create([
                "comite_id" => $idComite,
                "nom" => $nomAssoc,
                "adresse" => $adresse,
                "status" => $status,
                "email" => $email,
                "telephone" => $telephone,
                "description" => $description,
                "token" => $token,
                "latitude" => $latitude,
                "longitude" => $longitude
            ]);
            $idArray = verifAssoc::select('id')
                ->where('email', $email)
                ->get();
            $id = $idArray[0]['id'];

            if ($request->hasFile('images')) {
                $request->validate([
                    "images" => 'array|max:10',
                    "images.*" => 'file|mimes:jpeg,png,jpg|max:2000'
                ]);

                foreach ($request->images as $index => $file) {



                    $fileName = Str::random(10) . '.' . $file->getClientOriginalName();
                    $chemin = $file->move(public_path($nomAssoc . "image"), $fileName);

                    VerifAssocPhotos::create([
                        "verif_assocs_id" => $id,
                        "pathPhoto" => $chemin,
                    ]);
                };
            }
            dispatch(new EmailAssocJob($token, $nomAssoc, $email))->delay(now()->addSeconds(3));
            return response()->json([
                "message" => "oki"
            ]);
        } catch (\Exception $e) {
            dd($e);
            return response()->json([
                "message" => "erreur lors de l'envoie des donné",
            ]);
        }
    }
    public function verife($token)
    {
        try {
            $userAssoc = VerifAssoc::select('nom', 'adresse', 'status', 'email', 'telephone', 'description', 'id', 'comite_id', 'latitude', 'longitude')
                ->where('token', $token)
                ->get();

            $emailComitee = Comite::select('email')
                ->where('id', $userAssoc[0]['comite_id'])
                ->get();
            $emailComite = $emailComitee[0]['email'];
            $id = $userAssoc[0]['id'];
            $email = $userAssoc[0]['email'];


            $chemin = VerifAssocPhotos::select('pathPhoto')
                ->where('verif_assocs_id', $id)
                ->get();

            // dd($userAssoc[0]->nom);
            Association::create([
                "nom" => $userAssoc[0]->nom,
                "adresse" => $userAssoc[0]->adresse,
                "status" => $userAssoc[0]->status,
                "email" => $userAssoc[0]->email,
                "telephone" => $userAssoc[0]->telephone,
                "description" => $userAssoc[0]->description,
                "comite_id" => $userAssoc[0]->comite_id,
                "longitude" => $userAssoc[0]->longitude,
                "latitude" => $userAssoc[0]->latitude,
            ]);

            $newId = Association::select('id')
                ->where('email', $email)
                ->get();
            $trueId = $newId[0]['id'];
            foreach ($chemin as $file) {
                AssociationPhoto::create([
                    "assocs_id" => $trueId,
                    "pathPhoto" => $file->pathPhoto,
                ]);
            };

            $delete = VerifAssoc::findOrFail($id);
            $delete->delete();

            Mail::to($emailComite)->send(new InfoAssocEmail($userAssoc, $chemin));
            return view('test');
        } catch (\Exception $e) {

            return view('emails.erreur');
        }
    }
}
