<?php

namespace App\Http\Requests;

use App\Http\Controllers\Isams\SubjectsController;
use App\Models\School;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use spkm\isams\Controllers\PupilTimetableController;

class SetupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->getPupilAndSets();
        $sets = $this->getSets($this->get('sets'));
        $this->merge([
            'sets' => $sets,
            'yearGroup' => (int) $this->get('pupil')->yearGroup,
        ]);
    }

    private function getPupilAndSets()
    {
        //dd($this->get('username'));
        try {
            $pupil = School::getPupil($this->get('username'));
        } catch (\TypeError $exception) {
            throw ValidationException::withMessages(['username' => 'Could not find a pupil with that username!']);
        }
        $this->merge(['pupil' => $pupil]);

        $sets = Cache::remember("sets_".$pupil->schoolId, now()->addHours(2), function () use ($pupil) {
            $timetable = new PupilTimetableController(School::find(1));
            return collect($timetable->show($pupil->schoolId)[ 'sets' ])->pluck('code',
                'subjectId')->unique()->toArray();
        });
        $this->merge(['sets' => $sets]);
    }

    private function getSets(array $sets): Collection
    {
        return Cache::rememberForever("sets".serialize($sets), function () use ($sets) {
            $subjectController = new SubjectsController(new School());
            $sets = collect($sets)->map(function ($item, $key) use ($subjectController) {
                $subject = $subjectController->show($key);
                $subject[ 'set' ] = $item;
                return $subject;
            })->pluck("name", "set");
            return $sets;
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string',
            'pupil' => [
                function ($attribute, $value, $fail) {
                    if ($value->yearGroup > 11) {
                        $fail('This is only for Lower School Pupils. You selected a year '.$value->yearGroup.' student!');
                    }
                },
            ],
        ];
    }
}
