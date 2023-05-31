<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function create(Request $request){
        try{
            return view('User/login');
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }

    }

    public function store(LoginRequest $request){
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return back()->with('erro', 'E-mail ou senha inválida');
        }
        if($user->registered == false){
            return back()->with('erro', 'Seu cadastro está incompleto, verifique o seu E-mail com o link para cadastro');
        }

        if(Hash::check($request->password, $user->password)){
            $request->session()->put('user', $user);

            return redirect('/dashboard');
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
