<?php

namespace App\Http\Requests;

use App\Logic\PrepSets;
use Illuminate\Foundation\Http\FormRequest;

class SetupRequest extends FormRequest
{
    use PrepSets;

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
        $this->setPupil($this->get('username'));
        $sets = $this->getPupilAndSets();
        $this->merge(['sets' => $sets]);
        $sets = self::getSets($this->get('sets'));
        $this->merge([
            'sets' => $sets,
            'yearGroup' => (int) $this->pupil->yearGroup,
        ]);
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
            'yearGroup' => [
                function ($attribute, $value, $fail) {
                    if ($value > 11) {
                        $fail('This is only for Lower School Pupils. You selected a year '.$value.' student!');
                    }
                },
            ],
        ];
    }
}
