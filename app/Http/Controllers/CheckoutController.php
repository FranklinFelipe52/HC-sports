<?php

namespace App\Http\Controllers;

use App\Classes\Checkout;
use App\Models\ActionsNotificatios;
use App\Models\log_payment;
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

        $valor = $registration->Payment->mount;

        error_log($registration);
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
            Log::alert(['request' => $request->all()]);
            $payment_id = $request->all()['data']['id'];
            Log::alert(['payment_id' => $payment_id]);
            $response = Http::withHeaders([
                 'Authorization' => "Bearer ".env('MP_ACCESS_TOKEN')
             ])->get("https://api.mercadopago.com/v1/payments/$payment_id");

             Log::alert(['response_payment' =>  $response]);
            if($response->status() == 403 || $response->status() == 400 || $response->status() == 404){
                    return response('erro', $response->status());
            }
            Log::alert(['response_status' =>  $response->status()]);
             $registration = registration::find($response['external_reference']);
             Log::alert(['registration' =>  $registration]);
             $log_payment = new log_payment;
             $log_payment->status = $response['status'];
             $log_payment->id_payment =  $payment_id;
             $log_payment->registration_id = $response['external_reference'];
             $log_payment->mount = $response['transaction_amount'];
             $log_payment->save();
             Log::alert(['log_payment' => $log_payment]);
 
        if($response['status'] == 'approved'){
             $registration->status_regitration_id = 1;
             $registration->payment->id_payment  =  $payment_id;
             $registration->payment->status_payment_id  = 1;
             $registration->payment->mount  = $response['transaction_amount'];
             $registration->payment->save();
             $registration->save();
         }
 
         if($response['status'] == 'pending' || $response['status'] == 'rejected'){
             $registration->status_regitration_id = 3;
             $registration->payment->id_payment  =  $payment_id;
             $registration->payment->status_payment_id  = 3;
             $registration->payment->save();
             $registration->save();
         }

        if($response['status'] == 'in_process'){
            $registration->status_regitration_id = 2;
            $registration->payment->id_payment  =  $payment_id;
            $registration->payment->status_payment_id  = 3;
            $registration->payment->save();
            $registration->save();
        }
        Log::alert(['registration_final' => $registration]);
         return response('ok', 200);

        } catch(Exception $e){
            Log::alert(['erro' => $e->getMessage()]);
            return response(['erro'=> $e],400);
        }
        
    }




    
}
