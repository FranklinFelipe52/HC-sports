<?php

namespace App\Http\Requests;

use App\Rules\CpfAdminExist;
use App\Rules\CpfValidate;
use App\Rules\EmailAdminExist;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
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
            'email' => ['required', 'email', new EmailAdminExist],
            'cpf' => ['required', new CpfValidate, new CpfAdminExist],
            'uf' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'Digite um E-mail válido',
            'cpf.required' => 'CPF é obrigatório',
            'uf.required' => 'Selecione uma unidade federal'
        ];
    }
}
