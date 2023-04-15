<?php

namespace App\Http\Controllers;

use App\Models\log_payment;
use App\Models\registration;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function show(Request $request){
        try{
            if(!($request->session()->get('admin')->rule->id == 1)){
                return back();
            }
            if(isset($_GET["s"])){
                error_log('ee');
                $log = log_payment::where('status', 'pending')->where('id_payment', 'LIKE', '%'.$_GET["s"].'%')->paginate(8);
            } else {
                error_log('eee');
                $log = log_payment::where('status', 'pending')->paginate(8);
            }
            
            error_log($log);

            return view('Admin.payments_pending', [
                'logs' => $log
            ]);

        } catch(Exception $e){
            return $e;
        }
    }

    public function store(Request $request, $id){
        try 
        {
                $log = log_payment::find($id);
        if(!$log){
            return back();
        }
        $registration = registration::find($log->registration->id);
        if(!$registration){
            return back();
        }

        $log->status = "paid";
        $log->save();
        $registration->status_regitration_id = 1;
        $registration->payment->status_payment_id = 1;
        $registration->payment->id_transaction = $log->id_transaction;
        $registration->payment->id_payment = $log->id_payment;
        $registration->payment->mount = $log->mount;
        $registration->payment->save();
        $registration->save();

        return back()->with('success', 'Pagamento confirmado com sucesso');
    } catch(Exception $e){
        return back()->with('erro', 'Pagamento não confirmado, tente novamente');
    }   
    }
}
