<?php

namespace App\Http\Controllers;

use App\Classes\Checkout;
use App\Models\registration;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
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
