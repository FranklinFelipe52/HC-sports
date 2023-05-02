<?php

namespace App\Http\Controllers;

use App\Helpers\GeneratePasswordHelper;
use App\Http\Requests\AdminUpdateRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreAdminRequest;
use App\Mail\ConfirmAdm;
use App\Models\Admin;
use App\Models\FederativeUnit;
use App\Models\Rule;
use App\Models\User;
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

                $administradores_aux = DB::table('admins')
            ->join('federative_units', 'federative_units.id', 'admins.federative_unit_id')
            ->join('rules', 'admins.rule_id', 'rules.id')
            ->select('admins.id', 'admins.nome_completo', 'rules.id as rule_id', 'federative_units.name as federative_unit_name', 'admins.cpf');;
              $administradores = $administradores_aux;
            if(isset($_GET["s"])){
                $administradores = $administradores_aux
                ->where('nome_completo', 'LIKE', '%'.$_GET["s"].'%')
                ->orWhere('cpf', 'LIKE', '%'.$_GET["s"].'%');
            }
           if($admin->rule->id == 1 ){
            if($admin->personification){
                $administradores = $administradores->where('federative_unit_id', $admin->personification)->where('rule_id', '<>', 1)->paginate(10);
            } else {
                $administradores =  (isset($_GET["uf"]) && ($_GET["uf"] != 0)) ? $administradores->where('federative_unit_id', '=', $_GET["uf"])->paginate(10) : $administradores->paginate(10);
            }
           } else {
            $administradores = $administradores->where('federative_unit_id', $admin->federativeUnit->id)->where('rule_id', '<>', 1)->paginate(10);
           }

            return view('Admin.administradores', [
                'administradores' => $administradores,
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);
        } catch (Exception $e){
            return back();
        }
    }

    public function single (Request $request, $id){
        try{
            $administrador = Admin::find($id);
            if(!$administrador){
                return back();
            }
            return view('Admin.administrador', [
                'administrador' => $administrador,
            ]);

        } catch (Exception $e){
            return back();
        }
    }

    public function create(Request $request){
        try{
            if(!($request->session()->get('admin')->rule->id == 1)){
                return back();
            }
            if($request->session()->get('admin')->rule->id == 1){
                $rules = Rule::where('id', '!=', 3)->get();
            } else {
                $rules = Rule::where('id', 3)->get();
            }
            return view('Admin.administradores_create', [
                'rules' => $rules,
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);
        } catch (Exception $e){
            return back();
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
            $admin->rule_id = $request->rule;
            $admin->save();
                Mail::to($request->email)->send(new ConfirmAdm($admin, $password));
                return redirect('/admin/administradores');
        } catch (Exception $e){
            return back();
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

    public function login_create(){

        try{
            return view('Admin.login');

        } catch (Exception $e){
            return back();
        }
    }

    public function logout(Request $request){
        if($request->session()->has('admin')){
            $request->session()->forget('admin');
        }

        return redirect('/admin/login');
    }

    public function profile (Request $request){
        try{
            return view('Admin.profile', [
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);

        } catch (Exception $e){
            return back();
        }
    }
    public function create_update (Request $request){
        try{
            return view('Admin.admin_edit');

        } catch (Exception $e){
            return back();
        }
    }
    public function update (AdminUpdateRequest $request){
        try{
            $admin = Admin::find($request->session()->get('admin')->id);
            if(!$admin){
                error_log($admin);
                return back();
            }
            $admin->nome_completo = $request->nome;
            $admin->cpf = $request->cpf;
            $admin->email = $request->email;
            $admin->save();
            $request->session()->put('admin', $admin);
            return redirect('/admin/profile');
        } catch (Exception $e){
            return back();
        }
    }
    public function admin_create (Request $request, $id){
        try{
            $admin = Admin::find($id);
            if(!$admin){
                return back();
            }
            return view('Admin.admin_edit', [
                'admin' => $admin
            ]);

        } catch (Exception $e){
            return back();
        }
    }
    public function admin_update (AdminUpdateRequest $request, $id){
        try{
            $admin = Admin::find($id);
            if(!$admin){
                return back();
            }
            $admin->nome_completo = $request->nome;
            $admin->cpf = $request->cpf;
            $admin->email = $request->email;
            $admin->save();
            $request->session()->put('admin', $admin);
            return redirect("/admin/administradores/$id");
        } catch (Exception $e){
            return back();
        }
    }
    public function password_reset_post (Request $request){
        try{
            if($request->new_password != $request->confirm_password){
                return back()->with('erro', 'Reinsira a sua senha corretamente.');
            }

            $admin = Admin::find($request->session()->get('admin')->id);
            if(Hash::check($request->password, $admin->password)){
                $admin->password = Hash::make($request->new_password);
                $admin->save();
                $request->session()->put('admin', $admin);
                return redirect('/admin/profile');

            }
            return back()->with('erro', 'Senha atual invalida.');
        } catch (Exception $e){
            return back();
        }
    }

    public function password_reset_get (Request $request){
        try{
            return view('Admin.admin_reset_password');

        } catch (Exception $e){
            return back();
        }
    }
}
