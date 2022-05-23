<?php

use App\Http\Controllers\PublicController;
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

Route::post('/publics', [PublicController::class, 'sendcoordsdata']);

Route::get("/publics", [PublicController::class, "affichageComites"]);

Route::get('/publics/{id}', [PublicController::class, "showDetailsComite"]);

Route::get("/publics", [PublicController::class, "affichageAssociations"]);

Route::get('/publics/{id}', [PublicController::class, "showDetailsAssociation"]);

Route::get('/comites/nearest', [PublicController::class, "calcultop3assocomite"]);
