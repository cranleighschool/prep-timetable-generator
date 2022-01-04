<?php

use App\Http\Controllers\Isams\SubjectsController;
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

    return view('start');
})->name("start");

Route::get('setup', function (\App\Http\Requests\SetupRequest $request) {
    $yearGroup = $request->yearGroup;
    $days = \App\Models\PrepDay::all();
    $sets = $request->sets;

    $timetable = [];
    return view('setup', compact('days', 'request', 'timetable', 'sets', 'yearGroup'));
})->name('setup');

Route::post('generate/{yearGroup}', function (int $yearGroup, \App\Http\Requests\TimetableRequest $request) {
    $days = \App\Models\PrepDay::all();
    $yearGroup = $request->yearGroup;
    $timetable = \App\Models\PrepDay::getTimetable($yearGroup, $request);
    //dd($timetable);
    return view('timetable', compact('days', 'request', 'timetable', 'yearGroup'));
})->name('timetable');
