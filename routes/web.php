<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function() {
    Route::post('/create', [App\Http\Controllers\EventController::class, 'createEvent'])->name('create-event');
    Route::get('/create-event', [App\Http\Controllers\EventController::class, 'index'])->name('create-event-view');
    Route::get('/view-single-event/{id}', [App\Http\Controllers\EventController::class, 'viewSingleEvent']);
    Route::get('/event/{id}', [App\Http\Controllers\EventController::class, 'viewEvent'])->name('view-event');
    Route::get('/events', [App\Http\Controllers\EventController::class, 'viewEvents'])->name('view-events');
});
