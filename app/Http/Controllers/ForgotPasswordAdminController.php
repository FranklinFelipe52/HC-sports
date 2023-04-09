<?php

namespace App\Http\Controllers;

use App\Mail\PasswordForgot;
use App\Models\Admin;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordAdminController extends Controller
{
    public function create(){
        return view('Auth/forgot_password');
    }

    public function store(Request $request){
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $Admin = Admin::where('email', $request->email)->first();
        $payload = [
            'exp' => time() + (60*60*24),
            'email'=>$request->email
        ];
        $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
        $host = request()->getSchemeAndHttpHost();
        $link = "{$host}/admin/password_reset/{$jwt}";
        
        if($Admin){
            Mail::to($request->email)->send(new PasswordForgot($link));
            return redirect('/admin/forgot_password_send');
        } 
        return redirect('/admin/login')->with('erro', 'O E-mail informado não foi encontrado no nosso sistema');
    }
}
