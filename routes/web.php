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

Route::get('/', function (\Illuminate\Http\Request $request) {
    $days = \App\Models\PrepDay::all();
    $timetable = [];
    return view('test', compact('days', 'request', 'timetable'));
});
Route::post('/', function (\App\Http\Requests\TimetableRequest $request) {
    $days = \App\Models\PrepDay::all();
    $timetable = [];
    foreach ($days as $day) {
        $timetable[ $day->day ] = [];
        foreach ($day->sciences->where("set", $request->science_set)->pluck('subject')->toArray() as $science) {
            array_push($timetable[ $day->day ], $science);
        }
        foreach ($day->humanities->where("set", $request->humanities_set)->pluck('subject')->toArray() as $humanity) {
            array_push($timetable[ $day->day ], $humanity);
        }
        foreach ($day->classics->where("set", $request->classciv_set)->pluck('subject')->toArray() as $classic) {
            array_push($timetable[ $day->day ], $classic);
        }
        switch ($day->day) {
            case "Monday":
                array_push($timetable[ $day->day ], $request->optiona);
                array_push($timetable[ $day->day ], $request->cmfl);
                break;
            case "Tuesday":
                array_push($timetable[ $day->day ], "English");
                break;
            case "Wednesday":
                array_push($timetable[ $day->day ], $request->optionb);
                if (\Illuminate\Support\Str::contains($request->maths_set, "X")) {
                    array_push($timetable[ $day->day ], "Maths");
                }
                break;
            case "Thursday":
                array_push($timetable[ $day->day ], "Maths");
                if ($request->latin === true) {
                    array_push($timetable[ $day->day ], "Latin");
                }
                break;
            case "Friday":
                array_push($timetable[ $day->day ], $request->optionc);
                if (\Illuminate\Support\Str::contains($request->maths_set, "Y")) {
                    array_push($timetable[ $day->day ], "Maths");
                }
                break;
        }

    }

    return view('test', compact('days', 'request', 'timetable'));
});
