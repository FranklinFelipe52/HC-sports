<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetAdminController extends Controller
{
    public function create($token){
        try{
            return view('Auth/password_reset_admin', [
                'token_email' => $token
            ]);
        } catch(Exception $e){
            return redirect('/admin/login');
        }
    }

    public function store( Request $request){
        try{
            $decoded = JWT::decode($request->token_email, new Key(env('JWT_KEY'), 'HS256'));
            error_log($decoded->email);
               $admin = Admin::where('email', $decoded->email)->first();
               $admin->password = Hash::make($request->password);
               $admin->save();
               return redirect('/admin/login');
            
        } catch(Exception $e) {
            return redirect('/admin/login')->with('erro', 'Esse link de redefinição está invalido.');
        }
    }
}
