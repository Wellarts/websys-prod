<?php

use App\Http\Controllers\ComprovantesController;
use Illuminate\Support\Facades\Route;

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

//Route::get('pdf/{id}', [ComprovantesController::class, 'geraPDF'])->name('comprovante');
Route::get('pdf/{id}',[ComprovantesController::class, 'geraPdf'])->name('comprovante');