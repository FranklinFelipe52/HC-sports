<?php

namespace App\Http\Requests;

use App\Rules\EmailVerify;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'nome' => 'required|string',
            'data_nascimento' => 'required|string',
            'email' => ['required', 'email', new EmailVerify()],
            'cpf' => 'required|string',
            'n_oab' => 'required|string',
            'password' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'Nome completo é obrigatório',
            'data_nascimento.required' => 'Ano de nascimento é obrigatório',
            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'Digite um E-mail válido',
            'cpf.required' => 'CPF é obrigatório',
            'n_oab.required' => 'Número da OAB é obrigatório',
            'password.required' => 'Senha é obrigatória',
        ];
    }
}
