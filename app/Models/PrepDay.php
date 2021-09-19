<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PrepDay extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'day',
    ];

    public static function getTimetable(int $yearGroup, Request $request): array
    {
        $timetable = [];

        if ($yearGroup == 9) {
            $timetable = self::year9Timetable($timetable, $request);
        }
        if ($yearGroup == 10) {
            $timetable = self::year10Timetable($timetable, $request);
        }
        if ($yearGroup == 11) {
            $timetable = self::year11Timetable($timetable, $request);
        }

        return collect($timetable)->map(function ($day) {
            return collect($day)->reject(function ($subject) {
                return is_null(($subject));
            })->toArray();
        })->toArray();
    }

    public static function year9Timetable(array $timetable, Request $request): array
    {
        foreach (self::all() as $day) {
            $timetable[ $day->day ] = [];
            foreach ($day->sciences->where("set", $request->science_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                array_push($timetable[ $day->day ], $science);
            }
            foreach ($day->humanities->where("set",
                $request->humanities_set)->pluck('subject')->toArray() as $humanity) {
                array_push($timetable[ $day->day ], $humanity);
            }
            foreach ($day->classics->where("set",
                $request->classciv_set)->pluck('subject')->toArray() as $classic) {
                array_push($timetable[ $day->day ], $classic);
            }
            switch ($day->day) {
                case "Monday":
                    array_push($timetable[ $day->day ], $request->optiona);
                    array_push($timetable[ $day->day ], $request->cmfl);
                    break;
                case "Tuesday":
                    array_push($timetable[ $day->day ], "English");
                    break;
                case "Wednesday":
                    array_push($timetable[ $day->day ], $request->optionb);
                    if (\Illuminate\Support\Str::contains($request->maths_set, "X")) {
                        array_push($timetable[ $day->day ], "Maths");
                    }
                    break;
                case "Thursday":
                    array_push($timetable[ $day->day ], "Maths");
                    if ($request->latin === true) {
                        array_push($timetable[ $day->day ], "Latin");
                    }
                    break;
                case "Friday":
                    array_push($timetable[ $day->day ], $request->optionc);
                    if (\Illuminate\Support\Str::contains($request->maths_set, "Y")) {
                        array_push($timetable[ $day->day ], "Maths");
                    }
                    break;
            }
        }
        return $timetable;
    }

    public static function year10Timetable(array $timetable, Request $request): array
    {
        foreach (self::all() as $day) {
            $timetable[ $day->day ] = [];
            foreach ($day->biology->where('set', $request->biology_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                array_push($timetable[ $day->day ], $science);
            }
            foreach ($day->physics->where('set', $request->physics_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                array_push($timetable[ $day->day ], $science);
            }
            foreach ($day->chemistry->where('set', $request->chemistry_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                array_push($timetable[ $day->day ], $science);
            }

            switch ($day->day) {
                case "Monday":
                    array_push($timetable[ $day->day ], $request->optionb);
                    array_push($timetable[ $day->day ], 'Maths');
                    array_push($timetable[ $day->day ], "English");
                    break;
                case "Tuesday":
                    array_push($timetable[ $day->day ], $request->optiona);
                    array_push($timetable[ $day->day ], $request->optionc);
                    break;
                case "Wednesday":
                    array_push($timetable[ $day->day ], $request->optionb);
                    array_push($timetable[ $day->day ], 'Maths');
                    break;
                case "Thursday":
                    array_push($timetable[ $day->day ], "English");
                    array_push($timetable[ $day->day ], $request->optiond);
                    break;
                case "Friday":
                    array_push($timetable[ $day->day ], $request->optiona);
                    array_push($timetable[ $day->day ], $request->optiond);
                    array_push($timetable[ $day->day ], $request->cmfl);
                    break;
            }
        }

        return $timetable;
    }

    public static function year11Timetable(array $timetable, Request $request): array
    {
        foreach (self::all() as $day) {
            $timetable[ $day->day ] = [];
            foreach ($day->biology->where('set', $request->biology_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                array_push($timetable[ $day->day ], $science);
            }
            foreach ($day->physics->where('set', $request->physics_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                array_push($timetable[ $day->day ], $science);
            }
            foreach ($day->chemistry->where('set', $request->chemistry_set)->where('nc_year',
                $request->yearGroup)->pluck('subject')->toArray() as $science) {
                array_push($timetable[ $day->day ], $science);
            }

            switch ($day->day) {
                case "Monday":
                    array_push($timetable[ $day->day ], $request->cmfl);
                    array_push($timetable[ $day->day ], 'Maths');
                    break;
                case "Tuesday":
                    array_push($timetable[$day->day], 'English');
                    array_push($timetable[ $day->day ], $request->optiona);
                    array_push($timetable[ $day->day ], $request->optionc);
                    break;
                case "Wednesday":
                    array_push($timetable[ $day->day ], $request->optionb);
                    array_push($timetable[ $day->day ], $request->cmfl);
                    array_push($timetable[ $day->day ], $request->optiond);
                    break;
                case "Thursday":
                    array_push($timetable[ $day->day ], "English");
                    array_push($timetable[ $day->day ], $request->optiond);
                    break;
                case "Friday":
                    array_push($timetable[ $day->day ], $request->optiona);
                    array_push($timetable[ $day->day ], $request->optiond);
                    array_push($timetable[ $day->day ], 'Maths');
                    break;
            }
        }

        return $timetable;
    }

    public function biology()
    {
        return $this->hasMany(ScienceSet::class, 'day_id')->whereIn('subject', ['Biology']);
    }

    public function chemistry()
    {
        return $this->hasMany(ScienceSet::class, 'day_id')->whereIn('subject', ['Chemistry']);
    }

    public function physics()
    {
        return $this->hasMany(ScienceSet::class, 'day_id')->whereIn('subject', ['Physics']);
    }

    public function sciences()
    {
        return $this->hasMany(ScienceSet::class, "day_id")->whereIn('subject', ['Biology', 'Chemistry', 'Physics']);
    }

    public function humanities()
    {
        return $this->hasMany(ScienceSet::class, 'day_id')->whereIn('subject', ['Geography', 'RS', 'History']);
    }

    public function classics()
    {
        return $this->hasMany(ScienceSet::class, 'day_id')->whereIn('subject', ['Class Civ']);
    }


}
