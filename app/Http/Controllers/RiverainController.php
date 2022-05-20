<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteBddJob;
use App\Jobs\EmailJob;
use App\Mail\VerifEmail;
use App\Models\VerifEmailRiverain;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
                "adresse" => 'string'
            ]);

            $email = $request->email;
            $nom = $request->nom;
            $prenom = $request->prenom;
            $adresse = $request->adresse;
            $user = [
                "email" => $email,
                "nom" => $nom,
                "prenom" => $prenom,
                "adresse" => $adresse,
            ];

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
            $userRiverain = VerifEmailRiverain::select('nom', 'prenom', 'adresse', 'email', 'id')
                ->where('token', $token)
                ->get();
            $emailComite = "ciszewiczromain@gmail.com";
            $id = $userRiverain[0]['id'];
            $delete = VerifEmailRiverain::findOrFail($id);
            $delete->delete();
            $user = "";
            Mail::to($emailComite)->send(new VerifEmail($token, $user, $userRiverain));
            return view('test');
        } catch (\Exception $e) {
            return view('emails.erreur');
        }
    }
}
