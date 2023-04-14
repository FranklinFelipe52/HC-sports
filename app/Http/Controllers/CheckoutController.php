<?php

namespace App\Http\Controllers;

use App\Classes\Checkout;
use App\Models\log_payment;
use App\Models\registration;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{

    public function checkout(Request $request, $id){

        try{
        
        $user = User::find($request->session()->get('user')->id);
        $registration = registration::find($id);

        if(!$registration){
            return back();
        }
        if($registration->user->id != $user->id){
            return back();
        }

        $modalidade = $registration->modalities;
        $valor = 0;
        $registrations_payment = 0;

        foreach ($user->registrations as $registration) {
            if($registration->Payment->status_payment->id == 1){
                $registrations_payment++;
            }
        }

        switch ($registrations_payment) {
            case 0:
                $valor = 200.00;
                break;
            case 1:
                $valor = 100.00;
                break;
            case 2:
                $valor = 100.00;
                break;
            case 3:
                return back();
                break;
        }
        return view('User.registration', [
            'registration' => $registration,
            'valor' => $valor
        ]);

        } catch(Exception $e){
            return back();
        }
    }

    public function notification(Request $request){
        try{
            $payment_id = $_GET["payment_id"];
            $status = $_GET["status"];
            $merchant_order_id= $_GET["merchant_order_id"];
            $external_reference = $_GET["external_reference"];

            $registration = registration::find($external_reference);
            $user = User::find($request->session()->get('user')->id);

        if(!$registration){
            return redirect('/dashboard');
        }
        if($registration->user->id != $user->id){
            return redirect('/dashboard');
        }
        $log_payment = new log_payment;
        $log_payment->status = $status;
        $log_payment->id_transaction = $merchant_order_id;
        $log_payment->id_payment =  $payment_id;
        $log_payment->registration_id = $external_reference;
        $log_payment->save();
        if($status == 'approved'){
            $registration->status_regitration_id = 1;
            $registration->payment->id_transaction = $merchant_order_id;
            $registration->payment->id_payment  = $payment_id;
            $registration->payment->status_payment_id  = 1;
            $registration->payment->save();
            $registration->save();
        }

        return redirect('/dashboard')->with('m', 'Pagamento efetuado com sucesso');
        }catch(Exception $e){
            return redirect('/dashboard')->with('m', 'Pagamento não efetuado por erro');
        }
    }

    public function notification_webhook(Request $request){
        
        $payment_id = $request['eayment_id'];
        $merchant_order_id = $request->merchant_order_id;
        $external_reference = $request->external_reference;

           $response = Http::withHeaders([
                'Authorization' => "Bearer ".env('MP_ACCESS_TOKEN')
            ])->get("https://api.mercadopago.com/v1/payments/{{$payment_id}");

            $registration = registration::find($external_reference);

            $log_payment = new log_payment;
            $log_payment->status = $response['status'];
            $log_payment->id_transaction = $merchant_order_id;
            $log_payment->id_payment =  $payment_id;
            $log_payment->registration_id = $external_reference;
            $log_payment->save();

            if($response['status'] == 'approved'){
            $registration->status_regitration_id = 1;
            $registration->payment->id_transaction = $merchant_order_id;
            $registration->payment->id_payment  = $payment_id;
            $registration->payment->status_payment_id  = 1;
            $registration->payment->save();
            $registration->save();
        }

    }




    
}
