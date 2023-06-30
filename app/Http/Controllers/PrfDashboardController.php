<?php

namespace App\Http\Controllers;

use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;

class PrfDashboardController extends Controller
{
    public function show(Request $request){
        try{
            $user = PrfUser::find($request->session()->get('prf_user')->id);
            if(!$user){
              return back();
            }

            $registrations = [];
            foreach ($user->registrations as $registration) {
                $priceTshirts = 0;
                foreach ( $registration->tshirts as $tshirt) {
                    $priceTshirts = $priceTshirts + $tshirt->price;
                }
                array_push($registrations, [
                    'id' => $registration->id,
                    'title' => $registration->prf_categorys->nome.' '.$registration->prf_package->nome,
                    'descricao' => $registration->prf_package->descricao,
                    'pricePackage' => $registration->prf_categorys->price + $registration->prf_package->price,
                    'priceTshirts' => $priceTshirts,
                    'status_registration' => $registration->status_regitration,
                    'size_tshirt' => $registration->size_tshirt,
                    'equipe' => $registration->equipe,
                    'pace' => $registration->prf_pace->nome
                ]);
            }
            

            
            return view('PRF.user.dashboard', [
                'registrations' => $registrations,
            ]);
        } catch (Exception $e){
            return back();
        }
    }
}
