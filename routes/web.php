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
});
Route::post('/', function (\App\Http\Requests\PupilRequest $request) {
    $sets = $request->sets;
    $pupilName = $request->pupil->fullName. " '".$request->pupil->preferredName."' (".$request->pupil->boardingHouse.")";
    $numSubjects = $sets->count();
    $yearGroup = $request->pupil->yearGroup;

    return view('welcome', compact('pupilName', 'numSubjects', 'yearGroup', 'sets'));
});


Route::get('setup/{yearGroup}', function (\App\Http\Requests\SetupRequest $request, int $yearGroup) {
    if ($yearGroup !== $request->yearGroup) {
        abort(400, "Looks like you're trying to cheat the system!");
    }
    $days = \App\Models\PrepDay::all();
    $sets = $request->sets;

    $timetable = [];
    return view('setup', compact('days', 'request', 'timetable', 'sets', 'yearGroup'));
});
Route::post('generate/{yearGroup}', function (\App\Http\Requests\TimetableRequest $request, int $yearGroup) {
    $days = \App\Models\PrepDay::all();
    $yearGroup = $request->yearGroup;
    $timetable = \App\Models\PrepDay::getTimetable($yearGroup, $request);

    return view('timetable', compact('days', 'request', 'timetable', 'yearGroup'));
});
