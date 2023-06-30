<?php

namespace App\Http\Controllers;

use App\Classes\Checkout;
use App\Models\ActionsNotificatios;
use App\Models\log_payment;
use App\Models\PrfLogPayments;
use App\Models\registration;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\RedisJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{

    public function checkout(Request $request, $id){

        try{

        $user = User::find($request->session()->get('user')->id);
        $registration = registration::find($id);
        error_log($registration);

        if(!$registration){
            return back();
        }
        if($registration->user->id != $user->id){
            return back();
        }
        if($registration->status_regitration_id == 1){
            return back();
        }

        $valor = $registration->Payment->mount;

        error_log($registration);
        return view('User.registration', [
            'registration' => $registration,
            'valor' => $valor
        ]);

        } catch(Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function notification(Request $request){

        try{
            $external_reference = $_GET["external_reference"];

            $registration = registration::find($external_reference);
            $user = User::find($request->session()->get('user')->id);

        if(!$registration){
            return redirect('/dashboard');
        }
        if($registration->user->id != $user->id){
            return redirect('/dashboard');
        }

        $notifications = new ActionsNotificatios;
        $notifications->user_id = $user->id;
        $notifications->status_notificatios_id = 2;
        $notifications->save();
        return redirect('/dashboard');
        }catch(Exception $e){
            return redirect('/dashboard');
        }
    }

    public function notification_webhook(Request $request){
        try{
            
            $payment_id = $request->all()['data']['id'];
            
            $response = Http::withHeaders([
                 'Authorization' => "Bearer ".env('MP_ACCESS_TOKEN')
             ])->get("https://api.mercadopago.com/v1/payments/$payment_id");

            
            if($response->status() == 403 || $response->status() == 400 || $response->status() == 404){
                    return response('erro', $response->status());
            }
            if(explode('_', $response['external_reference'])[0] == 'PRF'){
                $registration = registration::find(explode('_', $response['external_reference'])[1]);
             $log_payment = new PrfLogPayments;


             $log_payment->status = $response['status'];
             $log_payment->id_payment = $payment_id;
             $log_payment->prf_registration_id = $response['external_reference'];
             $log_payment->amount = $response['transaction_amount'];
             $log_payment->save();
             

        if($response['status'] == 'approved'){
             $registration->status_regitration_id = 1;
             $registration->prf_payments->id_payment  =  $payment_id;
             $registration->prf_payments->status_payment_id  = 1;
             $registration->prf_payments->amount  = $response['transaction_amount'];
             $registration->prf_payments->save();
             $registration->save();
         }

         if($response['status'] == 'pending' || $response['status'] == 'rejected'){
            if($registration->status_regitration_id != 1){
                $registration->status_regitration_id = 3;
                $registration->prf_payments->id_payment  =  $payment_id;
                $registration->prf_payments->status_payment_id  = 3;
                $registration->prf_payments->save();
                $registration->save();
            }
             
         }

        if($response['status'] == 'in_process'){
            if($registration->status_regitration_id != 1){
            $registration->status_regitration_id = 2;
            $registration->prf_payments->id_payment  =  $payment_id;
            $registration->prf_payments->status_payment_id  = 3;
            $registration->prf_payments->save();
            $registration->save();
            }
        }

            } else {
            $registration = registration::find($response['external_reference']);
             $log_payment = new log_payment;


             $log_payment->status = $response['status'];
             $log_payment->id_payment =  $payment_id;
             $log_payment->registration_id = $response['external_reference'];
             $log_payment->mount = $response['transaction_amount'];
             $log_payment->save();
             

        if($response['status'] == 'approved'){
             $registration->status_regitration_id = 1;
             $registration->payment->id_payment  =  $payment_id;
             $registration->payment->status_payment_id  = 1;
             $registration->payment->mount  = $response['transaction_amount'];
             $registration->payment->save();
             $registration->save();
         }

         if($response['status'] == 'pending' || $response['status'] == 'rejected'){
            if($registration->status_regitration_id != 1){
                $registration->status_regitration_id = 3;
                $registration->payment->id_payment  =  $payment_id;
                $registration->payment->status_payment_id  = 3;
                $registration->payment->save();
                $registration->save();
            }
             
         }

        if($response['status'] == 'in_process'){
            if($registration->status_regitration_id != 1){
            $registration->status_regitration_id = 2;
            $registration->payment->id_payment  =  $payment_id;
            $registration->payment->status_payment_id  = 3;
            $registration->payment->save();
            $registration->save();
            }
        }
            }
             
         return response('ok', 200);

        } catch(Exception $e){
            Log::alert(['erro' => $e->getMessage()]);
            return response(['erro'=> $e],400);
        }

    }





}
