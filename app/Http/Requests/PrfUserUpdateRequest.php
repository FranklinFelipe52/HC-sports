<?php

namespace App\Http\Requests;

use App\Rules\CpfValidate;
use App\Rules\PrfCpfUserExist;
use App\Rules\PrfEmailUserExist;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;


class PrfUserUpdateRequest extends FormRequest
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
            'cpf' => ['required', new CpfValidate],
        ];
    }

    public function messages()
    {
        return [
            'cpf.required' => 'CPF é obrigatório',
        ];
    }
}
