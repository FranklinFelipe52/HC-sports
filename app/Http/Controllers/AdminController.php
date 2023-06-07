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

    public function show(Request $request)
    {
        try {
            $admin = $request->session()->get('admin');

            $administradores_aux = DB::table('admins')
                ->join('federative_units', 'federative_units.id', 'admins.federative_unit_id')
                ->join('rules', 'admins.rule_id', 'rules.id')
                ->select('admins.id', 'admins.nome_completo', 'rules.id as rule_id', 'federative_units.name as federative_unit_name', 'admins.cpf')
                ->orderBy('admins.created_at', 'desc');;
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
            if (!$administrador) {
                return back();
            }
            return view('Admin.administrador', [
                'administrador' => $administrador,
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

    public function admin_logs(Request $request, $id)
    {
        try {

            // placeholder dos logs
            $logs = array(
                array(
                    'id' => 1,
                    'dataHora' => '2023-06-07 10:00:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 1',
                    'descricao' => 'Descrição 1'
                ),
                array(
                    'id' => 2,
                    'dataHora' => '2023-06-07 11:30:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 2',
                    'descricao' => 'Descrição 2'
                ),
                array(
                    'id' => 3,
                    'dataHora' => '2023-06-07 14:45:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 3',
                    'descricao' => 'Descrição 3'
                ),
                // Adicionar mais 17 objetos
                array(
                    'id' => 4,
                    'dataHora' => '2023-06-07 15:30:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 4',
                    'descricao' => 'Descrição 4'
                ),
                array(
                    'id' => 5,
                    'dataHora' => '2023-06-07 16:15:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 5',
                    'descricao' => 'Descrição 5'
                ),
                array(
                    'id' => 6,
                    'dataHora' => '2023-06-07 17:00:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 6',
                    'descricao' => 'Descrição 6'
                ),
                array(
                    'id' => 7,
                    'dataHora' => '2023-06-07 17:45:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 7',
                    'descricao' => 'Descrição 7'
                ),
                array(
                    'id' => 8,
                    'dataHora' => '2023-06-07 18:30:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 8',
                    'descricao' => 'Descrição 8'
                ),
                array(
                    'id' => 9,
                    'dataHora' => '2023-06-07 19:15:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 9',
                    'descricao' => 'Descrição 9'
                ),
                array(
                    'id' => 10,
                    'dataHora' => '2023-06-07 20:00:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 10',
                    'descricao' => 'Descrição 10'
                ),
                array(
                    'id' => 11,
                    'dataHora' => '2023-06-07 20:45:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 11',
                    'descricao' => 'Descrição 11'
                ),
                array(
                    'id' => 12,
                    'dataHora' => '2023-06-07 21:30:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 12',
                    'descricao' => 'Descrição 12'
                ),
                array(
                    'id' => 13,
                    'dataHora' => '2023-06-07 22:15:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 13',
                    'descricao' => 'Descrição 13'
                ),
                array(
                    'id' => 14,
                    'dataHora' => '2023-06-07 23:00:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 14',
                    'descricao' => 'Descrição 14'
                ),
                array(
                    'id' => 15,
                    'dataHora' => '2023-06-07 23:45:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 15',
                    'descricao' => 'Descrição 15'
                ),
                array(
                    'id' => 16,
                    'dataHora' => '2023-06-08 00:30:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 16',
                    'descricao' => 'Descrição 16'
                ),
                array(
                    'id' => 17,
                    'dataHora' => '2023-06-08 01:15:00',
                    'tipo' => 'Lorem ipsum',
                    'autor' => 'Autor 17',
                    'descricao' => 'Descrição 17'
                ),
                // Adicione mais objetos conforme necessário
            );

            $log_types = [
                [
                    "id" => 1,
                    "name" => 'Confirmação de pagamento',
                ],
                [
                    "id" => 2,
                    "name" => 'Exclusão de inscrição',
                ],
                [
                    "id" => 3,
                    "name" => 'Edição de usuário',
                ],
            ];

            $administrador = Admin::find($id);

            if (!$administrador) {
                session()->flash('erro', 'O administrador buscado não existe');
                return back();
            }

            return view('Admin.logs', [
                'logs' => $logs,
                'administrador' => $administrador,
                'log_types' => $log_types,
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function admin_reports(Request $request)
    {
        try {
            return view('Admin.reports');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
