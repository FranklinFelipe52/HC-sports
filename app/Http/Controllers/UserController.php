<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegistrationRequest;
use App\Models\ActionsAdmin;
use App\Models\Admin;
use App\Models\FederativeUnit;
use App\Models\User;
use Exception;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Return_;
use PHPUnit\Framework\Constraint\Count;

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
                    $atletas = $atletas->where('federative_unit_id', '=', $admin->personification)->get();
                } else {
                    $atletas = (isset($_GET["uf"]) && ($_GET["uf"] != 0))  ? $atletas->where('federative_unit_id', '=', $_GET["uf"])->get() : $atletas->get();
                }

            } else {
                $atletas = $atletas->where('federative_unit_id', '=', $admin->federativeUnit->id)->get();
            }
            return view('Admin.atletas', [
                'atletas' => $atletas,
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
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
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function profile (Request $request){
        try{
            return view('User.atleta');

        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function create (Request $request){
        try{
            return view('User.atleta_edit');

        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
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
            session()->flash('success', 'Dados atualizados com sucesso!');
            return redirect('/profile');
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
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
                'atleta' => $user,
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get()
            ]);

        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function admin_user_update (StoreRegistrationRequest $request, $id){
        try{
            $admin = $request->session()->get('admin');
            $user = User::find($id);
            if (!$admin) {
                return back();
            }
            if (!$user) {
                return back();
            }
            if(!( preg_replace( '/[^0-9]/is', '', $user->cpf) == preg_replace( '/[^0-9]/is', '', $request->cpf))){

                if(Count(User::where('cpf', preg_replace( '/[^0-9]/is', '', $request->cpf))->get()) > 0){
                    session()->flash('edit_error', 'Esse CPF já está em uso.');
                    return back()->with('edit_error', 'Esse CPF já está em uso.');
                }
            }
            if(!($user->email == $request->email)){
                if(Count(User::where('email', $request->email)->get()) > 0){
                    Log::alert(User::where('email', $request->email)->get());
                    session()->flash('edit_error', 'Esse E-mail já está em uso.');
                    return back()->with('edit_error', 'Esse E-mail já está em uso.');
                }
            }
            if(strlen($request->phone_number) < 13 ){
                session()->flash('edit_error', 'Número inválido, digite novamente');
                    return back()->with('edit_error', 'Número inválido, digite novamente.');
            }


            $user->nome_completo = $request->nome;
            $user->cpf = preg_replace( '/[^0-9]/is', '', $request->cpf);
            $user->email = $request->email;
            $user->sexo = $request->sexo;
            $user->data_nasc = $request->date_nasc;
            $user->address->federative_unit_id = $request->uf;
            $user->phone_number = $request->phone_number;
            $user->address->cidade = $request->city;
            $user->is_pcd = $request->pcd == null ? false : true;
            $user->address->save();
            $user->save();
            $action_admin = new ActionsAdmin;
            $action_admin->type_actions_admin_id = 3;
            $action_admin->admin_id = $admin->id;
            $action_admin->description = "Edição de dados do atleta ".$user->nome_completo." de CPF ".$user->cpf;
            $action_admin->save();
            session()->flash('edit_success', 'Dados atualizados com sucesso!');
            return redirect("/admin/users/$id");
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
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
                session()->flash('success', 'Senha atualizada com sucesso!');
                return redirect('/profile');

            }
            return back()->with('erro', 'Senha atual invalida.');
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function password_reset_get (Request $request){
        try{
            return view('User.atleta_reset_password');

        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function admin_password_update_post (Request $request, $id){
        try{
            if($request->new_password != $request->confirm_password){
                return back()->with('erro', 'Reinsira a sua senha corretamente.');
            }
            $user = User::find($id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            session()->flash('success', 'Senha atualizada com sucesso!');
            return redirect("/admin/users/$id");
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function admin_password_update_get (Request $request, $id){
        try{

            return view('Admin.atleta_reset_password');

        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
