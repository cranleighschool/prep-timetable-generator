<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimetableRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'maths_set' => strtoupper($this->get('maths_set')),
        ]);
        if ($this->get('latin') === 'YES') {
            $this->merge(['latin' => true]);
        } else {
            $this->merge(['latin' => false]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'string|required',
            'science_set' => 'min:1|max:8|integer',
            'humanities_set' => 'min:1|max:8|integer',
            'biology_set' => 'min:1|max:8|integer',
            'chemistry_set' => 'min:1|max:8|integer',
            'physics_set' => 'min:1|max:8|integer',
            'classciv_set' => 'min:1|max:6|integer',

            'maths_set' => 'regex:/^[a-zA-Z]{1}[0-9]{1}$/',
        ];
    }

    public function messages()
    {
        return [
            'classciv_set.min' => 'That looks like an incorrect Classics Set.',
            'classciv_set.max' => 'That looks like an incorrect Classics Set.',
            '*.min' => 'That looks like an incorrect '.ucwords(':attribute').' number.',
            '*.max' => 'That looks like an incorrect '.ucwords(':attribute').' number.',
            'maths_set' => 'Looks like an invalid Maths Set.',
        ];
    }
}
