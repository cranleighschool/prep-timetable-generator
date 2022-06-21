<?php

use App\Http\Controllers\PrepTimetableController;
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

Route::get('/', [PrepTimetableController::class, 'home'])->name('start');
Route::get('setup', [PrepTimetableController::class, 'setup'])->name('setup');
Route::post('generate/{yearGroup}', [PrepTimetableController::class, 'generate'])->name('timetable');
Route::get('house/{house}', [PrepTimetableController::class, 'byHouse'])->name('byHouse');
