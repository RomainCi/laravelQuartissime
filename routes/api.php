<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssocController;
use App\Http\Controllers\RiverainController;
use App\Models\Admin;
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
