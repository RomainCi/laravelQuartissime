<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AssocController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                // "nomAssoc" => 'required|string',
                // "adresse" => 'string|required',
                // "status" => ['required', Rule::in(['publique', 'prive'])],
                // "email" => 'email|required',
                // "telephone" => 'nullable|regex:/(0)[0-9]{9}/',
                // "descritpion" => 'string|required',
                // "accord" => 'boolean:true|required',
                // "previewImage" => 'file|max:2000'
            ]);

            $nomAssoc = $request->nomAssoc;
            $adresse = $request->adresse;
            $status = $request->status;
            $email = $request->email;
            $telephone = $request->telephone;
            $description = $request->description;
            $accord = $request->accord;
            $image = Storage::disk('local')->put('avatars', $request->previewImage);


            return response()->json([
                "nomAssoc" => $nomAssoc,
                "adresse" => $adresse,
                "status" => $status,
                "email" => $email,
                "telephone" => $telephone,
                "description" => $description,
                "accord" => $accord,
                "image" => $image,
            ]);

            // if ($telephone == "") {
            //     return response()->json([
            //         "nomAssoc" => $nomAssoc,
            //         "adresse" => $adresse,
            //         "status" => $status,
            //         "email" => $email,
            //         "telephone" => $telephone,
            //         "description" => $description,
            //         "accord" => $accord,
            //         "image" => $image,

            //     ]);
            // } else if ($telephone == $request->validate(["telephone" => 'regex:/(0)[0-9]{9}/'])) {
            //     return response()->json([
            //         "nomAssoc" => $nomAssoc,
            //         "adresse" => $adresse,
            //         "status" => $status,
            //         "email" => $email,
            //         "telephone" => $telephone,
            //         "description" => $description,
            //         "accord" => $accord,
            //         "image" => $image,

            //     ]);
            // } else {
            //     return response()->json([
            //         "message" => "pas oki",
            //     ]);
            // }

            // $user = [
            //     "email" => $email,
            //     "nom" => $nom,
            //     "prenom" => $prenom,
            //     "adresse" => $adresse,
            // ];

            $token = Str::random(30);
            VerifEmailRiverain::create([
                "token" => $token,
                "nom" => $nom,
                "prenom" => $prenom,
                "adresse" => $adresse,
                "email" => $email

            ]);
            $idArray = VerifEmailRiverain::select('id')
                ->where('token', $token)
                ->get();
            $id = $idArray[0]['id'];
            $userRiverain = [];
            // DeleteBddJob::dispatch($token, $user, $userRiverain);
            dispatch(new EmailJob($token, $user, $userRiverain))->delay(now()->addSeconds(3));
            // Mail::to($user['email'])->send(new VerifEmail($token, $user, $userRiverain));
            dispatch(new DeleteBddJob($id))->delay(now()->addMinutes(10));


            return response()->json([
                "message" => $email,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "erreur lors de l'envoie des donné",
            ]);
        }
    }
}
