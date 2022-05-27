<?php

namespace App\Http\Controllers;

use App\Jobs\EmailJob;
use App\Models\Comite;
use App\Mail\VerifEmail;
use App\Jobs\DeleteBddJob;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VerifEmailRiverain;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Notifications\VerifyEmail;
use Symfony\Component\Mailer\Messenger\SendEmailMessage;

class RiverainController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                "email" => 'required|email',
                "nom" => 'string|required',
                "prenom" => 'string|required',
                "adresse" => 'string|nullable',
                "id" => 'required|integer'
            ]);

            $email = $request->email;
            $nom = $request->nom;
            $prenom = $request->prenom;
            $adresse = $request->adresse;
            $idComite = $request->id;


            $user = [
                "email" => $email,
                "nom" => $nom,
                "prenom" => $prenom,
                "adresse" => $adresse,
                "id" => $idComite,
            ];

            $token = Str::random(30);
            VerifEmailRiverain::create([
                "token" => $token,
                "nom" => $nom,
                "prenom" => $prenom,
                "adresse" => $adresse,
                "email" => $email,
                "id_comite" => $idComite,

            ]);
            $idArray = VerifEmailRiverain::select('id')
                ->where('token', $token)
                ->get();
            $id = $idArray[0]['id'];
            $userRiverain = [];
            // DeleteBddJob::dispatch($token, $user, $userRiverain);
            dispatch(new EmailJob($token, $user, $userRiverain))->delay(now()->addSeconds(3));
            // Mail::to($user['email'])->send(new VerifEmail());
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
    public function verif($token)
    {
        try {
            $userRiverain = VerifEmailRiverain::select('nom', 'prenom', 'adresse', 'email', 'id', 'id_comite')
                ->where('token', $token)
                ->get();
            $emailComite = Comite::select('email')
                ->where('id', $userRiverain[0]['id_comite'])
                ->get();

            $mailComite = $emailComite[0]['email'];
            $id = $userRiverain[0]['id'];
            $delete = VerifEmailRiverain::findOrFail($id);
            $delete->delete();
            $user = "";
            Mail::to($mailComite)->send(new VerifEmail($token, $user, $userRiverain));
            return view('test');
        } catch (\Exception $e) {
            return view('emails.erreur');
        }
    }
}
