<?php

namespace App\Http\Controllers;

use App\Models\ActionsNotificatios;
use App\Models\PrfRegistration;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;

class PrfCheckoutController extends Controller
{
    public function checkout(Request $request, $id){

        try{
        $user = PrfUser::find($request->session()->get('prf_user')->id);
        $registration = PrfRegistration::find($id);

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
                return redirect('/PRF/dashboard');
            }

        $notifications = new ActionsNotificatios;
        $notifications->user_id = $user->id;
        $notifications->status_notificatios_id = 2;
        $notifications->save();
        return redirect('/PRF/dashboard');
        }catch(Exception $e){
            return redirect('/PRF/dashboard');
        }
    }
}
