<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetupRequest;
use App\Logic\PrepSets;
use App\Models\PrepDay;
use App\Http\Requests\TimetableRequest;

/**
 *
 */
class PrepTimetableController extends Controller
{
    use PrepSets;
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function home()
    {
        return view('start');
    }

    /**
     * @param  \App\Http\Requests\SetupRequest  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function setup(SetupRequest $request)
    {
        $yearGroup = $request->yearGroup;
        $days = PrepDay::all();
        $sets = $request->sets;

        $setResults = $this->calculateSets($yearGroup, $sets);

        $timetable = [];
        return view('setup', compact('days', 'request', 'timetable', 'sets', 'yearGroup', 'setResults'));
    }


    /**
     * @param  int  $yearGroup
     * @param  \App\Http\Requests\TimetableRequest  $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function generate(int $yearGroup, TimetableRequest $request)
    {
        $days = PrepDay::all();
        $yearGroup = $request->yearGroup;
        $timetable = PrepDay::getTimetable($yearGroup, $request);

        return view('timetable', compact('days', 'request', 'timetable', 'yearGroup'));
    }

}
