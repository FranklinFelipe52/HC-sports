<?php

namespace App\Http\Controllers;

use App\Models\ActionsAdmin;
use App\Models\FederativeUnit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;

class UserController extends Controller

{
    public function show(Request $request){
        try{
            $admin = $request->session()->get('admin');

                $atletas_aux = DB::table('users')
            ->join('addresses', 'addresses.user_id', 'users.id')
            ->join('federative_units', 'federative_units.id', 'addresses.federative_unit_id')
            ->select('users.id', 'users.nome_completo', 'federative_units.name as federative_unit_name', 'users.cpf')
            ->orderBy('users.created_at', 'desc');
            $atletas = $atletas_aux;
            if(isset($_GET["s"])){
                $atletas = $atletas_aux
                ->where('nome_completo', 'LIKE', '%'.$_GET["s"].'%')
                ->orWhere('cpf', 'LIKE', '%'.$_GET["s"].'%');
            }

            if($admin->rule->id == 1){
                if($admin->personification){
                    $atletas = $atletas->where('federative_unit_id', '=', $admin->personification)->paginate(8);
                } else {
                    $atletas = (isset($_GET["uf"]) && ($_GET["uf"] != 0))  ? $atletas->where('federative_unit_id', '=', $_GET["uf"])->paginate(8) : $atletas->paginate(8);
                }

            } else {
                $atletas = $atletas->where('federative_unit_id', '=', $admin->federativeUnit->id)->paginate(8);
            }
            return view('Admin.atletas', [
                'atletas' => $atletas,
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);
        } catch (Exception $e){
            return back();
        }
    }

    public function single (Request $request, $id){
        try{
            $user = User::find($id);
            if(!$user){
                return back();
            }
            return view('Admin.atleta', [
                'atleta' => $user,
            ]);

        } catch (Exception $e){
            return back();
        }
    }

    public function profile (Request $request){
        try{
            return view('User.atleta');

        } catch (Exception $e){
            return back();
        }
    }

    public function create (Request $request){
        try{
            return view('User.atleta_edit');

        } catch (Exception $e){
            return back();
        }
    }
    public function update (Request $request){
        try{
            $user = User::find($request->session()->get('user')->id);
            $user->nome_completo = $request->nome;
            $user->address->cidade = $request->city;
            $user->address->save();
            $user->save();
            $request->session()->put('user', $user);
            return redirect('/profile');
        } catch (Exception $e){
            return back();
        }
    }
    public function admin_user_create (Request $request, $id){
        try{
            $user = User::find($id);
            if(!$user){
                return back();
            }
            return view('Admin.atleta_edit', [
                'atleta' => $user
            ]);

        } catch (Exception $e){
            return back();
        }
    }
    public function admin_user_update (Request $request, $id){
        try{
            $admin = $request->session()->get('admin');
            $user = User::find($id);
            if (!$admin) {
                return back();
            }
            if (!$user) {
                return back();
            }

            $user->nome_completo = $request->nome;
            $user->address->cidade = $request->city;
            $user->address->save();
            $user->save();
            $request->session()->put('user', $user);
            $action_admin = new ActionsAdmin;
            $action_admin->type_actions_admin_id = 3;
            $action_admin->admin_id = $admin->id;
            $action_admin->description = "Edição de dados do atleta ".$user->nome_completo;
            $action_admin->save();
            session()->flash('success', true);
            return redirect("/admin/users/$id");
        } catch (Exception $e){
            return back();
        }
    }
    public function password_reset_post (Request $request){
        try{
            if($request->new_password != $request->confirm_password){
                return back()->with('erro', 'Reinsira a sua senha corretamente.');
            }

            $user = User::find($request->session()->get('user')->id);
            if(Hash::check($request->password, $user->password)){
                $user->password = Hash::make($request->new_password);
                $user->save();
                $request->session()->put('user', $user);
                return redirect('/profile');

            }
            return back()->with('erro', 'Senha atual invalida.');
        } catch (Exception $e){
            return back();
        }
    }

    public function password_reset_get (Request $request){
        try{
            return view('User.atleta_reset_password');

        } catch (Exception $e){
            return back();
        }
    }
}
