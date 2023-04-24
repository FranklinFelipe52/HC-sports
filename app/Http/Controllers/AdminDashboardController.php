<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminDashboardController extends Controller
{
    public function show(Request $request){
        try{
            
            $modalidades = Modalities::orderBy('nome', 'asc')->get();
            $admin = $request->session()->get('admin');
            $atualizacoes_aux = DB::table('actions_notificatios')
            ->join('users', 'actions_notificatios.user_id', 'users.id')
            ->join('addresses', 'addresses.user_id', 'users.id')
            ->join('status_notificatios', 'status_notificatios.id', 'actions_notificatios.status_notificatios_id')
            ->select('users.nome_completo', 'users.id', 'status_notificatios.status', 'addresses.federative_unit_id', 'actions_notificatios.created_at')
            ->orderBy('created_at', 'desc');
            if($admin->rule->id == 1){
                if($admin->personification){
                    $atualizacoes = $atualizacoes_aux
                ->where('federative_unit_id', $admin->personification)
                ->get();
                } else {
                    $atualizacoes = $atualizacoes_aux->get();
                }
            } else {
                $atualizacoes = $atualizacoes_aux
                ->where('federative_unit_id', $admin->federativeUnit->id)
                ->get();
            }

            return view('Admin.dashboard', [
               'modalidades'  => $modalidades,
               'atualizacoes' => $atualizacoes
            ]);

        } catch (Exception $e){
            $request->session()->forget('admin');
            return redirect('/admin/login');
        }
    }
}
