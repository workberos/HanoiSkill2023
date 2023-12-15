<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TicketController;

use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'login_post'])->name('login_post');

Route::get('/logout', [LoginController::class, 'login'])->name('logout');




Route::resource('event', EventController::class);
Route::get('event/{event}/ticket/create', [TicketController::class ,'create'])->name('ticket.create');
Route::post('event/{event}/ticket/store', [TicketController::class ,'store'])->name('ticket.store');

Route::get('event/{event}/session/create', [SessionController::class ,'create'])->name('session.create');
Route::post('event/{event}/session/store', [SessionController::class ,'store'])->name('session.store');
Route::get('event/{event}/session/{session}/edit', [SessionController::class ,'edit'])->name('session.edit');
Route::put('event/{event}/session/{session}/update', [SessionController::class ,'update'])->name('session.update');

Route::get('event/{event}/room/create', [RoomController::class ,'create'])->name('room.create');
Route::post('event/{event}/room/store', [RoomController::class ,'store'])->name('room.store');



