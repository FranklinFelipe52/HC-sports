<?php

namespace App\Rules;

use App\Models\Admin;
use Illuminate\Contracts\Validation\Rule;

class CpfAdminExist implements Rule
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
        if(Admin::where('cpf', $cpf)->first()){
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
        return 'Esse CPF já está cadastrado em um administrador';
    }
}
