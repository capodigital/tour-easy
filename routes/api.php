<?php

use App\Http\Controllers\AgenciesController;
use App\Http\Controllers\ArtistsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\ItinerariesController;
use App\Http\Controllers\PersonsController;
use App\Http\Controllers\PhotosController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\ToursController;
use App\Http\Controllers\TypeagenciesController;
use App\Http\Controllers\TypecontactsController;
use App\Http\Controllers\TypeitinerariesController;
use App\Http\Controllers\TypeplacesController;
use App\Http\Controllers\TypesocialmediasController;
use App\Http\Controllers\UserController;
use App\Models\Currency;
use App\Models\Language;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::resource('agencies', AgenciesController::class);
    Route::get('/all_agencies', [AgenciesController::class, 'all']);
    Route::post('/agency/user', [AgenciesController::class, 'agencyByUser']);
    Route::get('/deleted_agencies', [AgenciesController::class, 'deleted']);
    Route::post('/agencies/{id}/restore', [AgenciesController::class, 'restore']);
    Route::post('/agencies/password/{agency}', [AgenciesController::class, 'updatePassword']);


    Route::resource('artists', ArtistsController::class);
    Route::get('/all_artists', [ArtistsController::class, 'all']);
    Route::get('/deleted_artists', [ArtistsController::class, 'deleted']);
    Route::post('/artists/{id}/restore', [ArtistsController::class, 'restore']);
    Route::post('/artists/password/{artist}', [ArtistsController::class, 'updatePassword']);
    Route::post('/artists/agency', [ArtistsController::class, 'artistsByAgency']);

    Route::resource('tours', ToursController::class);
    Route::get('/all_tours', [ToursController::class, 'all']);
    Route::get('/deleted_tours', [ToursController::class, 'deleted']);
    Route::post('/tours/{id}/restore', [ToursController::class, 'restore']);
    Route::post('/tours/agency', [ToursController::class, 'toursByAgency']);
    Route::post('/tours/contacts', [ToursController::class, 'contacts']);
    Route::post('/tours/countries', [ToursController::class, 'countries']);
    Route::post('/tour', [ToursController::class, 'tour']);
    Route::post('/photos', [ToursController::class, 'photos']);
    Route::post('/tour/noactive', [ToursController::class, 'noactive']);

    Route::resource('persons', PersonsController::class);
    Route::post('/persons/agency', [PersonsController::class, 'personsByAgency']);
    Route::post('/persons/tour', [PersonsController::class, 'personsByTour']);

    Route::resource('places', PlacesController::class);

    Route::resource('groups', GroupsController::class);
    Route::post('/groups/agency', [GroupsController::class, 'getByAgency']);

    Route::resource('suppliers', SuppliersController::class);
    Route::post('/suppliers/agency', [SuppliersController::class, 'suppliersByAgency']);

    Route::resource('itineraries', ItinerariesController::class);
    Route::post('/itineraries/tour', [ItinerariesController::class, 'itinerariesByTour']);
    Route::get('/itineraries/{month}/{year}', [ItinerariesController::class, 'month']);
    Route::get('/itineraries/{day}/{month}/{year}', [ItinerariesController::class, 'day']);

    Route::get('/countries', [CountriesController::class, 'index']);

    Route::post('/cities', [CitiesController::class, 'citiesByCountry']);

    Route::resource('photos', PhotosController::class);


    Route::resource('tickets', TicketsController::class);
    Route::resource('typecontacts', TypecontactsController::class);
    Route::resource('typeagencies', TypeagenciesController::class);
    Route::resource('typeitineraries', TypeitinerariesController::class);
    Route::resource('typeplaces', TypeplacesController::class);
    Route::resource('typesocialmedia', TypesocialmediasController::class);
    Route::resource('typesocialmedias', TypesocialmediasController::class);

    Route::resource('documents', DocumentsController::class);

    Route::resource('users', UserController::class);
    Route::post('/users/password/{user}', [UserController::class, 'updatePassword']);
    Route::get('/currentitineraries', [ItinerariesController::class, 'getCurrent']);
    Route::get('/languages', function () {
        return response()->json(Language::all());
    });
    Route::get('/currencies', function () {
        return response()->json(Currency::all());
    });
});

Route::get('public/tours/{tour}', [ToursController::class, 'show']);
Route::get('public/artists/{artists}', [ArtistsController::class, 'show']);
Route::post('/photos/tour', [PhotosController::class, 'photosByTour']);

//Rutas accesibles por la landing page
Route::get('landing/tours', [ToursController::class, 'landing']);
Route::get('landing/artists', [ArtistsController::class, 'landing']);
Route::get('landing/agencies', [AgenciesController::class, 'landing']);
