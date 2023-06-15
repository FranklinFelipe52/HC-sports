<?php

namespace App\Http\Controllers;

use App\Helpers\ColumnsCreateReports;
use App\Mail\ConfirmUser;
use App\Models\registration;
use App\Models\status_regitration;
use App\Models\User;
use DateTime;
use Exception;
use FunctionsTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{

    public function create(Request $request)
    {
        try {


            if (!($request->session()->get('admin')->rule->id == 1)) {
                session()->flash('erro', 'Adm não é geral.');
                return back();
            }

            $date_oldest_registration =  date("Y-m-d", strtotime(registration::oldest()->first()->created_at));
            return view('Admin.reports', [
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get(),
                'status' => status_regitration::all(),
                'date_start_min' =>  $date_oldest_registration,
                'date_start_max' =>  date("Y-m-d", strtotime('-1 days')),
                'date_end_min' => date_format(date_modify(new DateTime($date_oldest_registration), '+1 days'), 'Y-m-d'),
                'date_end_max' =>  date("Y-m-d")
            ]);
        } catch (Exception $e) {
            error_log($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function Store(Request $request)
    {
        try {
            if ($request->date_end && !$request->date_start) {
                error_log('erro date entry');
                session()->flash('erro', 'Para obter o intervalo, digite a data de inicio.');
                return back();
            }




            $array_registrations = [];
            $registrations = registration::where('modalities_id', '<>', 11)->join('addresses', 'addresses.user_id', 'registrations.user_id')
                ->select('registrations.id', 'registrations.user_id', 'registrations.modalities_category_id', 'registrations.modalities_id', 'registrations.range_id', 'registrations.status_regitration_id', 'registrations.type_payment_id', 'registrations.created_at', 'registrations.is_pcd', 'registrations.sub_categorys_id', 'addresses.federative_unit_id');

            if ($request->date_start) {
                if ($request->date_end) {
                    $registrations = $registrations->whereBetween('registrations.created_at', [$request->date_start, $request->date_end]);
                } else {
                    $registrations = $registrations->whereBetween('registrations.created_at', [$request->date_start, date("Y-m-d H:i:s")]);
                }
            }
            if ($request->uf) {
                $registrations = $registrations->where('federative_unit_id', $request->uf);
            }

            if ($request->status) {
                $registrations = $registrations->where('status_regitration_id', $request->status);
            }
            $registrations = $registrations->get();


            foreach ($registrations as $registration) {

                array_push($array_registrations, ColumnsCreateReports::createColumns($request->colunas, $registration));
            }
            $registrations = registration::where('modalities_id', 11)->join('natacao_categorias', 'natacao_categorias.registration_id', 'registrations.id')->join('addresses', 'addresses.user_id', 'registrations.user_id')
                ->select('registrations.id', 'registrations.user_id', 'natacao_categorias.modalities_category_id', 'registrations.modalities_id', 'registrations.range_id', 'registrations.status_regitration_id', 'registrations.type_payment_id', 'registrations.created_at', 'registrations.is_pcd', 'registrations.sub_categorys_id', 'addresses.federative_unit_id');

            if ($request->date_start) {
                if ($request->date_end) {
                    $registrations = $registrations->whereBetween('registrations.created_at', [$request->date_start, $request->date_end]);
                } else {
                    $registrations = $registrations->whereBetween('registrations.created_at', [$request->date_start, date("Y-m-d H:i:s")]);
                }
            }
            if ($request->uf) {
                $registrations = $registrations->where('federative_unit_id', $request->uf);
            }

            if ($request->status) {
                $registrations = $registrations->where('status_regitration_id', $request->status);
            }
            $registrations = $registrations->get();
            foreach ($registrations as $registration) {
                array_push($array_registrations, ColumnsCreateReports::createColumns($request->colunas, $registration));
            }

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_inscrições.csv');

            $arquivo = fopen("php://output", "w");
            $cabecalho = ColumnsCreateReports::createColumnsHeader($request->colunas);

            fputcsv($arquivo, $cabecalho, ';');
            $key_values = array_column($array_registrations, 'Nome_completo');
            array_multisort($key_values, SORT_ASC, $array_registrations);
            foreach ($array_registrations as $value) {
                fputcsv($arquivo, $value, ';');
            }
            fclose($arquivo);
            back();
        } catch (Exception $e) {
            error_log($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function scriptUsers(){
        try{
            $users = User::where('registered', 0)->get();
            foreach ($users as $user) {
                $senha = 'CAA'.$user->address->federativeUnit->initials;
                $user->nome_completo = $user->nome_completo ? $user->nome_completo : 'Nome';
                $user->password = Hash::make($senha);
                $user->registered = 1;
                $user->save();
                Mail::to($user->email)->send(new ConfirmUser($user, $senha));
            }
            return redirect('/admin/dashboard');
        } catch (Exception $e){
            dd($e);
        }
    }
    
}
