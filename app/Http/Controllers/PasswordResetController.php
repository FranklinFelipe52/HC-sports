<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function create($token){
        try{

            return view('Auth/password_reset', [
                'token_email' => $token
            ]);
        } catch(Exception $e){
            return redirect()->route('GetLogin');
        }
    }

    public function store( Request $request){
        try{
            $decoded = JWT::decode($request->token_email, new Key(env('JWT_KEY'), 'HS256'));
            if($request->password == $request->confirm_password){
               $user = User::find(1)->where('email', $decoded->email)->first();
               $user->password = $request->password;
               $user->save();
               return redirect()->route('GetLogin');
            } else {
                return back();
            }
        } catch(Exception $e) {
            return back();
        }
    }
}
