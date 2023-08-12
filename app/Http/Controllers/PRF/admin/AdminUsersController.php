<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Models\PrfAdminLog;
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
            $users_query = DB::table('prf_users')
                ->select('prf_users.id', 'prf_users.nome_completo', 'prf_users.cpf', 'prf_users.servidor_matricula', 'prf_users.is_servidor', 'prf_users.is_servidor_validated')
                ->orderBy('prf_users.created_at', 'desc');
            ;

            if (isset($_GET["s"])) {
                $users_query = $users_query
                    ->where('nome_completo', 'LIKE', '%' . $_GET["s"] . '%')
                    ->orWhere('cpf', 'LIKE', '%' . preg_replace("/[^0-9]/", "", $_GET["s"]) . '%')
                    ->orWhere('servidor_matricula', 'LIKE', '%' . $_GET["s"] . '%')
                    ->orWhere('email', 'LIKE', '%' . $_GET["s"] . '%');
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

    public function single (Request $request, $id){
        try{
            $user = PrfUser::find($id);
            if(!$user){
                return back();
            }
            return view('PRF.Admin.user', [
                'atleta' => $user,
            ]);

        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function validar_servidor (Request $request, $id) {
        try{
            $user = PrfUser::find($id);
            $admin = PrfAdmin::find(Session('admin')->id);
            $action = TypeActionsAdmin::find(7);

            if(!$user){
                session()->flash('erro', 'Usuário não encontrado.');
                return back();
            }

            if (!$user->is_servidor) {
                session()->flash('erro', 'O usuário informou ser da PRF, portanto não precisa de validação.');
                return back();
            }

            $user->is_servidor_validated = 1;
            $user->save();

            $admin_log = new  PrfAdminLog;
            $admin_log->prf_admin_id = $admin->id;
            $admin_log->type_actions_admin_id = $action->id;
            $admin_log->description = 'confirmou que o usuário de cpf ' . $user->cpf . 'e ID ' . $user->id . ' é um servidor da PRF';

            $admin_log->save();

            session()->flash('success', 'O usuário foi confirmado como servidor da PRF.');
            return back();

        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

}
