<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function show(Request $request){
        try{
            $modalidades = Modalities::all();
            $admin = $request->session()->get('admin');
            $atualizacoes_aux = DB::table('users')
            ->join('addresses', 'addresses.user_id', 'users.id')
            ->join('federative_units', 'federative_units.id', 'addresses.federative_unit_id')
            ->orderBy('updated_at', 'desc')
            ->where('registered', true);
            if($admin->rule->id == 1){
                $atualizacoes = $atualizacoes_aux
                ->select('users.id', 'users.nome_completo', 'users.email', 'users.registered', 'users.updated_at')->get();

                error_log($atualizacoes);
            } else {
                $atualizacoes = $atualizacoes_aux
                ->where('federative_unit_id', $admin->federativeUnit->id)
                ->select('users.id', 'users.nome_completo', 'users.email', 'users.registered', 'users.updated_at')->get();
            }

            return view('Admin.dashboard', [
               'modalidades'  => $modalidades,
               'atualizacoes' => $atualizacoes
            ]);

        } catch (Exception $e){
            return $e;
        }
    }
}
