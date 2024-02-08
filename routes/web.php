<?php

use App\Models\Tours;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

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

Route::get('/admin', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('example');
});

Route::get('/print/{tour}', function (Tours $tour) {
    // return view("print", ['tour' => $tour, "itineraries" => $tour->itineraries]);
    $dompdf = App::make("dompdf.wrapper");
    $dompdf->loadView("print", ['tour' => $tour, "itineraries" => $tour->itineraries]);
    return $dompdf->stream();
});
