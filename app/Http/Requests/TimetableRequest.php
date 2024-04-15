<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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

        // 2023 GCSE years we only have one D6 set for all sciences this santizes that
        if (in_array($this->get('yearGroup'), [10, 11])) {
            $sciences = ['biology', 'chemistry', 'physics'];
            foreach ($sciences as $key => $science) {
                $field = $this->get($science.'_set');
                if (Str::startsWith($field, 'D6') && strlen($field) > 2) {
                    $this->merge([$science.'_set' => 'D6']);
                }
            }
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
            'humanities_set' => 'min:1|max:8|string',
            'biology_set' => 'min:1|max:8|string',
            'chemistry_set' => 'min:1|max:8|string',
            'physics_set' => 'min:1|max:8|string',
            'classciv_set' => 'min:1|max:6|string',

            //'maths_set' => 'regex:/^[a-zA-Z]{1}[0-9]{1}$/',
            'maths_set' => 'min:1|max:8|integer',
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
