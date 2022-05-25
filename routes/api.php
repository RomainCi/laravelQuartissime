<?php

use App\Http\Controllers\ComiteController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserComiteController;
use App\Http\Controllers\AssociationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/publics', [PublicController::class, 'savedata']);


Route::get('/comites/nearest', [PublicController::class, "calcultop3assocomite"]);

Route::get('/comites/associationsrelatives', [AssociationController::class, "linkassociationtocomite"]);

Route::get("/publics", [PublicController::class, "affichageComites"]);

Route::get('/comites/{id}', [PublicController::class, "showDetailsComite"]);

// ROUTES ASSOCIATIONS

Route::get("/associations", [PublicController::class, "affichageAssociations"]);

/* Route::get('/associations/{id}', [PublicController::class, "showDetailsAssociation"]); */





// ROUTES USER COMITES

Route::post('login', [UserComiteController::class, "authentificate"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('comites', [UserComiteController::class, "userProfil"]);
    Route::get('profilcomite', [ComiteController::class, "index"]);
    Route::put('profilcomite', [ComiteController::class, "update"]);
});
