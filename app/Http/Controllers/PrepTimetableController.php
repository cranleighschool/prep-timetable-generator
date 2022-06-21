<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetupRequest;
use App\Http\Requests\TimetableRequest;
use App\Logic\GenerateTimetable;
use App\Logic\PrepSets;
use App\Models\PrepDay;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrepTimetableController extends Controller
{
    use PrepSets;

    /**
     * @param  string  $house
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * @throws \Exception
     */
    public function byHouse(string $house)
    {
        $api = new ApiController();
        $house = ucfirst($house);

        $validator = Validator::make(['house' => $house], [
            'house' => [
                'required',
                Rule::in(config('timetable.houses')),
            ],
        ]);
        if ($validator->fails()) {
            throw new \Exception('Invalid House');
        }

        $data = $api->getHouseData($house);

        return view('house', compact('data'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function home()
    {
        return view('start');
    }

    /**
     * @param  \App\Http\Requests\SetupRequest  $request
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function generate(int $yearGroup, TimetableRequest $request)
    {
        $days = PrepDay::all();
        $yearGroup = $request->yearGroup;
        $timetable = (new GenerateTimetable($yearGroup, $request, $days))->getTimetable();

        return view('timetable', compact('days', 'request', 'timetable', 'yearGroup'));
    }
}
