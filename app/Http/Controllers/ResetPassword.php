<?php

namespace App\Http\Controllers;

use App\Helpers\GeneratePasswordHelper;
use App\Mail\PasswordResetConfirm;
use App\Models\ActionsAdmin;
use App\Models\Admin;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPassword extends Controller
{
    public function adm(Request $request, $id){
        try{
            $admin = Admin::find($id);
            if(!$admin){
                return back();
            }
            $password = GeneratePasswordHelper::generatePassword();
            $admin->password = Hash::make($password);
            $admin->save();
            $user = $admin;
            $type = 1;
            $action_admin = new ActionsAdmin;
            $action_admin->type_actions_admin_id = 4;
            $action_admin->admin_id = $admin->id;
            $action_admin->description = "Resetou a senha do administrador ".$admin->nome_completo;
            $action_admin->save();
            Mail::to( $admin->email)->send(new PasswordResetConfirm($user, $type , $password));
            return back();
        } catch (Exception $e){
            return back();
        }
    }
    public function atleta(Request $request, $id){
        try{
            $admin = $request->session()->get('admin');
            $user = User::find($id);
            if (!$admin) {
                return back();
            }
            if(!$user){
                return back();
            }
            $password = GeneratePasswordHelper::generatePassword();
            $user->password = Hash::make($password);
            $user->save();
            $type = 0;
            $action_admin = new ActionsAdmin;
            $action_admin->type_actions_admin_id = 4;
            $action_admin->admin_id = $admin->id;
            $action_admin->description = "Resetou a senha do atleta ".$user->nome_completo;
            $action_admin->save();
            Mail::to($user->email)->send(new PasswordResetConfirm($user, $type , $password));
            return back();
        } catch (Exception $e){
            return $e;
        }
    }
}
