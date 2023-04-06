<?php

namespace App\Http\Requests;

use App\Rules\CpfValidate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'cpf' => ['required', new CpfValidate],
            'date_nasc' => 'required|date'
        ];
    }
    public function messages()
    {
        return [
            'date_nasc.required' => 'Data de nascimento é obrigatório',
            'date_nasc.date' => 'Data de nascimento invalida',
            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'Digite um E-mail válido',
            'cpf.required' => 'CPF é obrigatório',
        ];
    }
}
