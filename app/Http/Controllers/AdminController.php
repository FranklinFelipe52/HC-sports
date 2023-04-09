<?php

namespace App\Http\Controllers;

use App\Helpers\GeneratePasswordHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Mail\ConfirmAdm;
use App\Models\Admin;
use App\Models\FederativeUnit;
use App\Models\Rule;
use Exception;
use Illuminate\Console\View\Components\Confirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function show(Request $request){
        try{
            $admin = $request->session()->get('admin');

                $uf = isset($_GET["uf"]) ? $_GET["uf"] : '';
                error_log($uf);

                
            
                $administradores_aux = DB::table('admins')
            ->join('federative_units', 'federative_units.id', 'admins.federative_unit_id')
            ->select('admins.id', 'admins.nome_completo', 'federative_units.name as federative_unit_name', 'admins.cpf');;
              $administradores = $administradores_aux;
            if(isset($_GET["s"])){
                $administradores = $administradores_aux
                ->where('nome_completo', 'LIKE', '%'.$_GET["s"].'%')
                ->orWhere('cpf', 'LIKE', '%'.$_GET["s"].'%');
            }
           if($admin->rule->id == 1 ){

            $administradores = isset($_GET["uf"]) ? $administradores->where('federative_unit_id', '=', $_GET["uf"])->paginate(10) : $administradores->paginate(10);
            
           } else {
            $administradores = $administradores->where('federative_unit_id', $admin->federativeUnit->id)->paginate(10);
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
            if(!($request->session()->get('admin')->rule->id == 1)){
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
            $password = GeneratePasswordHelper::generatePassword();
            $federative_unit = $request->session()->get('admin')->rule->id == 1 ?  $request->uf : $request->session()->get('admin')->federativeUnit->id;
            $admin = new Admin;
            $admin->nome_completo = $request->nome;
            $admin->cpf = preg_replace( '/[^0-9]/is', '', $request->cpf);
            $admin->email = $request->email;
            $admin->password = Hash::make($password);
            $admin->federative_unit_id = $federative_unit;
            $admin->rule_id = 2;
            $admin->save();   
                Mail::to($request->email)->send(new ConfirmAdm($admin, $password));
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

        return redirect('/admin/login');
    }
}
