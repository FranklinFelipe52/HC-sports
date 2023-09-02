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
    public function show(Request $request)
    {
        try {
            $user = PrfUser::find($request->session()->get('prf_user')->id);
            if (!$user) {
                return back();
            }

            $registrations = [];
            foreach ($user->registrations as $registration) {

                array_push($registrations, [
                    'id' => $registration->id,
                    'title' => $registration->prf_package->nome,
                    'descricao' => $registration->prf_package->descricao,
                    'price' => ValorTotal::ValorComDescontos($user, $registration),
                    'status_registration' => $registration->status_regitration,
                    'status_registration_id' => $registration->status_regitration_id,
                    'validated_by_admin' => $registration->validated_by_admin,
                    'prf_package_id' => $registration->prf_package_id,
                    'vaucher' => $registration->prf_vauchers,
                ]);
            }
            return view('PRF.User.dashboard', [
                'registrations' => $registrations,
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return dd($e);
        }
    }
}