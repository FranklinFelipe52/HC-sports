<?php

namespace App\Http\Controllers;

use App\Models\FederativeUnit;
use App\Models\Modalities;
use App\Models\registration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationsAdminController extends Controller
{
    public function show()
    {
        try {
            $modalidades = Modalities::all();


            return view('Admin.registrations', [
                'modalidades'  => $modalidades,
            ]);
        } catch (Exception $e) {
            return back();
        }
    }

    public function registration(Request $request, $id)
    {
        try {
            $modalidade = Modalities::find($id);
            $admin = $request->session()->get('admin');


            if ($modalidade) {
                $s = isset($_GET["s"]) ? $_GET["s"] : '';
                $uf = isset($_GET["uf"]) ? $_GET["uf"] : '';
                error_log($s);
                error_log($uf);

                if ($admin->rule->id == 1) {
                    $registrations = DB::table('registrations')
                        ->join('status_regitrations', 'registrations.status_regitration_id', '=', 'status_regitrations.id')
                        ->join('modalities', 'registrations.modalities_id', '=', 'modalities.id')
                        ->where('modalities_id', $modalidade->id)
                        ->join('users', 'registrations.user_id', '=', 'users.id')
                        ->join('addresses', 'addresses.user_id', '=', 'users.id')
                        ->join('federative_units', 'addresses.federative_unit_id', '=', 'federative_units.id')
                        ->join('payments', 'payments.id', '=', 'registrations.payment_id')
                        ->join('status_payments', 'status_payments.id', '=', 'payments.status_payment_id')
                        ->select('registrations.id', 'users.nome_completo', 'users.cpf', 'modalities.nome', 'addresses.federative_unit_id', 'status_regitrations.status as status_registration', 'modalities.modalities_type_id' , 'federative_units.initials', 'status_payments.status')
                        ->where('nome_completo', 'LIKE', '%'.$s.'%');
                        $registrations = isset($_GET["uf"]) ? $registrations->where('federative_unit_id', '=', $_GET["uf"])->get() : $registrations->get();
                        error_log($registrations);
                } else {
                    $registrations = DB::table('registrations')
                            ->join('status_regitrations', 'registrations.status_regitration_id', '=', 'status_regitrations.id')
                            ->join('modalities', 'registrations.modalities_id', '=', 'modalities.id')
                            ->where('modalities_id', $modalidade->id)
                            ->join('users', 'registrations.user_id', '=', 'users.id')
                            ->join('addresses', 'addresses.user_id', '=', 'users.id')
                            ->join('federative_units', 'addresses.federative_unit_id', '=', 'federative_units.id')
                            ->join('payments', 'payments.id', '=', 'registrations.payment_id')
                            ->join('status_payments', 'status_payments.id', '=', 'payments.status_payment_id')
                            ->where('federative_unit_id', $admin->federative_unit_id)
                            ->select('registrations.id', 'users.nome_completo', 'users.cpf', 'modalities.nome', 'addresses.federative_unit_id', 'federative_units.initials', 'status_regitrations.status as status_registration', 'status_payments.status')
                            ->where('nome_completo', 'LIKE', '%' .$s. '%')
                            ->get();
                }
            }


            return view('Admin.single_registration', [
                'registrations'  => $registrations,
                'modalidade' => $modalidade,
                'federative_units' => FederativeUnit::all()
            ]);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function valid_registration(Request $request){
        try{
            if(!$request->checkbox || Count($request->checkbox) == 0){
                return back()->with('erro', "Nenhuma inscrição foi selecionada");
            }

            foreach ($request->checkbox as $value) {
                $registration = registration::find($value);
                if($registration && $registration->status_regitration->id == 1){
                    $registration->status_regitration_id = 2;
                    $registration->save();
                }
                
            }

            return redirect()->back();
        } catch(Exception $e){
            return back();
        }
    }
}
