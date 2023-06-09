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
use App\Models\TypeActionsAdmin;
use App\Models\User;
use App\Models\ActionsAdmin;
use Exception;
use Illuminate\Console\View\Components\Confirm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    public function show(Request $request)
    {
        try {
            $admin = $request->session()->get('admin');

            $administradores_aux = DB::table('admins')
                ->join('federative_units', 'federative_units.id', 'admins.federative_unit_id')
                ->join('rules', 'admins.rule_id', 'rules.id')
                ->select('admins.id', 'admins.nome_completo', 'rules.id as rule_id', 'federative_units.name as federative_unit_name', 'admins.cpf')
                ->orderBy('admins.created_at', 'desc');
            $administradores = $administradores_aux;
            if (isset($_GET["s"])) {
                $administradores = $administradores_aux
                    ->where('nome_completo', 'LIKE', '%' . $_GET["s"] . '%')
                    ->orWhere('cpf', 'LIKE', '%' . $_GET["s"] . '%');
            }
            if ($admin->rule->id == 1) {
                if ($admin->personification) {
                    $administradores = $administradores->where('federative_unit_id', $admin->personification)->where('rule_id', '<>', 1)->get();
                } else {
                    $administradores =  (isset($_GET["uf"]) && ($_GET["uf"] != 0)) ? $administradores->where('federative_unit_id', '=', $_GET["uf"])->get() : $administradores->get();
                }
            } else {
                $administradores = $administradores->where('federative_unit_id', $admin->federativeUnit->id)->where('rule_id', '<>', 1)->get();
            }

            return view('Admin.administradores', [
                'administradores' => $administradores,
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function single(Request $request, $id)
    {
        try {
            $administrador = Admin::find($id);
            $admin_logs = ActionsAdmin::where('admin_id', $id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            if (!$administrador) {
                return back();
            }
            return view('Admin.administrador', [
                'administrador' => $administrador,
                'admin_logs' => $admin_logs,
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function create(Request $request)
    {
        try {
            if (!($request->session()->get('admin')->rule->id == 1)) {
                return back();
            }
            if ($request->session()->get('admin')->rule->id == 1) {
                $rules = Rule::where('id', '!=', 3)->get();
            } else {
                $rules = Rule::where('id', 3)->get();
            }
            return view('Admin.administradores_create', [
                'rules' => $rules,
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function store(StoreAdminRequest $request)
    {
        try {
            $password = GeneratePasswordHelper::generatePassword();
            $federative_unit = $request->session()->get('admin')->rule->id == 1 ?  $request->uf : $request->session()->get('admin')->federativeUnit->id;
            $admin = new Admin;
            $admin->nome_completo = $request->nome;
            $admin->cpf = preg_replace('/[^0-9]/is', '', $request->cpf);
            $admin->email = $request->email;
            $admin->password = Hash::make($password);
            $admin->federative_unit_id = $federative_unit;
            $admin->rule_id = $request->rule;
            $admin->save();
            Mail::to($request->email)->send(new ConfirmAdm($admin, $password));
            session()->flash('success', 'Admin criado com sucesso!');
            return redirect('/admin/administradores');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function login(LoginRequest $request)
    {

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            session()->flash('erro', 'E-mail ou senha inválida');
            return back();
        }

        if (Hash::check($request->password, $admin->password)) {
            $request->session()->put('admin', $admin);
            return redirect('/admin/dashboard');
        } else {
            session()->flash('erro', 'E-mail ou senha inválida');
            return back();
        }
    }

    public function login_create()
    {

        try {
            return view('Admin.login');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('admin')) {
            $request->session()->forget('admin');
        }

        return redirect('/admin/login');
    }

    public function profile(Request $request)
    {
        try {
            return view('Admin.profile', [
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function create_update(Request $request)
    {
        try {
            $admin = Admin::find($request->session()->get('admin')->id);
            if (!$admin) {
                return back();
            }
            return view('Admin.admin_edit', [
                'admin' => $admin
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function update(Request $request)
    {
        try {
            $admin = Admin::find($request->session()->get('admin')->id);
            if (!$admin) {
                return back();
            }
            if (!($admin->cpf == $request->cpf)) {
                if (Admin::where('cpf', $request->cpf)->get()) {
                    session()->flash('erro', 'Esse CPF já está em uso');
                    return back();
                }
            }

            if (!($admin->email == $request->email)) {
                if (Admin::where('email', $request->email)->get()) {
                    session()->flash('erro', 'Esse E-mail já está em uso');
                    return back();
                }
            }
            $admin->nome_completo = $request->nome;
            $admin->cpf = $request->cpf;
            $admin->email = $request->email;
            $admin->save();
            $request->session()->put('admin', $admin);
            session()->flash('edit_success', 'Dados atualizados com sucesso!');
            return redirect('/admin/profile');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function admin_create(Request $request, $id)
    {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                return back();
            }
            return view('Admin.admin_edit', [
                'admin' => $admin
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function admin_update(Request $request, $id)
    {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                return back();
            }
            if (!($admin->cpf == $request->cpf)) {
                if (Admin::where('cpf', $request->cpf)->get()) {
                    return back()->with('erro', 'Esse CPF já está em uso');
                }
            }

            if (!($admin->email == $request->email)) {
                if (Admin::where('email', $request->email)->get()) {
                    return back()->with('erro', 'Esse E-mail já está em uso');
                }
            }

            $admin->nome_completo = $request->nome;
            $admin->cpf = $request->cpf;
            $admin->email = $request->email;
            $admin->save();

            session()->flash('edit_success', 'Dados atualizados com sucesso!');
            return redirect("/admin/administradores/$id");
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function password_reset_post(Request $request)
    {
        try {
            if ($request->new_password != $request->confirm_password) {
                session()->flash('erro', 'Reinsira a sua senha corretamente.');
                return back();
            }

            $admin = Admin::find($request->session()->get('admin')->id);
            if (Hash::check($request->password, $admin->password)) {
                $admin->password = Hash::make($request->new_password);
                $admin->save();
                $request->session()->put('admin', $admin);
                session()->flash('success', 'Senha atualizada com sucesso!');
                return redirect('/admin/profile');
            }
            session()->flash('erro', 'Senha atual invalida.');
            return back();
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function password_reset_get(Request $request)
    {
        try {
            return view('Admin.admin_reset_password');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function admin_password_update_get(Request $request)
    {
        try {
            return view('Admin.admin_update_password');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function admin_password_update_post(Request $request, $id)
    {
        try {
            $admin = Admin::find($id);
            if (!$admin) {
                return back();
            }
            if ($request->new_password != $request->confirm_password) {
                return back()->with('erro', 'Reinsira a sua senha corretamente.');
            }

            $admin->password = Hash::make($request->new_password);
            $admin->save();
            session()->flash('success', 'Senha atualizada com sucesso!');
            return redirect("/admin/administradores/$id");


            return back()->with('erro', 'Senha atual invalida.');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function admin_logs_single(Request $request, $id)
    {
        try {
            if (!($request->session()->get('admin')->rule->id == 1)) {
                return back();
            }

            $administrador = Admin::find($id);
            $log_types = TypeActionsAdmin::get();
            $admin_logs_aux = ActionsAdmin::where('admin_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            if (!$administrador) {
                session()->flash('erro', 'O administrador buscado não existe');
                return back();
            }

            $admin_logs = $admin_logs_aux;
            if (isset($_GET["s"]) && !(isset($_GET["type"]) && ($_GET["type"] != 0))) {
                $admin_logs = ActionsAdmin::where('admin_id', $id)
                    ->where('description', 'LIKE', '%' . $_GET["s"] . '%')
                    ->get();
            } else if (isset($_GET["s"]) && isset($_GET["type"]) && $_GET["s"] != 0) {
                if (isset($_GET["type"]) && ($_GET["type"] != 0)) {
                    $admin_logs = ActionsAdmin::where('admin_id', $id)
                        ->where('description', 'LIKE', '%' . $_GET["s"] . '%')
                        ->where('type_actions_admin_id', $_GET["type"])
                        ->get();
                }
            } else if (!isset($_GET["s"]) && (isset($_GET["type"]) && ($_GET["type"] != 0))) {
                if (isset($_GET["type"]) && ($_GET["type"] != 0)) {
                    $admin_logs = ActionsAdmin::where('admin_id', $id)
                        ->where('type_actions_admin_id', $_GET["type"])
                        ->get();
                }
            }

            return view('Admin.logs', [
                'logs' => $admin_logs,
                'administrador' => $administrador,
                'log_types' => $log_types,
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function admin_logs(Request $request)
    {
        try {
            
            if (!($request->session()->get('admin')->rule->id == 1)) {
                session()->flash('erro', 'Adm não é geral.');
                return back();
            }

            $log_types = TypeActionsAdmin::get();
            $admin_logs_aux = ActionsAdmin::orderBy('created_at', 'desc')
                ->get();

            $admin_logs = $admin_logs_aux;
            if (isset($_GET["s"]) && !(isset($_GET["type"]) && ($_GET["type"] != 0))) {
                $admin_logs = ActionsAdmin::where('description', 'LIKE', '%' . $_GET["s"] . '%')
                    ->get();
            } else if (isset($_GET["s"]) && isset($_GET["type"]) && $_GET["s"] != 0) {
                if (isset($_GET["type"]) && ($_GET["type"] != 0)) {
                    $admin_logs = ActionsAdmin::where('description', 'LIKE', '%' . $_GET["s"] . '%')
                        ->where('type_actions_admin_id', $_GET["type"])
                        ->get();
                }
            } else if (!isset($_GET["s"]) && (isset($_GET["type"]) && ($_GET["type"] != 0))) {
                if (isset($_GET["type"]) && ($_GET["type"] != 0)) {
                    $admin_logs = ActionsAdmin::where('type_actions_admin_id', $_GET["type"])
                        ->get();
                }
            }

            return view('Admin.logs', [
                'logs' => $admin_logs,
                'log_types' => $log_types,
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    
}
