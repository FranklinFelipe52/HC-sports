<?php

namespace App\Http\Controllers;

use App\Mail\PrfPasswordForgot;
use App\Models\PrfUser;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PrfForgotPasswordController extends Controller
{
    public function create(){
        return view('PRF.Auth.forgot_password');
    }

    public function store(Request $request){
        $request->validate([
            'email' => ['required', 'email']
        ]);
        $user = PrfUser::where('email', $request->email)->first();
        $payload = [
            'exp' => time() + (60*60*24),
            'email'=>$request->email
        ];
        $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
        $host = request()->getSchemeAndHttpHost();
        $link = "{$host}/PRF/password_reset/{$jwt}";
        
        if($user){
            Mail::to($request->email)->send(new PrfPasswordForgot($link));
            return redirect('/forgot_password_send');
        } 
        return redirect('/login')->with('erro', 'O E-mail informado não foi encontrado no nosso sistema');
    }
}
