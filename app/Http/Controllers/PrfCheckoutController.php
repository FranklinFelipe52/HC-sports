<?php

namespace App\Http\Controllers;

use App\Models\ActionsNotificatios;
use App\Models\PrfLogPayments;
use App\Models\PrfPace;
use App\Models\PrfRegistration;
use App\Models\PrfTshirt;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PrfCheckoutController extends Controller
{
    public function checkout(Request $request, $id){

        try{
        $user = PrfUser::find($request->session()->get('prf_user')->id);
        $registration = PrfRegistration::find($id);
        if(!$user){
            return back();
        }
        if(!$registration){
            return back();
        }
        if($registration->prf_user->id != $user->id){
            return back();
        }
        if($registration->status_regitration_id == 1){
            return back();
        }

        $registrationAUX = [];
            
                $priceTshirts = 0;
                foreach ( $registration->tshirts as $tshirt) {
                    $priceTshirts = $priceTshirts + $tshirt->price;
                }
                $registrationAUX = [
                    'id' => $registration->id,
                    'title' => $registration->prf_categorys->nome.' '.$registration->prf_package->nome,
                    'descricao' => $registration->prf_package->descricao,
                    'pricePackage' => $registration->prf_categorys->price + $registration->prf_package->price,
                    'priceTshirts' => $priceTshirts,
                    'status_registration' => $registration->status_regitration,
                    'user' => $registration->prf_user,
                    'category' => $registration->prf_categorys->nome
                ];
            

        return view('PRF.User.checkout', [
            'registration' => $registrationAUX
        ]);

        } catch(Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function notification(Request $request){

        try{
            
           
            $user = PrfUser::find($request->session()->get('prf_user')->id);
            if(!$user){
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
            
                $registration = PrfRegistration::find($response['external_reference']);
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
         return response('ok', 200);

        } catch(Exception $e){
            Log::alert(['erro' => $e->getMessage()]);
            return response(['erro'=> $e],400);
        }

    }
}
