<?php

use App\Http\Controllers\AgenciesController;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CountriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('agencies', AgenciesController::class);
Route::get('/agencies/all', [AgenciesController::class, 'all']);
Route::get('/agencies/deleted', [AgenciesController::class, 'deleted']);
Route::post('/agencies/{id}/restore', [AgenciesController::class, 'restore']);

Route::resource('artists', ArtistsController::class);

Route::get('/countries', [CountriesController::class, 'index']);

Route::post('/cities',[CitiesController::class,'citiesByCountry']);
