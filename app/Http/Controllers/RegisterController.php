<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerify;
use App\Models\FederativeUnit;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function create()
    {
        try{
            $federative_units = FederativeUnit::all();
            return view('Auth/register', [
                'federative_units' => $federative_units
            ]);
        } catch(Exception $e){
            return back();
        }
        
    }

    public function store(RegisterRequest $request)
    {

        $payload = [
                "nome" => $request->nome,
                "data_nascimento" => $request->data_nascimento,
                "email" => $request->email,
                "cpf" => $request->cpf,
                "n_oab" => $request->n_oab,
                "is_pcd" => $request->is_pcd,
                "sexo" => $request->sexo,
                "password" => $request->password,
                "federative_unit" => $request->federative_unit,
                "city" => $request->city
        ];

        $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
        $host = request()->getSchemeAndHttpHost();


        $link = "{$host}/email_verify/{$jwt}";

        Mail::to($request->email)->send(new EmailVerify($link));
        return redirect()->route('GetLogin')->with('EmailVerify', 'Mandamos um link de confirmação para seu E-mail. Confirme o E-mail para ter acesso ao sistema');
    }
}
