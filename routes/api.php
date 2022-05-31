<?php

use App\Http\Controllers\ComiteController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\UserComiteController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssocController;
use App\Http\Controllers\RiverainController;
use App\Models\Admin;
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

Route::post('/events', [ComiteController::class, 'savenewevent']);


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
  
});

Route::post('/riverain', [RiverainController::class, 'store']);

Route::post('/assoc', [AssocController::class, 'store']);

Route::post('/connexionAdmin', [AdminController::class, 'connexion']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard', [AdminController::class, "dashboard"]);
    Route::post('registerAdmin', [AdminController::class, "inscription"]);
    Route::get('showAdmin', [AdminController::class, "showAdmin"]);
    route::put('udpateAdmin', [AdminController::class, "udpateAdmin"]);
    route::delete('deleteAdmin', [AdminController::class, "deleteAdmin"]);
});
