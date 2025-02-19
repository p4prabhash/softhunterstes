<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ToDoController;
use App\Http\Controllers\GoogleCalendarController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/create-category', [AdminController::class, 'createCategory'])->name('admin.createCategory');
    Route::post('/admin/store-category', [AdminController::class, 'storeCategory'])->name('admin.storeCategory');

    Route::get('/user/dashboard', [ToDoController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/user/todos', [ToDoController::class, 'store'])->name('user.todos.store');
    Route::delete('/user/todos/{id}', [ToDoController::class, 'destroy'])->name('user.todos.destroy');
    Route::get('/rankings', [ToDoController::class, 'showRankings']);

});

Route::get('google/redirect', [GoogleCalendarController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('google-callback', [GoogleCalendarController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('google/calendar/events', [GoogleCalendarController::class, 'listGoogleCalendarEvents'])->name('google.calendar.events');
