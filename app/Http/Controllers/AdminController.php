<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Models\Admin;
use App\Models\FederativeUnit;
use App\Models\Rule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function show(Request $request){
        try{
            $admin = $request->session()->get('admin');

                $uf = isset($_GET["uf"]) ? $_GET["uf"] : '';
                error_log($uf);
           if($admin->rule->id == 1 ){

            $administradores = isset($_GET["uf"]) ? Admin::where('federative_unit_id', '=', $_GET["uf"])->get() : Admin::all();
            
           } else {
            $administradores = Admin::where('federative_unit_id', $admin->federativeUnit->id)->get();
           }
            return view('Admin.administradores', [
                'administradores' => $administradores,
                'federative_units' => FederativeUnit::all()
            ]);
        } catch (Exception $e){
            return $e;
        }
    }

    public function create(Request $request){
        try{
            if($request->session()->get('admin')->rule->id == 3){
                return back();
            }
            $rules = Rule::where('id', '>', 1)->get();
            return view('Admin.administradores_create', [
                'rules' => $rules,
                'federative_units' => FederativeUnit::all()
            ]);
        } catch (Exception $e){
            return $e;
        }
    }

    public function store(StoreAdminRequest $request){
        try{
            
            $federative_unit = $request->session()->get('admin')->rule->id == 1 ?  $request->uf : $request->session()->get('admin')->federativeUnit->id;
                Admin::create([
                    'nome_completo' => $request->nome,
                    'cpf' => preg_replace( '/[^0-9]/is', '', $request->cpf) ,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'federative_unit_id' => $federative_unit,
                    'rule_id' => 2
                ]);
                return redirect('/admin/administradores');
        } catch (Exception $e){
            return $e;
        }
    }
    public function login(LoginRequest $request){
        $admin = Admin::where('email', $request->email)->first();

        if(!$admin){
            return back()->with('erro', 'E-mail ou senha inválida');
        }

        if(Hash::check($request->password, $admin->password)){
            $request->session()->put('admin', $admin);
            return redirect('/admin/dashboard');
        } else {
            return back()->with('erro', 'E-mail ou senha inválida');
        }
    }

    public function logout(Request $request){
        if($request->session()->has('admin')){
            $request->session()->forget('admin');
        }

        return redirect()->route('GetLoginAdmin');
    }
}
