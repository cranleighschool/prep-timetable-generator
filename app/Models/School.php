<?php

namespace App\Models;

use App\Exceptions\PupilNotFound;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ItemNotFoundException;
use spkm\isams\Contracts\Institution;
use spkm\isams\Controllers\CurrentPupilController;
use spkm\isams\Controllers\HumanResourcesEmployeeController;
use spkm\isams\Wrappers\Pupil;
use TypeError;

class School extends Model implements Institution
{
    use HasFactory;

    public static function allPupils(): Collection
    {
        return Cache::remember('allPupils', config('cache.time'), function () {
            $isams = new CurrentPupilController(new self());

            return $isams->index()->whereIn('yearGroup', [9, 10, 11, 12, 13])->map(function ($pupil) {
                try {
                    $pupil->tutorUsername = self::getTutorUsername($pupil->tutorEmployeeId);
                } catch (TypeError $error) {
                    //echo $error->getMessage()." (".sprintf("%s %s %d", $pupil->fullName, $pupil->boardingHouse, $pupil->yearGroup).")";
                    $pupil->tutorUsername = 'UNKNOWN';
                } catch (ClientException $e) {
                    //echo $e->getMessage();
                    $pupil->tutorUsername = 'UNKNOWN';
                }

                return $pupil;
            });
        });
    }

    public static function getTutorUsername(int $tutorId)
    {
        $isams = new HumanResourcesEmployeeController(new self());
        $return = $isams->show($tutorId);

        return $return->schoolInitials;
    }

    public static function getPupil(string $username): Pupil
    {
        $allPupils = self::allPupils();

        return Cache::rememberForever('pupil_'.$username, function () use ($allPupils, $username) {
            try {
                $pupil = $allPupils->whereIn('schoolEmailAddress',
                    [strtoupper($username).'@cranleigh.org', strtolower($username).'@cranleigh.org'])->firstOrFail();

                return $pupil;
            } catch (ItemNotFoundException $exception) {
                throw new PupilNotFound('Pupil not found: '.$username, 404);
            }
        });
    }

    public function getConfigName(): string
    {
        return 'cranleighSchool';
    }
}
