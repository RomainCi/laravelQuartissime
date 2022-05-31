<?php

use App\Http\Controllers\ComiteController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserComiteController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssocController;
use App\Http\Controllers\GestionAssocController;
use App\Http\Controllers\GestionComiteController;
use App\Http\Controllers\RiverainController;
use App\Models\Admin;
use App\Models\Comite;
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




Route::get('/showcomites/nearest', [PublicController::class, "calcultop3assocomite"]);

Route::get("/showcomites", [PublicController::class, "affichageComites"]);

Route::get('/comites/{id}', [PublicController::class, "showDetailsComite"]);

// ROUTES ASSOCIATIONS

Route::get("/associations", [PublicController::class, "affichageAssociations"]);







// ROUTES USER COMITES

Route::post('login', [UserComiteController::class, "authentificate"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('comites', [UserComiteController::class, "userProfil"]);
    Route::get('profilcomite', [ComiteController::class, "index"]);
    Route::put('profilcomite', [ComiteController::class, "update"]);
    Route::put('association', [ComiteController::class, "updateAssoc"]);
    Route::delete('association', [ComiteController::class, "deleteAssoc"]);
});

Route::post('/riverain', [RiverainController::class, 'store']);

Route::post('/assoc', [AssocController::class, 'store']);

Route::post('/connexionAdmin', [AdminController::class, 'connexion']);

///////////////////////////////// ADMIN///////////////////
Route::middleware('auth:sanctum')->group(function () {
    Route::post('registerAdmin', [AdminController::class, "inscription"]);
    Route::get('showAdmin', [AdminController::class, "showAdmin"]);
    route::put('udpateAdmin', [AdminController::class, "udpateAdmin"]);
    route::delete('deleteAdmin', [AdminController::class, "deleteAdmin"]);
});
///////////////////gestion Comite par ADMIN ///////////////////////////
Route::middleware('auth:sanctum')->group(function () {
    Route::get('showComite', [GestionComiteController::class, "showComite"]);
    Route::post('inscriptionComite', [GestionComiteController::class, "inscription"]);
    Route::put("udpateComite", [GestionComiteController::class, "udpateComite"]);
    Route::delete("deleteComite", [GestionComiteController::class, "deleteComite"]);
    Route::put("udpateUserComite", [GestionComiteController::class, "udpateUserComite"]);
    Route::delete("deleteUserComite", [GestionComiteController::class, "deleteUserComite"]);
});

/////////////////////////gestion Assoc par Admin ////////////////////////////
Route::middleware('auth:sanctum')->group(function () {
    Route::get('showAssoc', [GestionAssocController::class, "showAssoc"]);
    Route::put('udpateAssoc', [GestionAssocController::class, 'updateAssoc']);
    Route::delete('deleteAssoc', [GestionAssocController::class, 'deleteAssoc']);
});

////////////////////////passwordOublie//////////////////
Route::post('/forgetpassword', [AdminController::class, 'forgetpassword']);
/////////////////////////gestion Events par User Comite ////////////////////////////
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/events', [ComiteController::class, 'savenewevent']);
    Route::delete('/events', [ComiteController::class, 'deleteevent']);
});
