<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\PaiementController;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
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


/* Auth::routes(); */
Auth::routes(['verify' => true]);


Route::get('/', function () {
    return view('welcome');
});
Route::get('/services', function () {
    return view('nosservices');
})->name('services');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/plans', [App\Http\Controllers\PlansController::class, 'create'])->name('plans');

    Route::get('/languages', [App\Http\Controllers\LanguagesController::class, 'create'])->name('languages');
    Route::get('/checklanguage', [App\Http\Controllers\LanguagesController::class, 'checkLanguageStatus'])->name('CheckLanguage');
    Route::post('/getlanguage', [App\Http\Controllers\LanguagesController::class, 'GetLanguage'])->name('GetLanguage');

    Route::get('/historiquelanguages', [HistoriquesController::class, 'historiqueLanguages'])->name('historiqueslanguages');
    Route::get('/historiquecovers', [HistoriquesController::class, 'historiqueCovers'])->name('historiquescovers');

    Route::get('/covers', [App\Http\Controllers\CoversController::class, 'create'])->name('covers');
    Route::get('/checkcover', [App\Http\Controllers\CoversController::class, 'checkCoverStatus'])->name('CheckCover');
    Route::post('/getcover', [App\Http\Controllers\CoversController::class, 'GetCover'])->name('GetCover');

    Route::post('/saveCover', [App\Http\Controllers\UserController::class, 'saveCover'])->name('saveCover');


    Route::get('/showpaiement/{id}', [App\Http\Controllers\PaiementController::class, 'create'])->name('paiement');
    Route::post('/paiement', [App\Http\Controllers\PaiementController::class, 'create'])->name('confirmPaiement');

    Route::get('/editor/{id}', [UserController::class, 'editor'])->name('editor');


});
