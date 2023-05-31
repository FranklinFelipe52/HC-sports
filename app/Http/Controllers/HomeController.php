<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function show(Request $request){
        try{
            error_log('entrou');
            $user = User::find($request->session()->get('user')->id);
            if($user){
                error_log('entrou');
                return view('User.dashboard', [
                    'registrations' => $user->registrations,
                ]);
            }
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
