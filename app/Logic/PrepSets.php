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

    private function mapYearNineSets(string $code, string $subject)
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

        throw new \Exception('Something went wrong, could not match year 9 subject: '.$subject);
    }

    private function mapYearTenSets(string $code, $subject): string
    {
        // Sciences
        if (Str::startsWith($code, '10D6')) {
            // DAS in 6
            return substr($code, 2, 3);
        }
        if (Str::startsWith($code, '10D9')) {
            // DAS in 9
            return substr($code, 2, 3);
        }
        if (Str::startsWith($code, '10T')) {
            // Triple Award
            return substr($code, 2, 2);
        }

        // GCSE OPTIONS
        if (Str::startsWith($code, '10A')) {
            return 'Option A';
        }
        if (Str::startsWith($code, '10B')) {
            return 'Option B';
        }
        if (Str::startsWith($code, '10C')) {
            return 'Option C';
        }
        if (Str::startsWith($code, '10D')) {
            return 'Option D';
        }

        // MATHS / ENGLISH
        if (in_array($subject, ['Maths', 'English'])) {
            // Converts "103/En" to "3"
            return (int) substr($code, 2, 1);
        }

        // CMFL
        if (preg_match('^\A[0-9]{3}/(Fr|Sp)\Z^', $code, $matches)) {
            return 'CMFL';
        }
        if (in_array($subject, [
            'Greek',
            'Philosophy',

        ])) {
            return (int) substr($code, -1, 1);
        }

        throw new \Exception('Something went wrong, could not match year 10 subject: '.$subject);
    }

    private function mapYearElevenSets(string $code, string $subject): string
    {
        // 2022-09-02 - should be the same as last years code, nothing change here. (Next year will change)

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

        if (preg_match('^\A11-(FR|SP)[0-9]{1}\Z^', $code, $matches)) {
            return 'CMFL';
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
            'Design Engineering',
            'Music',
            'Theatre Studies',
            'French',
        ])) {
            return (int) substr($code, -1, 1);
        }
        throw new \Exception('Something went wrong, could not match year 11 subject: '.$subject);
    }

    /**
     * @param  string  $code
     * @param  string  $subject
     * @return int|string
     *
     * @throws \Exception
     */
    public function mapSets(string $code, string $subject): string|int
    {
        if (Str::startsWith($code, '11')) {
            // Year 11 Sets
            return $this->mapYearElevenSets($code, $subject);
        }
        if (Str::startsWith($code, '10')) {
            return $this->mapYearTenSets($code, $subject);
        }
        if (Str::startsWith($code, '9')) {
            return $this->mapYearNineSets($code, $subject);
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
        //dump($sets);
        $sets = $sets->flip();
        $sets = $sets->map([$this, 'mapSets']);
        //dd($sets);
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

                $unsets = ['Biology', 'Chemistry', 'Physics', 'Geography', 'History', 'Religious Studies', 'Digital Literacy'];
            }

            $matchSets = $this->matchSets($sets, $unsets);
        } catch (\ErrorException $error) {
            throw new \ErrorException($error->getMessage().' on pupil: '.$this->pupil->fullName);
        }

        ksort($matchSets);
        //dd($matchSets);
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
