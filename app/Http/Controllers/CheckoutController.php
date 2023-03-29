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
            $user = User::find($request->session()->get('user')->id);
            $registration = registration::find($id);
            if($registration){
                $n_registration_payment = 0;
            foreach ($user->registrations as $register) {
                if($register->payment->status == 'APROVADO'){
                    $n_registration_payment = $n_registration_payment + 1;
                }
            }
            if($n_registration_payment >= 2){
                return back();
            }
                return view('User.checkout', [
                    'registration' => $registration,
                    'value_payment' => $n_registration_payment == 0 ? 150 : 100
                ]);
            } 

            return back();
        } catch (Exception $e){
            return $e;
        }
    }

    public function card(Request $request, $id){
        try{
            $register = registration::find($id);

            if(!$register || $register->payment->status == 'APROVADO'){
                return back();
            } else {
                $checkout = new Checkout(
                request: $request, 
                mount: 10000, 
                registration: $register,
                method: 1,
                url: env('PAGSEGURO_SANDBOX_URL_CHARGE'));

                $pay = $checkout->pay();
                if($pay && $pay->created()){
                    return redirect('/my-registrations');
                } else {
                    return back()->with('erro', 'Pagamento não efetuado');
                }
            }


        } catch (Exception $e){
            return back()->with('erro', 'Pagamento não efetuado');
        }
    }

    public function pix(Request $request, $id){
        try{
            $register = registration::find($id);

            if(!$register || $register->payment->status == 'APROVADO'){
                return back();
            } else {
                $checkout = new Checkout(
                request: $request, 
                mount: 10000, 
                registration: $register,
                method: 2,
                url: env('PAGSEGURO_SANDBOX_URL_CHARGE'));

                $pay = $checkout->pay();
                if($pay && $pay->created()){
                    return view('User.pix', ['pix' => $pay]);
                } else {
                    return back()->with('erro', 'Pagamento não efetuado');
                }
            }


        } catch (Exception $e){
            return back()->with('erro', 'Pagamento não efetuado');
        }
    }

    public function pix_view(){
        try{
            return view('User.pix');
        } catch (Exception $e){
            return back();
        }
    }
}
