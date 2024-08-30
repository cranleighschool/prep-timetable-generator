<?php

namespace App\Http\Resources;

use App\Logic\GenerateTimetable;
use App\Models\PrepDay;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use spkm\isams\Exceptions\ValidationException;

class PupilTimetableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     *
     * @throws ValidationException
     */
    public function toArray(Request $request): array
    {
        return [
            /** @var array<string,array<string>> $timetable */
            'username' => $this['username'],
            /** @var int $yearGroup the Year Group (National Curriculum) for the pupil */
            'yearGroup' => $this['yearGroup'],
            /** @var array<string,string> $subjects */
            'subjects' => $this['subjects'],
            /** @var array<string,string> $results */
            'results' => $this['results'],
            'timetable' => (new GenerateTimetable($this['yearGroup'], $this['fields'], PrepDay::all()))->getTimetable(),
        ];
    }
}
