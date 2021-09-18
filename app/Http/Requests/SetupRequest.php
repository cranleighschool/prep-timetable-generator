<?php

namespace App\Http\Requests;

use App\Http\Controllers\Isams\SubjectsController;
use App\Models\School;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

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
        $sets = $this->getSets($this->get('sets'));
        $this->merge([
            'sets' => $sets,
            'yearGroup' => (int) $this->get('yearGroup')
        ]);
    }

    private function getSets(array $sets): Collection
    {
        $subjectController = new SubjectsController(new School());
        $sets = collect($sets)->map(function ($item, $key) use ($subjectController) {
            $subject = $subjectController->show($key);
            $subject[ 'set' ] = $item;
            return $subject;
        })->pluck("name", "set");
        return $sets;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sets' => [
                      'required'
            ],
            'yearGroup' => 'integer|required',
        ];
    }
}
