<?php

namespace App\Http\Controllers;

use App\Mail\CaernValidAssociadoMailble;
use App\Models\PrfRegistration;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PrfAssociadosController extends Controller
{
    public function index(Request $request)
    {
        try {
            $admin = $request->session()->get('admin');
            $users_query = PrfUser::where('is_servidor', true)->orderBy('created_at', 'desc')->orderByRaw("FIELD(liberado_CAERN, 0, 1) ASC");

            if (isset($_GET["s"]) && $_GET["s"] !== '') {
                $searchTerm = $_GET["s"];
                $users_query->where(function ($query) use ($searchTerm) {
                    $query->where('nome_completo', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('cpf', preg_replace("/[^0-9]/", "", $searchTerm));

                });
            }

            $users = $users_query->get();

            return view('PRF.Admin.associados', [
                'admin' => $admin,
                'atletas' => $users,
            ]);
        } catch (Exception $e) {
            dd($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
    public function valid(Request $request, $id)
    {
        try {
            $user = PrfUser::find($id);
            if(!$user){
                return back();
            }
            DB::beginTransaction();
            $user->liberado_CAERN = true;
            $user->desconto_CAERN = true;
            $user->save();
            
            foreach ($user->registrations as $registration) {
                if($registration->status_regitration_id != PrfRegistration::STATUS_CONFIRMADO){
                    $registration->status_regitration_id = PrfRegistration::STATUS_AGUARDANDO_PAGAMENTO;
                    $registration->save();
                }  
            }
            
            session()->flash('success', 'Servidor validado com sucesso!.');
            DB::commit();
            Mail::to($user->email)->send(new CaernValidAssociadoMailble($user, true));
            return back();

            
        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function invalid(Request $request, $id)
    {
        try {
            $user = PrfUser::find($id);
            if(!$user){
                return back();
            }
            DB::beginTransaction();
            $user->liberado_CAERN = true;
            $user->motivo_CAERN = $request->motivo_caern ?? null;
            $user->save();
           
                foreach ($user->registrations as $registration) {
                    if($registration->status_regitration_id != PrfRegistration::STATUS_CONFIRMADO){
                    $registration->status_regitration_id = PrfRegistration::STATUS_AGUARDANDO_PAGAMENTO;
                    $registration->save();
                    }
                }
            session()->flash('success', 'Servidor invalidado com sucesso!.');
            DB::commit();
            Mail::to($user->email)->send(new CaernValidAssociadoMailble($user, false));
            return back();

        } catch (Exception $e) {
            DB::rollBack();
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
