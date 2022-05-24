<?php

namespace App\Logic;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait PrepSets
{
    /**
     * @param  string  $code
     * @param  string  $subject
     *
     * @return int|string
     * @throws \Exception
     */
    public function mapSets(string $code, string $subject)
    {
        $e = explode("-", $code);

        if (Str::endsWith($e[ 0 ], "A")) {
            return 'Option A';
        }

        if (Str::endsWith($e[ 0 ], "B")) {
            return 'Option B';
        }

        if (Str::endsWith($e[ 0 ], "C")) {
            return 'Option C';
        }

        if (Str::endsWith($e[ 0 ], "D")) {
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
        ])) {
            return (int) substr($code, -1, 1);
        }

        throw new \Exception("Something went wrong, could not match: ".$subject);

    }

    /**
     * @param $sets
     * @param  array  $unsets
     *
     * @return array
     */
    private function matchSets($sets, array $unsets = []): array
    {
        foreach ($sets as $subject => $value) {
            if (in_array($subject, $unsets)) {
                continue;
            }
            if (in_array($value, ['Option A', 'Option B', 'Option C', 'Option D', 'CMFL'])) {
                $matchSets[ $value ] = $subject;
            } else {
                $matchSets[ $subject ] = $value;
            }
        }
        return $matchSets;
    }

    /**
     * @param  int  $yearGroup
     * @param  \Illuminate\Support\Collection  $sets
     *
     * @return array
     */
    private function calculateSets(int $yearGroup, Collection $sets)
    {
        $sets = $sets->flip();
        $sets = $sets->map([$this, 'mapSets']);
        $unsets = [];

        if ($yearGroup === 9) {
            if (($sets[ 'Biology' ] == $sets[ 'Physics' ]) && ($sets[ 'Physics' ]) == $sets[ 'Chemistry' ]) {
                $sets[ 'Science' ] = $sets[ 'Biology' ];
            }
            $sets[ 'Humanities' ] = $sets[ 'Religious Studies' ];

            $unsets = ['Biology', 'Chemistry', 'Physics', 'Geography', 'History', 'Religious Studies'];
        }

        $matchSets = $this->matchSets($sets, $unsets);

        ksort($matchSets);
        return $matchSets;
    }

}
