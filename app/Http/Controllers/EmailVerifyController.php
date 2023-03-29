<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class EmailVerifyController extends Controller
{
    public function EmailVerify($token)
    {
        try {
            $decoded = JWT::decode($token, new Key(env('JWT_KEY'), 'HS256'));
            $user = User::find(1)->where('email', $decoded->email)->first();
            if ($user) {
                return redirect()->route('GetLogin');
            } else {

                $user_new = User::create([
                    'nome_completo' => $decoded->nome,
                    'data_nasc' => $decoded->data_nascimento,
                    'cpf' => $decoded->cpf,
                    'is_pcd' => $decoded->is_pcd == null ? '0' : '1',
                    'n_oab' => $decoded->n_oab,
                    'sexo' => $decoded->sexo,
                    'email' => $decoded->email,
                    'password' => $decoded->password,
                ]);

                $addres = new Address;
                $addres->cidade = $decoded->city;
                $addres->federative_unit_id = $decoded->federative_unit;
                $addres->user_id = $user_new->id;
                $addres->save();
            }
            return redirect()->route('GetLogin')->with('verifyMessage', "E-mail confirmado, agora pode acessar o sistema");
        } catch (Exception $e) {
            return redirect()->route('GetLogin')->with('verifyMessage', "Link de confirmação inválido");
        }
    }
}
