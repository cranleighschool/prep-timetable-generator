<?php

namespace App\Http\Requests;

use App\Models\School;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use spkm\isams\Controllers\PupilTimetableController;

class PupilRequest extends FormRequest
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
        try {
            $pupil = School::getPupil($this->get('username'));
        } catch (\TypeError $exception) {
            throw ValidationException::withMessages(['username' => 'Could not find a pupil with that username!']);
        }
        $this->merge(['pupil' => $pupil]);

        $timetable = new PupilTimetableController(School::find(1));
        $sets = collect($timetable->show($pupil->schoolId)[ 'sets' ])->pluck('code', 'subjectId')->unique();
        $this->merge(['sets' => $sets]);
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
