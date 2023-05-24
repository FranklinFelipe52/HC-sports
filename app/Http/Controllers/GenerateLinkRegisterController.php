<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class GenerateLinkRegisterController extends Controller
{
    public function create(Request $request, $id){
        $user = User::find($id);
        if(!$user){
            return back();
        }

        $payload = [
            "email" => $user->email,
            "date_nasc" => $user->data_nasc,
            "phone_number" => $user->phone_number,
            "cpf" => $user->cpf,
            "sexo" => $user->sexo,
            "uf" => $user->address->federativeUnit->initials,
            "exp" => time() + (60 * 60 * 24 * 30),
        ];
        $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
        $host = request()->getSchemeAndHttpHost();
        $link = "{$host}/confirm_registration/{$jwt}";
        $user->link_register = $link;
        $user->save();

        return back();
    }
}
