<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PrfLoginController extends Controller
{
    public function create(Request $request){
        try{
            return view('PRF.User.login');
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }

    }

    public function store(LoginRequest $request){
        $user = PrfUser::where('email', $request->email)->first();

        if(!$user){
            return back()->with('erro', 'E-mail ou senha inválida');
        }

        if(Hash::check($request->password, $user->password)){
            $request->session()->put('prf_user', $user);
            return redirect('/PRF/dashboard');
        } else {
            return back()->with('erro', 'E-mail ou senha inválida');
        }
    }

    public function logout(Request $request){
        if($request->session()->has('prf_user')){
            $request->session()->forget('prf_user');
        }

        return redirect('/PRF/login');
    }
}
