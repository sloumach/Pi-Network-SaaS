<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\HistoriquesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::get('/services', function () {
    return view('nosservices');
})->name('services');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/plans', [App\Http\Controllers\PlansController::class, 'create'])->name('plans');
    Route::get('/languages', [App\Http\Controllers\LanguagesController::class, 'create'])->name('languages');
    Route::get('/covers', [App\Http\Controllers\CoversController::class, 'create'])->name('covers');
    Route::get('/historiquelanguages', [HistoriquesController::class, 'historiqueLanguages'])->name('historiqueslanguages');
    Route::get('/historiquecovers', [HistoriquesController::class, 'historiqueCovers'])->name('historiquescovers');
    Route::get('/paiement', [App\Http\Controllers\PaiementController::class, 'create'])->name('paiement');
    Route::get('/paiement', [App\Http\Controllers\CoversController::class, 'checkCoverStatus'])->name('CheckCover');
    Route::get('/paiement', [App\Http\Controllers\PaiementController::class, 'checkLanguageStatus'])->name('CheckLanguage');
    Route::post('/getcover', [App\Http\Controllers\CoversController::class, 'GetCover'])->name('GetCover');
    Route::post('/getlanguage', [App\Http\Controllers\PaiementController::class, 'GetLanguage'])->name('GetLanguage');


});
