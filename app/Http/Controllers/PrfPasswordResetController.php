<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrfPasswordResetRequest;
use App\Models\PrfUser;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PrfPasswordResetController extends Controller
{
    public function create($token){
        try{

            return view('PRF.Auth.password_reset', [
                'token_email' => $token
            ]);
        } catch(Exception $e){
            return redirect('/login');
        }
    }

    public function store( PrfPasswordResetRequest $request){
        try{
            $decoded = JWT::decode($request->token_email, new Key(env('JWT_KEY'), 'HS256'));
            if($request->password == $request->confirm_password){
                error_log($decoded->email);
               $user = PrfUser::where('email', $decoded->email)->first();
               error_log($user);
               $user->password = Hash::make($request->password);
               $user->save();
               session()->flash('success', 'Senha redefinida com sucesso.');
               return redirect('/login');
            } else {
                session()->flash('erro', 'Reinsira a senha corretamente.');
                return back();
            }
        } catch(Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
