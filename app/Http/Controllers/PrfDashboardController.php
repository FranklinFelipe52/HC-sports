<?php

namespace App\Http\Controllers;

use App\Helpers\ValorTotal;
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
                array_push($registrations, [
                    'id' => $registration->id,
                    'title' => $registration->prf_categorys->nome,
                    'descricao' => $registration->prf_package->descricao,
                    'price' => ValorTotal::ValorComDescontos($user, $registration),
                    'status_registration' => $registration->status_regitration,
                    'size_tshirt' => $registration->prf_size_tshirts->nome,
                    'equipe' => $registration->equipe,
                    'vaucher' => $registration->prf_vauchers
                ]);
            }


            
            return view('PRF.User.dashboard', [
                'registrations' => $registrations,
            ]);
        } catch (Exception $e){
            return dd($e);
        }
    }
}
