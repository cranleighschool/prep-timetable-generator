<?php

namespace App\Logic;

use App\Exceptions\ZeroSetsFound;
use App\Http\Controllers\Isams\SubjectsController;
use App\Logic\SetMappers\Gcses;
use App\Logic\SetMappers\YearNine;
use App\Models\School;
use ErrorException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use spkm\isams\Controllers\PupilTimetableController;
use spkm\isams\Wrappers\Pupil;

trait PrepSets
{
    public Pupil $pupil;

    /**
     * @throws Exception
     *
     * @deprecated Use the YearNine and Gcses classes instead
     */
    private function mapYearNineSets(string $code, string $subject): int|string
    {
        // Latin
        if (in_array($code, ['9A/La3', '9A/La4'])) {
            return 'Latin';
        }

        // OPTIONS
        if (Str::startsWith($code, '9A') && ! Str::contains($code, ['Gg', 'Cc', 'Hi', 'Rs', 'La'])) {
            return 'Option A';
        }
        if (Str::startsWith($code, '9B')) {
            return 'Option B';
        }
        if (Str::startsWith($code, '9C')) {
            return 'Option C';
        }
        if (Str::startsWith($code, '9D')) {
            return 'Option D';
        }

        // Sciences
        if (Str::endsWith($code, ['Bi', 'Ch', 'Ph'])) {
            // Converts: 9.1/Bi to 1
            return (int) substr($code, 2, 1);
        }

        // Maths
        if (Str::endsWith($code, 'Ma')) {
            // Converts, 9Y1/Ma to Y1
            return substr($code, 1, 2);
        }

        // English
        if (Str::endsWith($code, 'En')) {
            return (int) substr($code, 2, 1);
        }

        // Humanities
        if (preg_match('^\A9(a|b|A)/(Hi|Cc|Gg|Rs)[0-9]{1}\Z^', $code, $matches)) {
            // Is humanity
            return strtolower(substr($code, 1, 1).substr($code, -1, 1));
        }

        // Languages
        if (Str::endsWith($code, 'Fr') || Str::endsWith($code, 'Sp')) {
            return 'CMFL';
        }

        if (in_array($subject, [
            'Latin',
            'Philosophy',
            'Digital Literacy',
        ])) {
            return (int) substr($code, -1, 1);
        }

        throw new Exception('Something went wrong, could not match year 9 subject: '.$subject);
    }

    /**
     * @throws Exception
     */
    public function mapSets(string $code, string $subject): string|int
    {
        if (Str::startsWith($code, '11')) {
            // Year 11 Sets
            return (new Gcses($code, $subject))->handle(11);
        }
        if (Str::startsWith($code, '10')) {
            // Year 10 Sets
            return (new Gcses($code, $subject))->handle(10);
        }
        if (Str::startsWith($code, '9')) {
            // Year 9 Sets
            return (new YearNine($code, $subject))->handle();
            //return $this->mapYearNineSets($code, $subject);
        }

        throw new Exception('Something went wrong, could not match: '.$subject);
    }

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
     * @throws ErrorException
     * @throws ZeroSetsFound
     */
    private function calculateSets(int $yearGroup, Collection $sets): array
    {
        $sets = $sets->flip();
        $sets = $sets->map([$this, 'mapSets']);
        $unsets = [];

        if ($sets->isEmpty()) {
            throw new ZeroSetsFound('no sets assigned');
        }

        try {
            if ($yearGroup === 9) {
                if (($sets['Biology'] == $sets['Physics']) && $sets['Physics'] == $sets['Chemistry']) {
                    $sets['Science'] = $sets['Biology'];
                }

                $sets['Humanities'] = $sets['Religious Studies'] ?? $sets['Geography'];

                $unsets = ['Biology', 'Chemistry', 'Physics', 'Geography', 'History', 'Religious Studies', 'Digital Literacy'];
            }

            $matchSets = $this->matchSets($sets, $unsets);
        } catch (ErrorException $error) {
            throw new ErrorException($error->getMessage().' on pupil');
        }

        ksort($matchSets);

        return $matchSets;
    }

    /**
     * @throws ValidationException
     */
    public function getPupilAndSets(): array
    {
        $sets = Cache::remember('sets_'.$this->pupil->schoolId, config('cache.time'), function () {
            $timetable = new PupilTimetableController(School::first());

            return collect($timetable->show($this->pupil->schoolId)['sets'])->pluck('code',
                'subjectId')->unique()->toArray();
        });

        return $sets;
    }

    public function setPupil(string $username): void
    {
        $this->pupil = School::getPupil($username);
    }

    public static function getSets(array $sets): Collection
    {
        return Cache::rememberForever('sets'.serialize($sets), function () use ($sets) {
            $subjectController = new SubjectsController(new School());

            return collect($sets)->map(function ($item, $key) use ($subjectController) {
                $subject = $subjectController->show($key);
                $subject['set'] = $item;

                return $subject;
            })->pluck('name', 'set');
        });
    }
}
