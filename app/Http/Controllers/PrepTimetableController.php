<?php

namespace App\Http\Controllers;

use App\Exceptions\TutorNotFoundToHaveAnyTutees;
use App\Exceptions\ZeroSetsFound;
use App\Http\Requests\SetupRequest;
use App\Http\Requests\TimetableRequest;
use App\Logic\GenerateTimetable;
use App\Logic\PrepSets;
use App\Models\PrepDay;
use ErrorException;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PrepTimetableController extends Controller
{
    use PrepSets;

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function byHouse(string $house): Renderable
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
            throw new Exception('Invalid House');
        }

        $data = $api->getHouseData($house)->getData(true);

        return view('house', compact('data'));
    }

    /**
     * @throws ValidationException
     * @throws Exception
     */
    public function byTutor(string $tutorUsername): Renderable
    {
        $api = new ApiController();
        $tutorUsername = strtolower($tutorUsername);

        $validator = Validator::make(['tutorUsername' => $tutorUsername], [
            'tutorUsername' => [
                'required',
                //Rule::in(config('timetable.houses')),
            ],
        ]);
        if ($validator->fails()) {
            throw new Exception('Invalid Tutor');
        }

        try {
            $data = $api->getTutorData($tutorUsername)->getData(true);
        } catch (TutorNotFoundToHaveAnyTutees $exception) {
            abort($exception->getCode(), $exception->getMessage());
        }

        return view('house', compact('data'));
    }

    public function home(): Renderable
    {
        return view('start');
    }

    /**
     * @throws ErrorException
     */
    public function setup(SetupRequest $request): Renderable|RedirectResponse
    {
        $yearGroup = $request->yearGroup;
        $days = PrepDay::all();
        $sets = $request->sets;

        try {
            $setResults = $this->calculateSets($yearGroup, $sets);
        } catch (ZeroSetsFound $exception) {
            return back()->withErrors("No sets found for {$request->pupil->forename} {$request->pupil->surname}.");
        }
        $timetable = [];
        return view('setup', compact('days', 'request', 'timetable', 'sets', 'yearGroup', 'setResults'));
    }

    /**
     * @throws \spkm\isams\Exceptions\ValidationException
     */
    public function generate(int $yearGroup, TimetableRequest $request): Renderable
    {
        $days = PrepDay::all();
        $yearGroup = $request->yearGroup;
        $timetable = (new GenerateTimetable($yearGroup, $request, $days))->getTimetable();

        return view('timetable', compact('days', 'request', 'timetable', 'yearGroup'));
    }
}
