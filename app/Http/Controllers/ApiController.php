<?php

namespace App\Http\Controllers;

use App\Exceptions\TutorNotFoundToHaveAnyTutees;
use App\Exceptions\ZeroSetsFound;
use App\Http\Resources\PupilTimetableResource;
use App\Logic\PrepSets;
use App\Models\School;
use ErrorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ApiController
{
    use PrepSets;

    /**
     * Get House Data.
     *
     * This is a description of what this method does!
     *
     * @response JsonResponse
     */
    public function getHouseData(string $house): JsonResponse
    {
        $allPupils = School::allPupils()->filter(function ($item) use ($house) {
            return $item->boardingHouse == $house;
        })->groupBy(['yearGroup']);

	$allPupils->forget(9);

        $result = [];

        foreach ($allPupils as $yearGroup => $pupils) {
            foreach (collect($pupils)->sortBy('surname') as $pupil) {
                $emailAddress = $pupil->schoolEmailAddress;

                try {
                    $result[$yearGroup][$pupil->surname.', '.$pupil->forename] = Cache::remember('getpupiltimetable'.$pupil->schoolEmailAddress, (int) config('cache.time'), function () use ($emailAddress) {
                        return $this->getPupilTimetable(Str::before($emailAddress, '@'))->getData()->timetable;
                    });
                } catch (ZeroSetsFound $exception) {
                    $result['errors'][] = $exception->getMessage().' so they are missed out from the sheet below';
                    Log::error($exception->getMessage());
                }
            }
        }
        ksort($result);

        return response()->json($result);
    }

    /**
     * @param  string  $tutorUsername  The username of the staff tutor
     *
     * @throws TutorNotFoundToHaveAnyTutees
     * @throws ValidationException
     * @throws ZeroSetsFound|ErrorException
     */
    public function getTutorData(string $tutorUsername): JsonResponse
    {
        $tutorUsername = strtoupper($tutorUsername);
        $allPupils = School::allPupils()->where('tutorUsername', '=', $tutorUsername)->groupBy(['tutorUsername', 'yearGroup']);

        if ($allPupils->isEmpty() || ! $allPupils[$tutorUsername] instanceof Collection) {
            throw new TutorNotFoundToHaveAnyTutees('Either Tutor not found or Tutor does not have any tutees in the dataset', 404);
        }
        $result = [];
        foreach ($allPupils[$tutorUsername] as $yearGroup => $pupils) {
            // @phpstan-ignore-next-line
            foreach (collect($pupils)->sortBy('surname') as $pupil) {
                $emailAddress = $pupil->schoolEmailAddress;
                $result[$yearGroup][$pupil->surname.', '.$pupil->forename] = $this->getPupilTimetable(Str::before(
                    $emailAddress,
                    '@'
                ))->getData()->timetable;
            }
        }
        ksort($result);

        return response()->json($result);
    }

    /**
     * @throws ErrorException
     * @throws ValidationException
     * @throws ZeroSetsFound
     *
     * @response PupilTimetableResource
     */
    public function getPupilTimetable(string $username): JsonResponse
    {
        $this->setPupil($username);
        $yearGroup = $this->pupil->yearGroup;
        $sets = self::getSets($this->getPupilAndSets());

        try {
            $setResults = $this->calculateSets($yearGroup, $sets);
            $request = $this->sanitizeVariables($yearGroup, $setResults);
        } catch (ZeroSetsFound $exception) {
            throw new ZeroSetsFound($exception->getMessage().' for '.$username);
        }

        return response()->json(new PupilTimetableResource([
            'yearGroup' => $yearGroup,
            'fields' => $request,
            // 'timetable' => (new GenerateTimetable($yearGroup, $request, PrepDay::all()))->getTimetable(),
            'username' => $username,
            'subjects' => $sets->sort(),
            'results' => $setResults,
        ]));
    }

    /**
     * @throws ErrorException
     * @param int  $yearGroup
     * @param array<int|string, int|string>  $setResults
     *
     */
    private function sanitizeVariables(int $yearGroup, array $setResults): object
    {
        try {
            $output = [
                'yearGroup' => $yearGroup,
                'optiona' => $setResults['Option A'] ?? null,
                'optionb' => $setResults['Option B'] ?? null,
                'optionc' => $setResults['Option C'] ?? null,
                'optiond' => $setResults['Option D'] ?? null,
                'optione' => $setResults['Option E'] ?? null,
                'cmfl' => $setResults['CMFL'] ?? null,
                'english_set' => $setResults['English'],
                'maths_set' => $setResults['Maths'],
            ];

            if ($yearGroup === 9) {
                return (object) array_merge([
                    'science_set' => $setResults['Science'],
                    'humanities_set' => $setResults['Humanities'],
                    'classciv_set' => $setResults['Classical Civilisation'] ?? null,
                    'latin' => $setResults['Latin'] ?? null,
                ], $output);
            }

            return (object) array_merge([
                'biology_set' => $setResults['Biology'] ?? null,
                'chemistry_set' => $setResults['Chemistry'] ?? null,
                'physics_set' => $setResults['Physics'] ?? null,
            ], $output);
        } catch (ErrorException $errorException) {
            throw new ErrorException($errorException->getMessage().' on pupil: '.$this->pupil->fullName);
        }
    }
}
