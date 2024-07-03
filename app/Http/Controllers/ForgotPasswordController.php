<?php

namespace App\Http\Controllers;

use App\Mail\PasswordForgot;
use App\Models\User;
use App\Rules\EmailVerify;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function create(){
        return view('Auth/forgot_password');
    }

    public function store(Request $request){
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', $request->email)->first();
        $payload = [
            'exp' => time() + (60*60*24),
            'email'=>$request->email
        ];
        $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
        $host = request()->getSchemeAndHttpHost();
        $link = "{$host}/inscricao/password_reset/{$jwt}";
        
        if($user && $user->registered){
            
            Mail::to($request->email)->send(new PasswordForgot($link));
            return redirect('/forgot_password_send');
        } 
        return redirect('/login')->with('erro', 'O E-mail informado não foi encontrado no nosso sistema');
    }
}
