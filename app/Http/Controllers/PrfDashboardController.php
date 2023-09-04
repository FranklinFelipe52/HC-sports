<?php

namespace App\Http\Controllers;

use App\Helpers\ValorTotal;
use App\Models\PrfTshirt;
use App\Models\PrfTshirtAndPrfRegistration;
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

                $prfTshirtsRegistration = PrfTshirtAndPrfRegistration::where('prf_registration_id', $registration->id)->get();
                $tshirts = [];

                foreach ($prfTshirtsRegistration as $prfTshirtRegistration) {

                    $tshirt = PrfTshirt::find($prfTshirtRegistration->prf_tshirt_id);

                    array_push($tshirts, $tshirt);
                }

                array_push($registrations, [
                    'id' => $registration->id,
                    'title' => $registration->prf_categorys->nome,
                    'descricao' => $registration->prf_package->descricao,
                    'price' => ValorTotal::ValorComDescontos($user, $registration),
                    'status_registration' => $registration->status_regitration,
                    'size_tshirt' => $registration->prf_size_tshirts->nome,
                    'equipe' => $registration->equipe,
                    'tshirts' => $tshirts,
                    'vaucher' => $registration->prf_vauchers,
                    'validated_by_admin' => $registration->validated_by_admin,
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
