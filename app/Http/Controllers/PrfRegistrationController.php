<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrfStoreRegistrationRequest;
use App\Models\PrfPace;
use App\Models\PrfPayments;
use App\Models\PrfRegistration;
use App\Models\PrfTshirt;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PrfRegistrationController extends Controller
{
    public function create(Request $request){
        try{
            $paces = PrfPace::all();
          return  view('PRF.registration', [
           'paces' => $paces
          ]);

        } catch(Exception $e){
            return back();
        }
    }

    public function store(PrfStoreRegistrationRequest $request){
        try{
            if($request->password != $request->confirm_password){
                return back()->with('erro', 'Senhas diferentes');
            }
            $cart = $request->session()->get('cart');

            if(!$request->session()->has('cart')){
                return back()->with('erro', 'Adicione um pacote no carrinho');
            }

            $user = new PrfUser;
            $user->nome_completo = $request->nome;
            $user->cpf = preg_replace( '/[^0-9]/is', '', $request->cpf);
            $user->data_nasc = $request->data_nasc;
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->sexo = $request->sexo;
            $user->save();

            $registration = new PrfRegistration;
            $registration->prf_user_id = $user->id;
            $registration->prf_categorys_id = $cart['category']->id;
            $registration->prf_package_id = $cart['package']->id;
            $registration->prf_pace_id = $request->pace;
            $registration->status_regitration_id = 3;
            $registration->size_tshirt = $request->size_tshirt;
            $registration->equipe = $request->equipe;
            $registration->save();
            if(!is_null($cart['tshirts'])){
                foreach ($cart['tshirts'] as $tshirt_id) {
                    $tshirt = PrfTshirt::find($tshirt_id);
                    $registration->tshirts()->save($tshirt);
                }
            }
            $payment = new PrfPayments;
            $payment->prf_registration_id = $registration->id;
            $payment->status_payment_id = 3;
            $payment->save();
            

            $request->session()->put('prf_user', $user);
            return redirect('/PRF/dashboard');

        } catch(Exception $e){
            dd($e);
           
        }
    }
}
