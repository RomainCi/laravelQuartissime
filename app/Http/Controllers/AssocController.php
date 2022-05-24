<?php

namespace App\Http\Controllers;

use App\Models\VerifAssoc;
use App\Jobs\EmailAssocJob;
use App\Mail\InfoAssocEmail;
use App\Models\Association;
use App\Models\AssociationPhoto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
                "accord" => ['required', Rule::in(['true'])]
            ]);

            $nomAssoc = $request->nomAssoc;
            $adresse = $request->adresse;
            $status = $request->status;
            $email = $request->email;
            $telephone = $request->telephone;
            $description = $request->description;
            $token = Str::random(30);

            VerifAssoc::create([
                "nom" => $nomAssoc,
                "adresse" => $adresse,
                "status" => $status,
                "email" => $email,
                "telephone" => $telephone,
                "description" => $description,
                "token" => $token
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
                        "nomPhoto" => $chemin,
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
            $userAssoc = VerifAssoc::select('nom', 'adresse', 'status', 'email', 'telephone', 'description', 'id')
                ->where('token', $token)
                ->get();
            $emailComite = "ciszewiczromain@gmail.com";
            $id = $userAssoc[0]['id'];


            $chemin = VerifAssocPhotos::select('nomPhoto')
                ->where('verif_assocs_id', $id)
                ->get();


            $delete = VerifAssoc::findOrFail($id);
            $delete->delete();

            Mail::to($emailComite)->send(new InfoAssocEmail($userAssoc, $chemin));
            return view('test');
        } catch (\Exception $e) {
            dd($e);
            return view('emails.erreur');
        }
    }
}
