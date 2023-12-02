<?php

use App\Http\Controllers\AgenciesController;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\ToursController;
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

Route::post('user/login', [AuthController::class, 'authenticate']);

Route::resource('agencies', AgenciesController::class);
Route::get('/all_agencies', [AgenciesController::class, 'all']);
Route::get('/deleted_agencies', [AgenciesController::class, 'deleted']);
Route::post('/agencies/{id}/restore', [AgenciesController::class, 'restore']);

Route::resource('artists', ArtistsController::class);
Route::get('/all_artists', [ArtistsController::class, 'all']);
Route::get('/deleted_artists', [ArtistsController::class, 'deleted']);
Route::post('/artists/{id}/restore', [ArtistsController::class, 'restore']);
Route::post('/artists/agency',[ArtistsController::class,'artistsByAgency']);

Route::resource('tours', ToursController::class);
Route::get('/all_tours', [ToursController::class, 'all']);
Route::get('/deleted_tours', [ToursController::class, 'deleted']);
Route::post('/tours/{id}/restore', [ToursController::class, 'restore']);
Route::post('/tours/agency',[ToursController::class,'toursByAgency']);

Route::get('/countries', [CountriesController::class, 'index']);

Route::post('/cities',[CitiesController::class,'citiesByCountry']);
