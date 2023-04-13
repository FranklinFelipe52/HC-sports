<?php

namespace App\Http\Controllers;

use App\Classes\Checkout;
use App\Models\log_payment;
use App\Models\registration;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    public function checkout(Request $request, $id){
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
                $valor = 150.00;
                break;
            case 1:
                $valor = 100.00;
                break;
            case 2:
                return back();
                break;
        }
        return view('User.registration', [
            'registration' => $registration,
            'valor' => $valor
        ]);
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
        $public_key = "TEST-7025cdd7-7291-46ff-9d81-c1b0cd8b6085";
        $access_token = "TEST-6607371367221296-041214-ea6401037ca3aab4fe22cb4d7086d497-1012467989";
        if($status == 'approved'){
            $registration->status_regitration_id = 1;
            $registration->save();
        }

        return redirect('/dashboard')->with('m', 'Pagamento efetuado com sucesso');
        }catch(Exception $e){
            return redirect('/dashboard')->with('m', 'Pagamento não efetuado por erro');
        }
    }
    public function show(Request $request, $id){
        try{
            $registration = registration::find($id);
            if(!$registration){
                return back();
            }
            if($registration->user->id != $request->session()->get('user')->id){
                return back();
            }
            

            return view('User.checkout', [
                'registration' => $registration
            ]);
        } catch (Exception $e){
            return $e;
        }
    }

    public function card(Request $request, $id){
        try{
            $user = User::find($request->session()->get('user')->id);
            $registration = registration::find($id);
            
            $valor = 0;

            $registrations_payment = 0;

            if(!$registration){
                return back();
            }
            if($registration->user->id != $request->session()->get('user')->id){
                return back();
            }

            foreach ($user->registrations as $registration) {
                if($registration->Payment->status_payment->id == 4){
                    $registrations_payment++;
                }
            }

            switch ($registrations_payment) {
                case 0:
                    
                    $valor = 150;
                    break;
                case 1:
                    $valor = 100;
                    break;
                case 2:
                    return back();
                    break;
            }
            return view('User.card', [
                'value_payment' => $valor,
                'registration' => $registration
            ]);

        } catch (Exception $e){
            return back();
        }
    }

    public function card_store(Request $request, $id){
        try{
            $user = User::find($request->session()->get('user')->id);
            $registration = registration::find($id);
            if(!$registration){
                return back();
            }
            if($registration->user->id != $request->session()->get('user')->id){
                return back();
            }

            $valor = 0;
            $registrations_payment = 0;

            foreach ($user->registrations as $registration) {
                if($registration->Payment->status_payment->id == 4){
                    $registrations_payment++;
                }
            }
            switch ($registrations_payment) {
                case 0:
                    $valor = 150;
                    break;
                case 1:
                    $valor = 100;
                    break;
                case 2:
                    return back();
                    break;
            }
                $checkout = new Checkout(
                request: $request, 
                mount: $valor*10, 
                registration: $registration,
                method: 1,
                url: env('PAGSEGURO_SANDBOX_URL_CHARGE'));

                $pay = $checkout->pay();
                if($pay && $pay->created()){
                    error_log($pay);
                    return redirect('/dashboard');
                } else {
                    return back()->with('erro', 'Pagamento não efetuado');
                }
            


        } catch (Exception $e){
            return back()->with('erro', 'Pagamento não efetuado');
        }
    }

    public function pix(Request $request, $id){
        try{
            $user = User::find($request->session()->get('user')->id);
            $registration = registration::find($id);
            if(!$registration){
                return back();
            }
            if($registration->user->id != $request->session()->get('user')->id){
                return back();
            }
            $valor = 0;
            $registrations_payment = 0;

            foreach ($user->registrations as $registration) {
                if($registration->Payment->status_payment->id == 4){
                    $registrations_payment++;
                }
            }

            switch ($registrations_payment) {
                case 0:
                    $valor = 150;
                    break;
                case 1:
                    $valor = 100;
                    break;
                case 2:
                    return back();
                    break;
            }

                $checkout = new Checkout(
                request: $request, 
                mount: 110, 
                registration: $registration,
                method: 2,
                url: env('PAGSEGURO_SANDBOX_URL_CHARGE'));

                $pay = $checkout->pay();
                error_log($pay);
                if($pay && $pay->created()){
                    return view('User.pix', [
                        'pix' => $pay,
                        'valor' => $valor
                ]);
                } else {
                    return redirect("/checkout/$registration->id")->with('erro', 'Pagamento não efetuado');
                }
        } catch (Exception $e){
            return $e;
        }
    }
}
