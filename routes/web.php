<?php

//use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});
*/

use App\Http\Controllers\HomeLandController;
use Illuminate\Support\Facades\Route;

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::get('/user/{id}', function (string $id) {
    return 'User '.$id;
});


Route::get('/hello/{name?}', function (string $name = "Pepe") {
    return 'Hello '.$name.', welcome to Laravel.';;
});

/*
Route::get('/', [SiteController::class, 'index']);
Route::get('/services', [SiteController::class, 'services']);
Route::get('/contact', [SiteController::class, 'contact']);
Route::get('/about', [SiteController::class, 'about']);
*/

Route::get('/', [HomeLandController::class, 'index'])->name('home');
Route::match(['get', 'post'],'/property_details/{property_id}', [HomeLandController::class, 'property_details'])->name('property_details');
Route::get('/buy', [HomeLandController::class, 'buy'])->name('buy');
Route::get('/rent', [HomeLandController::class, 'rent'])->name('rent');
Route::get('/properties/{property_listing_type_id}', [HomeLandController::class, 'properties_listing_type'])->name('properties_listing_type');
Route::get('/about', [HomeLandController::class, 'about'])->name('about');
Route::get('/contact', [HomeLandController::class, 'contact'])->name('contact');
Route::get('/login', [HomeLandController::class, 'login'])->name('login');
Route::get('/register',[HomeLandController::class, 'register'])->name('register');
Route::post('/contact', [HomeLandController::class, 'sendContactMessage'])->name('contact.send');
