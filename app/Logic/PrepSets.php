<?php

namespace App\Logic;

use App\Exceptions\ZeroSetsFound;
use App\Http\Controllers\Isams\SubjectsController;
use App\Models\School;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use spkm\isams\Controllers\PupilTimetableController;
use spkm\isams\Wrappers\Pupil;

trait PrepSets
{
    /**
     * @var \spkm\isams\Wrappers\Pupil
     */
    public Pupil $pupil;

    /**
     * @param  string  $code
     * @param  string  $subject
     * @return int|string
     *
     * @throws \Exception
     */
    public function mapSets(string $code, string $subject)
    {
        $e = explode('-', $code);

        if (Str::endsWith($e[0], 'A')) {
            return 'Option A';
        }

        if (Str::endsWith($e[0], 'B')) {
            return 'Option B';
        }

        if (Str::endsWith($e[0], 'C')) {
            return 'Option C';
        }

        if (Str::endsWith($e[0], 'D')) {
            return 'Option D';
        }

        if (preg_match('^\A(9|10|11)-(FR|SP)[0-9]{1}\Z^', $code, $matches)) {
            return 'CMFL';
        }

        if (preg_match('^\A(9)-(MA)+(.*)^', $code, $matches)) {
            return substr($code, -2, 2);
        }

        if (in_array($subject, [
            'Maths',
            'Geography',
            'History',
            'Biology',
            'Physics',
            'Chemistry',
            'Religious Studies',
            'Classical Civilisation',
            'English',
            'Latin',
            'Philosophy',
            'Greek',
            'Supervised Private Study',
            'German',
            'Spanish',
        ])) {
            return (int) substr($code, -1, 1);
        }

        throw new \Exception('Something went wrong, could not match: '.$subject);
    }

    /**
     * @param  Collection  $sets
     * @param  array  $unsets
     * @return array
     */
    private function matchSets(Collection $sets, array $unsets = []): array
    {
        $matchSets = [];
        foreach ($sets as $subject => $value) {
            if (in_array($subject, $unsets)) {
                continue;
            }
            if (in_array($value, ['Option A', 'Option B', 'Option C', 'Option D', 'CMFL'])) {
                $matchSets[$value] = $subject;
            } else {
                $matchSets[$subject] = $value;
            }
        }

        return $matchSets;
    }

    /**
     * @param  int  $yearGroup
     * @param  \Illuminate\Support\Collection  $sets
     * @return array
     */
    private function calculateSets(int $yearGroup, Collection $sets)
    {
        $sets = $sets->flip();
        $sets = $sets->map([$this, 'mapSets']);
        $unsets = [];

        if ($sets->isEmpty()) {
            throw new ZeroSetsFound($this->pupil->fullName.' has no sets assigned');
        }

        try {
            if ($yearGroup === 9) {
                if (($sets['Biology'] == $sets['Physics']) && ($sets['Physics']) == $sets['Chemistry']) {
                    $sets['Science'] = $sets['Biology'];
                }
                $sets['Humanities'] = $sets['Religious Studies'] ?? $sets['Geography'];

                $unsets = ['Biology', 'Chemistry', 'Physics', 'Geography', 'History', 'Religious Studies'];
            }

            $matchSets = $this->matchSets($sets, $unsets);
        } catch (\ErrorException $error) {
            throw new \ErrorException($error->getMessage().' on pupil: '.$this->pupil->fullName);
        }

        ksort($matchSets);

        return $matchSets;
    }

    /**
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getPupilAndSets(): array
    {
        $sets = Cache::remember('sets_'.$this->pupil->schoolId, now()->addHours(2), function () {
            $timetable = new PupilTimetableController(School::find(1));

            return collect($timetable->show($this->pupil->schoolId)['sets'])->pluck('code',
                'subjectId')->unique()->toArray();
        });

        return $sets;
    }

    /**
     * @param  string  $username
     * @return void
     */
    public function setPupil(string $username)
    {
        $this->pupil = School::getPupil($username);
    }

    /**
     * @param  array  $sets
     * @return \Illuminate\Support\Collection
     */
    public static function getSets(array $sets): Collection
    {
        return Cache::rememberForever('sets'.serialize($sets), function () use ($sets) {
            $subjectController = new SubjectsController(new School());
            $sets = collect($sets)->map(function ($item, $key) use ($subjectController) {
                $subject = $subjectController->show($key);
                $subject['set'] = $item;

                return $subject;
            })->pluck('name', 'set');

            return $sets;
        });
    }
}
