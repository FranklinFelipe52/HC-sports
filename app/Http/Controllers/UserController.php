<?php

namespace App\Http\Controllers;

use App\Models\FederativeUnit;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller

{
    public function show(Request $request){
        try{
            $admin = $request->session()->get('admin');

            $s = isset($_GET["s"]) ? $_GET["s"] : '';
            
                $atletas_aux = DB::table('users')
            ->join('addresses', 'addresses.user_id', 'users.id')
            ->join('federative_units', 'federative_units.id', 'addresses.federative_unit_id')
            ->select('users.id', 'users.nome_completo', 'federative_units.name as federative_unit_name', 'users.cpf');
            $atletas = $atletas_aux;
            if(isset($_GET["s"])){
                $atletas = $atletas_aux
                ->where('nome_completo', 'LIKE', '%'.$s.'%')
                ->orWhere('cpf', 'LIKE', '%'.$s.'%');
            }
            $atletas = $admin->rule->id == 1 ? (isset($_GET["uf"]) ?   $atletas->where('federative_unit_id', '=', $_GET["uf"])->paginate(8) : $atletas->paginate(8)) : $atletas->where('federative_unit_id', '=', $admin->federativeUnit->id)->paginate(8);
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
}
