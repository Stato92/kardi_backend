<?php

namespace App\Http\Requests;

use App\Rules\Pesel;
use Illuminate\Foundation\Http\FormRequest;

class StorePatient extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'alpha|required|min:2|max:255',
            'surname' => 'alpha|required|min:2|max:255',
            'email' => 'nullable|email',
            'pesel' => ['nullable', new Pesel],
            'diagnosis' => 'nullable|string|max:65535',
            'doctor' => 'required|exists:users,id'
        ];
    }

    public function messages()
    {
        return [
            'alpha' => 'To pole powinno zawierać same litery',
            'required' => 'To pole jest wymagane',
            'min' => 'To pole powinno zawierać co najmniej :min znaki',
            'max' => 'To pole  powinno zawierać maksymalnie :max znaków',
            'email' => 'Nieprawidłowy adres email',
            'exists' => 'Wybrany :attribute nie istnieje',
            'string' => 'To pole powinno zawierać ciąg znaków',
            'unique' => 'Pole zawiera zduplikowaną wartość'
        ];
    }
}
