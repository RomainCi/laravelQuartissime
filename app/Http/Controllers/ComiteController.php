<?php

namespace App\Http\Controllers;

use App\Models\Comite;
use App\Models\UserComite;
use App\Models\Association;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ComiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */

    protected $user_id;

    public function index()
    {
        $user = auth()->user();
        $comite = $user->comite; //->comite fonction de relation fait dans Model parent user comite
        // dd($comite);

        $assoc = $comite->associations; // appel de la fonction associations fait dans le model parent comite
        // dd($assoc);
        $detailsEvents = $comite->events;

        return response()->json([
            "comite" => $comite,
            "assoc" => $assoc,
            "detailsEvents" => $detailsEvents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request)
    {
        $user = auth()->user();
        $comite =  $user->comite;



        $array = (array) $request->all();


        $validator = Validator::make(
            $array,
            [
                'comiteName' => 'min:3|max:255|required|string',
                'phone' => 'nullable|regex:/(0)[0-9]{9}/',
                'email' => 'email|required',
                'webSite' => 'url',
                'description' => 'string|max:255',
                'firstnamePresident' => 'string|max:20',
                'lastnamePresident' => 'string|max:20',

            ],
            [
                'comiteName' => 'Le nom est invalide',
                'phone' => 'Le numéro de téléphone est invalide',
                'email' => 'L\'email est invalide',
                'webSite' => 'Le nom du site web est invalide',
                'description' => 'La description est invalide',
                'firstnamePresident' => 'Le prénom est invalide',
                'lastnamePresident' => 'Le nom est invalide',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->messages(), 406);
        } else {

            $comite->comiteName = $request->input('comiteName');
            $comite->phone = $request->input('phone');
            $comite->email = $request->input('email');
            $comite->webSite = $request->input('webSite');
            $comite->description = $request->input('description');
            $comite->firstnamePresident = $request->input('firstnamePresident');
            $comite->lastnamePresident = $request->input('lastnamePresident');



            $comite->save();


            return response()->json([
                "comite" => $comite,

            ]);
        };
    }

    public function updateAssoc(Request $request)
    {
        try {
            $user = auth()->user();
            $comite_id =  $user->comite->id;

            $assoc_id = $request->id;

            $assoc = Association::findOrFail($assoc_id); // appel de la fonction associations fait dans le model parent comite

            if ($assoc->comite_id != $comite_id) {
                return response()->json(["message" => "Vous n'avez pas les droits d'accès nécessaire pour modifier cette assosiation."], 403);
            }

            $assoc->nom = $request->input('nom');
            $assoc->telephone = $request->input('telephone');
            $assoc->email = $request->input('email');

            $assoc->save();

            return response()->json([
                "message" => "Modifications effectuées",
                "assoc" => $assoc,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function savenewevent(Request $request)
    {

        $request->validate([
            "eventname" => 'required|string',
            "eventdate" => 'required|date',
            "place" => 'required|string',
            "description" => 'required|string',
            "type" => 'required|string'
        ]);

        $event = [
            "comite_id" => $request->input("comite_id"),
            "eventname" => $request->input("eventname"),
            'eventdate' => $request->input("eventdate"),
            'place' => $request->input("place"),
            'description' => $request->input("description"),
            'type' => $request->input("type")
        ];
        Event::create($event);
    }

    public function deleteevent(Request $request)
    {

        $user = auth()->user();
        $comite_id =  $user->comite->id;

        $event_id = $request->id;

        $event = Event::findOrFail($event_id);

        if ($event->comite_id != $comite_id) {
            return response()->json(["message" => "Vous n'avez pas les droits d'accès nécessaire pour supprimer cet évènement."], 403);
        }

        $event->delete();

        return response()->json([
            "message" => "suppression ok"
        ]);
    }


    public function deleteAssoc(Request $request)
    {


        $user = auth()->user();
        $comite_id =  $user->comite->id;

        $assoc_id = $request->id;

        $assoc = Association::findOrFail($assoc_id);

        if ($assoc->comite_id != $comite_id) {
            return response()->json(["message" => "Vous n'avez pas les droits d'accès nécessaire pour supprimer cette association."], 403);
        }


        $assoc->delete();

        return response()->json([
            "message" => "suppression ok"
        ]);
    }
}
