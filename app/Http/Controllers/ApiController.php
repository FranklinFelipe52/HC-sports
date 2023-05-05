<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getUserByCPF($cpf)
    {
        try {
            $user = User::where('cpf', $cpf)
                ->select()
                ->join('addresses', 'addresses.user_id', 'users.id')
                ->join('federative_units', 'federative_units.id', 'addresses.federative_unit_id')->get();
            error_log(Count($user));
            if (Count($user) == 0) {
                return response('', 404);
            }
            return $user;
        } catch (Exception $e) {
            return response('', 500);
        }
    }
}
