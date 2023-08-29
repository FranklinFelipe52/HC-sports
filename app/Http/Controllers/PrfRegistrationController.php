<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrfStoreRegistrationRequest;
use App\Models\PrfAdmin;
use App\Models\PrfAdminLog;
use App\Models\PrfCategorys;
use App\Models\PrfDeficiency;
use App\Models\PrfPace;
use App\Models\PrfPackage;
use App\Models\PrfPayments;
use App\Models\PrfRegistration;
use App\Models\PrfSizeTshirts;
use App\Models\PrfTshirt;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PrfRegistrationController extends Controller
{

    public function create(Request $request, $category_id, $package_id)
    {
        try {
            $category = PrfCategorys::find($category_id);
            $package = PrfPackage::find($package_id);

            if (!$category || !$package) {
                return back();
            }
            return view('PRF.registration', [
                'category' => $category,
                'tshirts' => PrfTshirt::all(),
                'size_tshirts' => PrfSizeTshirts::all(),
                'deficiencys' => PrfDeficiency::all()
            ]);

        } catch (Exception $e) {
            return back();
        }
    }

    public function store(PrfStoreRegistrationRequest $request)
    {
        try {
            if ($request->password != $request->confirm_password) {
                return back()->with('erro', 'Senhas diferentes');
            }

            $user = new PrfUser;
            $user->nome_completo = $request->nome;
            $user->cpf = preg_replace('/[^0-9]/is', '', $request->cpf);
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->is_servidor = $request->is_servidor;
            $user->save();

            $free_package_id = 1;
            $standart_package_id = 2;

            $registration = new PrfRegistration;
            $registration->prf_user_id = $user->id;
            $registration->prf_package_id = $request->is_servidor == 1 ? $free_package_id : $standart_package_id;

            // caso o pacote seja gratuito, marca inscrição como confirmada
            if ($registration->prf_package_id == 1) {
                $registration->status_regitration_id = 2;
            } else {
                $registration->status_regitration_id = 3;
            }

            $registration->save();

            $payment = new PrfPayments;
            $payment->prf_registration_id = $registration->id;
            $payment->status_payment_id = 3;
            $payment->save();

            $request->session()->put('prf_user', $user);
            return redirect('/dashboard');

        } catch (Exception $e) {
            return back()->withInput();
        }
    }

    public function update_get(Request $request, $id)
    {
        try {
            $user = PrfUser::find($request->session()->get('prf_user')->id);
            $registration = PrfRegistration::find($id);
            if (!$user) {
                return back();
            }
            if (!$registration) {
                return back();
            }
            if ($registration->prf_user->id != $user->id) {
                return back();
            }
            if ($registration->status_regitration_id == 1) {
                return back();
            }
            return view('PRF.User.registration_update', [
                'categorys' => PrfCategorys::all(),
                'user' => $user,
                'registration' => $registration,
                'shirts_sizes' => PrfSizeTshirts::all(),
                'tshirts' => PrfTshirt::all()
            ]);

        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function update_post(Request $request, $id)
    {
        try {
            $user = PrfUser::find($request->session()->get('prf_user')->id);
            $registration = PrfRegistration::find($id);
            if (!$user) {
                return back();
            }
            if (!$registration) {
                return back();
            }
            if ($registration->prf_user->id != $user->id) {
                return back();
            }
            if ($registration->status_regitration_id == 1) {
                return back();
            }
            $registration->prf_categorys_id = $request->category;
            $registration->prf_size_tshirts_id = $request->size_tshirt;
            $registration->equipe = $request->equipe;
            $registration->save();
            $registration_and_tshirts = DB::table('prf_tshirt_and_prf_registrations')->where('prf_registration_id', $registration->id)->get();
            foreach ($registration_and_tshirts as $value) {
                error_log($value->id);
                DB::table('prf_tshirt_and_prf_registrations')->delete($value->id);
            }
            if ($request->tshirts) {
                foreach ($request->tshirts as $tshirt_id) {
                    $tshirt = PrfTshirt::find($tshirt_id);
                    if ($tshirt) {
                        $registration->tshirts()->save($tshirt);
                    }
                }
            }

            return redirect('/dashboard');
        } catch (Exception $e) {
            return dd($e);
        }
    }

    public function confirm(Request $request, $registration_id)
    {
        try {
            $registration = PrfRegistration::find($registration_id);
            $payment = PrfPayments::where('prf_registration_id', $registration_id)->first();
            $user = PrfUser::find($registration->prf_user_id);
            $admin = PrfAdmin::find($request->session()->get('admin')->id);

            if ($registration->prf_package_id == 2) {
                session()->flash('error', 'Não é possível confirmar a inscrição deste usuário.');
                return back();
            }

            $registration->status_regitration_id = 1;
            $registration->save();

            $payment->status_payment_id = 4;
            $payment->save();

            $admin_log = new PrfAdminLog;
            $admin_log->prf_admin_id = $admin->id;
            $admin_log->type_actions_admin_id = 7;
            $admin_log->description = 'Confirmou a inscrição do usuário de cpf ' . $user->cpf . ', e id #' . $user->id;
            $admin_log->save();

            session()->flash('success', 'Confirmou a inscrição do usuário com sucesso!');
            return back();
        } catch (Exception $e) {
            session()->flash('error', 'Um erro interno aconteceu, não foi possível concluir sua ação.');
            return back();
        }
    }

}
