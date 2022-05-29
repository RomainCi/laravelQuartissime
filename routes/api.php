<?php

use App\Http\Controllers\PublicController;
use App\Http\Controllers\AssociationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/comites/nearest', [PublicController::class, "calcultop3assocomite"]);

//Route::get('/comites/associationsrelatives', [AssociationController::class,"linkassociationtocomite"]);

Route::get("/comites", [PublicController::class, "affichageComites"]);

Route::get('/comites/{id}', [PublicController::class, "showDetailsComite"]);

Route::get("/associations", [PublicController::class, "affichageAssociations"]);

Route::get('/associations/{id}', [PublicController::class, "showDetailsAssociation"]);

//Route::resource('/comites', ComiteController::class);
