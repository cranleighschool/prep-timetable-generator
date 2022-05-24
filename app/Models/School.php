<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use spkm\isams\Contracts\Institution;
use spkm\isams\Controllers\CurrentPupilController;
use spkm\isams\Wrappers\Pupil;

class School extends Model implements Institution
{
    use HasFactory;

    public static function allPupils() {
        return Cache::rememberForever("allPupils", function () {
            $isams = new CurrentPupilController(new self());
            return $isams->index()->whereIn('yearGroup', [9,10,11]);
        });
    }

    public static function getPupil(string $username): Pupil
    {
        $allPupils = self::allPupils();
        return Cache::rememberForever("pupil_".$username, function () use ($allPupils, $username) {
            return $allPupils->whereIn('schoolEmailAddress',
                [strtoupper($username)."@cranleigh.org", strtolower($username)."@cranleigh.org"])->first();
        });
    }

    public function getConfigName(): string
    {
        return 'cranleighSchool';
    }
}
