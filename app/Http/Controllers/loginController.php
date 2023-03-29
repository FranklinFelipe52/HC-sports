<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class loginController extends Controller
{
    public function create(Request $request){
        try{
            return view('Auth/login');
        } catch (Exception $e){
            return $e;
        }
        
    }

    public function store(LoginRequest $request){
        $user = User::find(1)->where('email', $request->email)->first();

        if(!$user){
            return back()->with('erro', 'E-mail ou senha inválida');
        }

        if($user->password === $request->password){
            $request->session()->put('user', $user);

            return redirect('/my-registrations');
        } else {
            return back()->with('erro', 'E-mail ou senha inválida');
        }
    }

    public function logout(Request $request){
        if($request->session()->has('user')){
            $request->session()->forget('user');
        }

        return redirect()->route('GetLogin');
    }
}
