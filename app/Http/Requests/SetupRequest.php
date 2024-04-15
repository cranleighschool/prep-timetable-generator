<?php

namespace App\Http\Requests;

use App\Exceptions\PupilNotFound;
use App\Logic\PrepSets;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SetupRequest extends FormRequest
{
    use PrepSets;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @throws ValidationException
     */
    public function prepareForValidation(): void
    {
        try {
            $username = $this->get('username');
            $this->setPupil($username);
            $sets = $this->getPupilAndSets();
            $this->merge(['sets' => $sets]);
            $sets = self::getSets($this->get('sets'));
            $this->merge([
                'sets' => $sets,
                'yearGroup' => (int) $this->pupil->yearGroup,
                'pupil' => $this->pupil->toArray(),
            ]);
        } catch (PupilNotFound $exception) {
            throw ValidationException::withMessages([
                'pupil' => 'Pupil not found: '.strtoupper($this->get('username')).'. Please double check the username, and ensure that they are in the Lower School (Year 9, 10 or 11).']);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
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
