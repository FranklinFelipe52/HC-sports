<?php

namespace App\Http\Controllers;

use App\Models\log_payment;
use App\Models\Payment;
use App\Models\registration;
use App\Models\status_payment;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function show(Request $request)
    {
        try {


            if (!($request->session()->get('admin')->rule->id == 1)) {
                return back();
            }
            $payment_aux = DB::table('payments')
                ->join('registrations', 'payments.registration_id', 'registrations.id')
                ->join('users', 'registrations.user_id', 'users.id')
                ->join('modalities', 'registrations.modalities_id', 'modalities.id')
                ->join('status_payments', 'payments.status_payment_id', 'status_payments.id')
                ->select('users.nome_completo', 'modalities.nome as modalidade_nome', 'payments.mount', 'status_payments.status', 'payments.id_payment', 'payments.id');
            if (isset($_GET["s"])) {
                $payment_aux = $payment_aux
                    ->where('nome_completo', 'LIKE', '%' . $_GET["s"] . '%');
            }
            $payments = isset($_GET['status']) ? $payment_aux->where('status_payment_id', $request->status)->paginate(8) : $payment_aux->paginate(8) ;
            

            return view('Admin.payments', [
                'payments' => $payments,
                'status_payments' => status_payment::all()
            ]);
        } catch (Exception $e) {
            return back();
        }
    }

    public function store(Request $request, $id)
    {
        try {
            $payment = Payment::find($id);
            if (!$payment) {
                return back();
            }
            $registration = registration::find($payment->registration->id);
            if (!$registration) {
                return back();
            }
            $log = new log_payment;
            $log->status = 'paid';
            $log->registration_id = $registration->id;
            $log->save();
            $registration->status_regitration_id = 1;
            $registration->payment->status_payment_id = 1;
            $registration->payment->save();
            $registration->save();

            return back()->with('success', 'Pagamento confirmado com sucesso');
        } catch (Exception $e) {
            return back()->with('erro', 'Ocorreu um erro na confirmação do pagamento');
        }
    }
}
