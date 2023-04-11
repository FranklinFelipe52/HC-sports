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
            if(!($registration && ($registration->user->id == $request->session()->get('user')->id))){
                return back();
            }


            return view('User.checkout');
        } catch (Exception $e){
            return back();
        }
    }

    public function card(Request $request, $id){
        try{
            $user = User::find($request->session()->get('user')->id);
            $registration = registration::find($id);
            if(!($registration && ($registration->user->id == $request->session()->get('user')->id))){
                return back();
            }
            if($user->user){

            }


            return view('User.card');

        } catch (Exception $e){
            return back();
        }
    }

    public function card_store(Request $request, $id){
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
            $registration = registration::find($id);
            if(!($registration && ($registration->user->id == $request->session()->get('user')->id))){
                return back();
            } else {
                $checkout = new Checkout(
                request: $request, 
                mount: 10000, 
                registration: $registration,
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
}
