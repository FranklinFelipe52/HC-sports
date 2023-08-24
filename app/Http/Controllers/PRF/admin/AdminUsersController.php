<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrfUserUpdateRequest;
use App\Models\PrfAdminLog;
use App\Models\PrfRegistration;
use App\Models\PrfUser;
use App\Models\PrfAdmin;
use App\Models\TypeActionsAdmin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $admin = $request->session()->get('admin');
            $users_query = PrfUser::orderBy('nome_completo', 'asc');

            if (isset($_GET["s"]) && $_GET["s"] !== '') {
                $searchTerm = $_GET["s"];
                $users_query->where(function ($query) use ($searchTerm) {
                    $query->where('nome_completo', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('servidor_matricula', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('cpf', preg_replace("/[^0-9]/", "", $searchTerm));

                    // dd(preg_replace("/[^0-9]/", "", $searchTerm));
                });
            }

            $users = $users_query->get();

            return view('PRF.Admin.users', [
                'admin' => $admin,
                'atletas' => $users,
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function single(Request $request, $id)
    {
        try {
            $user = PrfUser::find($id);
            if (!$user) {
                return back();
            }
            return view('PRF.Admin.user', [
                'atleta' => $user,
            ]);

        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function update_form(Request $request, $id)
    {
        try {
            $user = PrfUser::find($id);

            return view('PRF.Admin.user_update', ['atleta' => $user]);
        } catch (Exception $e) {
            return back();
        }
    }

    public function update(PrfUserUpdateRequest $request, $id)
    {
        try {
            $user = PrfUser::find($id);
            $admin = PrfUser::find($request->session()->get('admin')->id);

            $user->cpf = preg_replace( '/[^0-9]/is', '', $request->cpf);
            $user->nome_completo = $request->nome;
            $user->sexo = $request->sexo;
            $user->data_nasc = $request->data_nasc;
            // $user->prf_deficiency_id = $request->pcd === 'N' ? null : $request->pcd;
            $user->is_servidor = $request->is_servidor;
            $user->servidor_matricula = $request->servidor_matricula;
            $user->save();

            $admin_log = new PrfAdminLog;
            $admin_log->prf_admin_id = $admin->id;
            $admin_log->type_actions_admin_id = 3;
            $admin_log->description = 'Editou informações do usuário de cpf ' . $user->cpf . ', e id #' . $user->id;
            $admin_log->save();

            return back();

        } catch (Exception $e) {
            dd($e);
            return back();
        }
    }

}
