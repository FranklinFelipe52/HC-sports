<?php

namespace App\Rules;

use App\Models\PrfUser;
use Illuminate\Contracts\Validation\Rule;

class PrfCpfUserExist implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cpf = preg_replace( '/[^0-9]/is', '', $value);
        if(PrfUser::where('cpf', $cpf)->first()){
            session()->flash('erro', 'Já existe um atleta com esse CPF');
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
