<?php

namespace App\Logic;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class GenerateTimetable
{
    public const MONDAY = 'Monday';

    public const TUESDAY = 'Tuesday';

    public const WEDNESDAY = 'Wednesday';

    public const THURSDAY = 'Thursday';

    public const FRIDAY = 'Friday';

    /**
     * @var array
     */
    private array $timetable = [];
    /**
     * @var int
     */
    private int $yearGroup;
    /**
     * @var \Illuminate\Http\Request|\stdClass
     */
    private Request|\stdClass $request;
    /**
     * @var \Illuminate\Support\Collection
     */
    private Collection $days;

    /**
     * @param  int  $yearGroup
     * @param  \Illuminate\Http\Request|\stdClass  $request
     * @param  \Illuminate\Support\Collection  $days
     */
    public function __construct(int $yearGroup, Request|\stdClass $request, Collection $days)
    {
        $this->days = $days;
        $this->yearGroup = $yearGroup;
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getTimetable(): array
    {
        $timetable = match ($this->yearGroup) {
            9 => $this->year9Timetable(),
            10 => $this->year10Timetable(),
            11 => $this->year11Timetable(),
            default => throw new \spkm\isams\Exceptions\ValidationException('Year group not valid')
        };

        return collect($timetable)->map(function (array $day) {
            return collect($day)->reject(function (string|null $subject) {
                return is_null($subject);
            })->toArray();
        })->toArray();
    }

    /**
     * @param  string  $day
     * @param  string|null  $subject
     * @return void
     */
    private function addToTimetable(string $day, string|null $subject): void
    {
        array_push($this->timetable[$day], $subject);
    }

    /**
     * @return array
     */
    private function year9Timetable(): array
    {
        $request = $this->request;
        foreach ($this->days as $day) {
            $this->timetable[$day->day] = [];
            foreach ($day->sciences->where('set', $request->science_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->humanities->where('set',
                $request->humanities_set)->pluck('subject')->toArray() as $humanity) {
                self::addToTimetable($day->day, $humanity);
            }
            foreach ($day->classics->where('set',
                $request->classciv_set)->pluck('subject')->toArray() as $classic) {
                self::addToTimetable($day->day, $classic);
            }
            switch ($day->day) {
                case self::MONDAY:
                    self::addToTimetable($day->day, $request->optiona);
                    self::addToTimetable($day->day, $request->cmfl);
                    break;
                case self::TUESDAY:
                    self::addToTimetable($day->day, 'English');
                    break;
                case self::WEDNESDAY:
                    self::addToTimetable($day->day, $request->optionb);
                    if (Str::contains($request->maths_set, 'Y')) {
                        self::addToTimetable($day->day, 'Maths');
                    }
                    break;
                case self::THURSDAY:
                    self::addToTimetable($day->day, 'Maths');
                    if ($request->latin === true) {
                        self::addToTimetable($day->day, 'Latin');
                    }
                    break;
                case self::FRIDAY:
                    self::addToTimetable($day->day, $request->optionc);
                    if (Str::contains($request->maths_set, 'X')) {
                        self::addToTimetable($day->day, 'Maths');
                    }
                    break;
            }
        }

        return $this->timetable;
    }

    /**
     * @return array
     */
    private function year10Timetable(): array
    {
        $request = $this->request;
        foreach ($this->days as $day) {
            $this->timetable[$day->day] = [];
            foreach ($day->biology->where('set', $request->biology_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->physics->where('set', $request->physics_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->chemistry->where('set', $request->chemistry_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }

            switch ($day->day) {
                case self::MONDAY:
                    self::addToTimetable($day->day, $request->optionb);
                    self::addToTimetable($day->day, 'English');
                    self::addToTimetable($day->day, $request->cmfl);
                    break;
                case self::TUESDAY:
                    self::addToTimetable($day->day, $request->optiona);
                    self::addToTimetable($day->day, $request->optionc);
                    break;
                case self::WEDNESDAY:
                    self::addToTimetable($day->day, $request->optionc);
                    self::addToTimetable($day->day, 'Maths');
                    break;
                case self::THURSDAY:
                    self::addToTimetable($day->day, 'English');
                    self::addToTimetable($day->day, $request->optiond);
                    break;
                case self::FRIDAY:
                    self::addToTimetable($day->day, $request->optionb);
                    self::addToTimetable($day->day, $request->optiond);
                    self::addToTimetable($day->day, $request->cmfl);
                    break;
            }
        }

        return $this->timetable;
    }

    /**
     * @return array
     */
    private function year11Timetable(): array
    {
        $request = $this->request;
        foreach ($this->days as $day) {
            $this->timetable[$day->day] = [];
            foreach ($day->biology->where('set', $request->biology_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->physics->where('set', $request->physics_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->chemistry->where('set', $request->chemistry_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }

            switch ($day->day) {
                case self::MONDAY:
                    self::addToTimetable($day->day, $request->cmfl);
                    self::addToTimetable($day->day, 'Maths');
                    break;
                case self::TUESDAY:
                    self::addToTimetable($day->day, 'English');
                    self::addToTimetable($day->day, $request->optiona);
                    self::addToTimetable($day->day, $request->optionc);
                    break;
                case self::WEDNESDAY:
                    self::addToTimetable($day->day, $request->optionb);
                    self::addToTimetable($day->day, $request->cmfl);
                    self::addToTimetable($day->day, $request->optiond);
                    break;
                case self::THURSDAY:
                    self::addToTimetable($day->day, 'English');
                    self::addToTimetable($day->day, $request->optiond);
                    break;
                case self::FRIDAY:
                    self::addToTimetable($day->day, $request->optiona);
                    self::addToTimetable($day->day, $request->optionb);
                    self::addToTimetable($day->day, $request->optionc);
                    self::addToTimetable($day->day, 'Maths');
                    break;
            }
        }

        return $this->timetable;
    }
}
