<?php

namespace App\Http\Controllers;

use App\Models\Comite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $comite = $user->comite; //->comite fonction de relation fait dans Model 

        return response()->json([
            "comite" => $comite,
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

        $request->validate([
            'comiteName' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'comiteName' => 'required|string|max:255',
            'comiteName' => 'required|string|max:255',
            'comiteName' => 'required|string|max:255',
            'comiteName' => 'required|string|max:255',
            'comiteName' => 'required|string|max:255'
        ]);


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
    }
}
