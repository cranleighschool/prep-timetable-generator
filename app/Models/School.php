<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use spkm\isams\Contracts\Institution;
use spkm\isams\Controllers\CurrentPupilController;
use spkm\isams\Wrappers\Pupil;

class School extends Model implements Institution
{
    use HasFactory;

    public static function getPupil(string $username): Pupil
    {
        $isams = new CurrentPupilController(new self());
        return $isams->index()->whereIn('schoolEmailAddress', [strtoupper($username)."@cranleigh.org",strtolower($username)."@cranleigh.org"])->first();
    }

    public function getConfigName(): string
    {
        return 'cranleighSchool';
    }
}
