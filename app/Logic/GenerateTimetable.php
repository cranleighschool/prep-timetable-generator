<?php

namespace App\Logic;

use App\Models\PrepDay;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use spkm\isams\Exceptions\ValidationException;
use stdClass;

/**
 * @property int $yearGroup
 */
class GenerateTimetable
{
    public const MONDAY = 'Monday';

    public const TUESDAY = 'Tuesday';

    public const WEDNESDAY = 'Wednesday';

    public const THURSDAY = 'Thursday';

    public const FRIDAY = 'Friday';

    /**
     * @var array<string, mixed>
     */
    private array $timetable = [];

    private int $yearGroup;

    private Request|stdClass $request;

    /**
     * @var Collection<array-key,PrepDay>
     */
    private Collection $days;

    /**
     * @param  Collection<array-key, PrepDay>  $days
     */
    public function __construct(int $yearGroup, Request|stdClass $request, Collection $days)
    {
        $days->ensure(PrepDay::class);
        $this->days = $days;
        $this->yearGroup = $yearGroup;
        $this->request = $request;
    }

    /**
     * @throws ValidationException
     * @return array<string, array<string>>
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
            return collect($day)->reject(function (?string $subject) {
                return is_null($subject);
            })->toArray();
        })->toArray();
    }

    private function addToTimetable(string $day, mixed $subject): void
    {
        $this->timetable[$day][] = $subject;
    }

    /**
     * @return array<string, array<string>>
     */
    private function year9Timetable(): array
    {
        $request = $this->request;
        foreach ($this->days as $day) {
            $this->timetable[$day->day] = [];
            foreach ($day->sciences->where('set', $request->science_set)->where(
                'nc_year',
                $request->yearGroup
            )->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->english->where('set', $request->english_set)->where('nc_year', $request->yearGroup)->pluck('subject')->toArray() as $english) {
                self::addToTimetable($day->day, 'English');
            }
            foreach ($day->humanities->where(
                'set',
                $request->humanities_set
            )->pluck('subject')->toArray() as $humanity) {
                self::addToTimetable($day->day, $humanity);
            }
            foreach ($day->classics->where(
                'set',
                $request->classciv_set
            )->pluck('subject')->toArray() as $classic) {
                self::addToTimetable($day->day, $classic);
            }
            switch ($day->day) {
                case self::MONDAY:
                    if ($request->latin) {
                        self::addToTimetable($day->day, 'Latin');
                    }
                    self::addToTimetable($day->day, $request->cmfl);

                    self::addToTimetable($day->day, 'Maths');

                    break;
                case self::TUESDAY:
                    self::addToTimetable($day->day, 'Maths');
                    self::addToTimetable($day->day, $request->optionc);
                    break;
                case self::WEDNESDAY:
                    self::addToTimetable($day->day, $request->optionc);
                    self::addToTimetable($day->day, 'Reading');
                    if (Str::endsWith($request->humanities_set, ['a1', 'a2', 'a3', 'a4'])) {
                        self::addToTimetable($day->day, 'English');
                    }
                    break;
                case self::THURSDAY:
                    self::addToTimetable($day->day, $request->optiona);
                    self::addToTimetable($day->day, 'Maths');
                    self::addToTimetable($day->day, $request->optiond);
                    break;
                case self::FRIDAY:
                    self::addToTimetable($day->day, 'Reading');

                    break;
            }
        }

        return $this->timetable;
    }

    /**
     * @return array<string, array<string>>
     */
    private function year10Timetable(): array
    {
        $request = $this->request;
        foreach ($this->days as $day) {
            $this->timetable[$day->day] = [];
            foreach ($day->biology->where('set', $request->biology_set)->where(
                'nc_year',
                $request->yearGroup
            )->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->physics->where('set', $request->physics_set)->where(
                'nc_year',
                $request->yearGroup
            )->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->chemistry->where('set', $request->chemistry_set)->where(
                'nc_year',
                $request->yearGroup
            )->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }

            switch ($day->day) {
                case self::MONDAY:
                    self::addToTimetable($day->day, $request->optionb);
                    self::addToTimetable($day->day, 'English');
                    break;
                case self::TUESDAY:
                    self::addToTimetable($day->day, 'Maths');
                    self::addToTimetable($day->day, $request->optiond);
                    break;
                case self::WEDNESDAY:
                    self::addToTimetable($day->day, $request->optiona);
                    self::addToTimetable($day->day, $request->optionc);
                    break;
                case self::THURSDAY:
                    self::addToTimetable($day->day, $request->optiond);
                    self::addToTimetable($day->day, 'Maths');
                    break;
                case self::FRIDAY:
                    self::addToTimetable($day->day, $request->optionb);
                    self::addToTimetable($day->day, 'English');
                    break;
            }
        }

        return $this->timetable;
    }

    /**
     * @return array<string, array<string>>
     */
    private function year11Timetable(): array
    {
        $request = $this->request;
        foreach ($this->days as $day) {
            $this->timetable[$day->day] = [];
            foreach ($day->biology->where('set', $request->biology_set)->where(
                'nc_year',
                $request->yearGroup
            )->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->physics->where('set', $request->physics_set)->where(
                'nc_year',
                $request->yearGroup
            )->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }
            foreach ($day->chemistry->where('set', $request->chemistry_set)->where(
                'nc_year',
                $request->yearGroup
            )->pluck('subject')->toArray() as $science) {
                self::addToTimetable($day->day, $science);
            }

            switch ($day->day) {
                case self::MONDAY:
                    self::addToTimetable($day->day, 'Maths');
                    self::addToTimetable($day->day, $request->optionb);
                    self::addToTimetable($day->day, $request->cmfl);
                    self::addToTimetable($day->day, $request->optiona);
                    break;
                case self::TUESDAY:
                    self::addToTimetable($day->day, $request->optionc);
                    self::addToTimetable($day->day, $request->cmfl);
                    self::addToTimetable($day->day, $request->optiona);
                    self::addToTimetable($day->day, $request->optiond);
                    break;
                case self::WEDNESDAY:
                    self::addToTimetable($day->day, 'English');
                    self::addToTimetable($day->day, $request->optionb);
                    self::addToTimetable($day->day, $request->cmfl);
                    break;
                case self::THURSDAY:
                    self::addToTimetable($day->day, 'Maths');
                    self::addToTimetable($day->day, $request->optionc);
                    self::addToTimetable($day->day, $request->cmfl);
                    break;
                case self::FRIDAY:
                    self::addToTimetable($day->day, $request->optiond);
                    self::addToTimetable($day->day, 'English');
                    break;
            }
        }

        return $this->timetable;
    }
}
