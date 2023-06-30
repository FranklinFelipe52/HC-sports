<?php

namespace App\Http\Requests;

use App\Rules\CpfValidate;
use App\Rules\PrfCpfUserExist;
use App\Rules\PrfEmailUserExist;
use Illuminate\Foundation\Http\FormRequest;

class PrfStoreRegistrationRequest extends FormRequest
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
            'email' => ['required', 'email', new PrfEmailUserExist],
            'cpf' => ['required', new CpfValidate, new PrfCpfUserExist],
            'data_nasc' => 'date'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'Digite um E-mail válido',
            'cpf.required' => 'CPF é obrigatório',
            'data_nasc.date' => 'Data invalida',
        ];
    }
}
