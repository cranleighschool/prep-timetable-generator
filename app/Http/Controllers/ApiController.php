<?php

namespace App\Http\Controllers;

use App\Exceptions\TutorNotFoundToHaveAnyTutees;
use App\Exceptions\ZeroSetsFound;
use App\Logic\GenerateTimetable;
use App\Logic\PrepSets;
use App\Models\PrepDay;
use App\Models\School;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ApiController
{
    use PrepSets;

    /**
     * @param  string  $house
     * @return \Illuminate\Support\Collection
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getHouseData(string $house): Collection
    {
        $allPupils = School::allPupils()->filter(function($item) use ($house) {
            return $item->boardingHouse == $house;
        })->groupBy(['yearGroup']);

        $result = [];

        foreach ($allPupils as $yearGroup => $pupils) {
            foreach (collect($pupils)->sortBy('surname') as $pupil) {
                $emailAddress = $pupil->schoolEmailAddress;

                $result[$yearGroup][$pupil->surname.', '.$pupil->forename] = $this->getPupilTimetable(Str::before($emailAddress,
                    '@'))['timetable'];
            }
        }
        ksort($result);
        $result = collect($result);

        return $result;
    }

    /**
     * @param  string  $tutorUsername
     * @return \Illuminate\Support\Collection
     *
     * @throws \Illuminate\Validation\ValidationException|\App\Exceptions\TutorNotFoundToHaveAnyTutees
     */
    public function getTutorData(string $tutorUsername): Collection
    {
        $tutorUsername = strtoupper($tutorUsername);
        $allPupils = School::allPupils()->where('tutorUsername', '=', $tutorUsername)->groupBy(['tutorUsername', 'yearGroup']);

        if ($allPupils->isEmpty()) {
            throw new TutorNotFoundToHaveAnyTutees('Either Tutor not found or Tutor does not have any tutees in the dataset', 404);
        }
        $result = [];
        foreach ($allPupils[$tutorUsername] as $yearGroup => $pupils) {
            foreach (collect($pupils)->sortBy('surname') as $pupil) {
                $emailAddress = $pupil->schoolEmailAddress;

                $result[$yearGroup][$pupil->surname.', '.$pupil->forename] = $this->getPupilTimetable(Str::before($emailAddress,
                    '@'))['timetable'];
            }
        }
        ksort($result);
        $result = collect($result);

        return $result;
    }

    /**
     * @param  string  $username
     * @return Collection
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getPupilTimetable(string $username): Collection
    {
        $this->setPupil($username);
        $yearGroup = $this->pupil->yearGroup;
        $sets = self::getSets($this->getPupilAndSets());

        try {
            $setResults = $this->calculateSets($yearGroup, $sets);
            $request = $this->sanitizeVariables($yearGroup, $setResults);
        } catch (ZeroSetsFound $exception) {
            return collect([
                'timetable' => PrepDay::all()->map(function ($day) {
                    return ['No Subject Sets Assigned'];
                }),
            ]);
        }

        return collect([
            'timetable' => (new GenerateTimetable($yearGroup, $request, PrepDay::all()))->getTimetable(),
            'username' => $username,
            'yearGroup' => $yearGroup,
            'subjects' => $sets->sort(),
            'results' => $setResults,
        ]);
    }

    /**
     * @param  int  $yearGroup
     * @param  array  $setResults
     * @return object
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
        } catch (\ErrorException $errorException) {
            throw new \ErrorException($errorException->getMessage().' on pupil: '.$this->pupil->fullName);
        }
    }
}
