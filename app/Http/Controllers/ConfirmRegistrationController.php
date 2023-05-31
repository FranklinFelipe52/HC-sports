<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmRegisterAtleta;
use App\Mail\RegistrationMail;
use App\Models\ActionsNotificatios;
use App\Models\StatusNotificatios;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ConfirmRegistrationController extends Controller
{
    public function create(Request $request, $token){
        try{
            $decoded = JWT::decode($token, new Key(env('JWT_KEY'), 'HS256'));
            if(!$decoded){
                return redirect('/login');
            }
            $user = User::where('email', $decoded->email)->first();

            if($user->registered == true){
                return redirect('/login');
            }

            return view('User.register', [
                "token" => $decoded
            ]);

        }catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function store(Request $request, $token){
        try{
            $decoded = JWT::decode($token, new Key(env('JWT_KEY'), 'HS256'));
            if(!$decoded){
                return back()->with('erro', 'Link expirado');
            }
            if($request->password != $request->confirm_password){
                return back()->with('erro', 'Senhas diferentes');
            }
            $user = User::where('email', $decoded->email)->first();
            $user->nome_completo = $request->nome;
            $user->is_pcd = $request->pcd == null ? false : true;

            $user->address->cidade = $request->city;
            $user->address->save();
            $user->password = Hash::make($request->password);
            $user->registered = true;
            $user->save();
            Mail::to($user->email)->send(new ConfirmRegisterAtleta($user));
            $request->session()->put('user', $user);
            $notifications = new ActionsNotificatios;
            $notifications->user_id = $user->id;
            $notifications->status_notificatios_id = 1;
            $notifications->save();
            return redirect('/dashboard');
        } catch(Exception $e){
            return back()->with('erro', 'Cadastro não efetuado');
        }
    }
}
