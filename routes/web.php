<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssocController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RiverainController;
use App\Http\Controllers\AssociationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verifemail/{token}', [RiverainController::class, 'verif'])->name('verifemail.verif');

Route::get('/verifAssocEmail/{token}', [AssocController::class, 'verife'])->name('verifAssocEmail.verif');

Route::post('forgetPass', [AdminController::class, 'password'])->name('forgetPass.password');

Route::get('forgetPassword/{token}', [AdminController::class, 'rePassword'])->name('forgetpassword.rePassword');

Route::post('newPass', [AdminController::class, 'pass'])->name('newPass.pass');
