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
        $user_id = auth()->user();
        $id = $user_id['id'];

        $comite = Comite::all()
            ->where('user_comite_id', '=', $id);

        return response()->json([
            "comite" => $comite[--$id],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $comite =  Comite::findOrFail($id);
        
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
