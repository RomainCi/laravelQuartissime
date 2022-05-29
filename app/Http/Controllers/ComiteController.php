<?php

namespace App\Http\Controllers;

use App\Models\Comite;
use App\Models\UserComite;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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

        $assoc = Association::select('nom','email','telephone')
        ->where('comite_id',$comite)
        ->get();
        dd($assoc);
    

        return response()->json([
            "comite" => $comite,
            "assoc"=> $assoc,
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
        $user_id = auth()->user();
        $id = $user_id['id'];
        $comite =  Comite::findOrFail($id);


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
}
