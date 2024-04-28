<?php

namespace App\Http\Controllers;

use App\Helpers\AgeBetweenDates;
use App\Http\Requests\PrfStoreRegistrationRequest;
use App\Mail\CaernCadastroConfirmado;
use App\Mail\CaernConfirmRegistration;
use App\Models\Caern_adresses;
use App\Models\FederativeUnit;
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
use App\Models\PrfVauchers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class PrfRegistrationController extends Controller
{

    public function create(Request $request, $category_id, $package_id)
    {
        try {
            return back();
            $category = PrfCategorys::find($category_id);
            $package = PrfPackage::find($package_id);

            

            if (!$category || !$package) {
                return back();
            }
            return view('PRF.registration', [
                'category' => $category,
                'tshirts' => PrfTshirt::all(),
                'size_tshirts' => PrfSizeTshirts::all(),
                'deficiencys' => PrfDeficiency::all(),
                'federativeUnits' => FederativeUnit::all(),
            ]);

        } catch (Exception $e) {
            return back();
        }
    }

    public function store(PrfStoreRegistrationRequest $request, $category_id, $package_id)
    {
        try {
            $category = PrfCategorys::find($category_id);
            $package = PrfPackage::find($package_id);

            if (!$category || !$package) {
                return back();
            }

            if ($request->password != $request->confirm_password) {
                return back()->with('erro', 'Senhas diferentes');
            }

            $nascimento = Carbon::createFromFormat('d/m/Y', $request->data_nasc);

            if ($nascimento->year < 1943) {
                session()->flash('erro', 'Corrija o erro na data de nascimento.');
                return back()->withInput()->withErrors(['data_nasc' => 'O ano de nascimento não pode ser menor que 1943']);
            }

            if ($category->id == 1) {
                if ($nascimento->year > 2009) {
                    session()->flash('erro', 'Corrija o erro na data de nascimento.');
                    return back()->withInput()->withErrors(['data_nasc' => 'Na categoria 5km, o ano de nascimento não pode ser maior que 2009']);
                }
            } else {
                if ($nascimento->year > 2005) {
                    session()->flash('erro', 'Corrija o erro na data de nascimento.');
                    return back()->withInput()->withErrors(['data_nasc' => 'Na categoria 10km e 21km, o ano de nascimento não pode ser maior que 2005']);
                }
            }
            DB::beginTransaction();
            $user = new PrfUser;
            $adress = new Caern_adresses;
            
            $adress->cep = $request->cep;
            $adress->cidade = $request->cidade;
            $adress->bairro = $request->bairro;
            $adress->rua = $request->rua;
            $adress->federative_unit_id = $request->estado;
            $adress->number = $request->number;
            $adress->complemento = $request->complemento;

            $user->nome_completo = $request->nome;
            $user->cpf = preg_replace('/[^0-9]/is', '', $request->cpf);
            $data_convertida = Carbon::createFromFormat('d/m/Y', $request->data_nasc);
            $user->data_nasc = $data_convertida->format('Y-m-d');
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->sexo = $request->sexo;
            //$user->prf_deficiency_id = $request->pcd === 'N' ? null : $request->pcd;
            $user->is_servidor = $request->is_servidor ?? 0;
            $user->servidor_matricula = $request->servidor_matricula ?? 0;
            $user->save();
            $adress->prf_user_id = $user->id;
            $adress->save();

            $registration = new PrfRegistration;
            $registration->prf_user_id = $user->id;
            $registration->prf_categorys_id = $category->id;
            $registration->prf_package_id = $package->id;
            //$registration->status_regitration_id = $user->is_servidor && !(AgeBetweenDates::calc_idade($user->data_nasc) >= 60) ? 4 : 3;
            $registration->status_regitration_id = 3;
            $registration->prf_size_tshirts_id = $request->size_tshirt;
            $registration->equipe = $request->equipe;
            $registration->save();
            if (!is_null($request->tshirts)) {
                foreach ($request->tshirts as $tshirt_id) {
                    $tshirt = PrfTshirt::find($tshirt_id);
                    if ($tshirt) {
                        $registration->tshirts()->save($tshirt);
                    }
                }
            }
            $payment = new PrfPayments;
            $payment->prf_registration_id = $registration->id;
            $payment->status_payment_id = 3;
            $payment->save();

            $request->session()->put('prf_user', $user);
            DB::commit();

            Mail::to($user->email)->send(new CaernCadastroConfirmado($user, $category, $adress));

            return redirect('/dashboard');

        } catch (Exception $e) {
            DB::rollBack();
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
            $vaucher = PrfVauchers::find($registration->prf_vauchers_id);
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

            if ($vaucher && $vaucher->desconto == 1 && count($registration->tshirts) < 1) {
                $registration->status_regitration_id = 1;
                $registration->save();
            }

            if ($vaucher && $vaucher->desconto == 1 && count($registration->tshirts) > 0) {
                $registration->status_regitration_id = 3;
                $registration->save();
            }

            return redirect('/dashboard');
        } catch (Exception $e) {
            return back();
        }
    }

    public function confirm(Request $request, $registration_id)
    {
        try {
            $registration = PrfRegistration::find($registration_id);
            $payment = PrfPayments::where('prf_registration_id', $registration_id)->first();
            $user = PrfUser::find($registration->prf_user_id);
            $admin = PrfAdmin::find($request->session()->get('admin')->id);

            $registration->status_regitration_id = 1;
            $registration->validated_by_admin = true;
            $registration->observacao = $request->observacao;
            $registration->observacao_estorno = null;
            $registration->observacao_cancelamento = null;
            $registration->prf_vauchers_id = null;
            $registration->save();

            $payment->status_payment_id = 4;
            $payment->save();
            $category = $registration->prf_categorys;

            $admin_log = new PrfAdminLog;
            $admin_log->prf_admin_id = $admin->id;
            $admin_log->type_actions_admin_id = 7;
            $admin_log->description = 'Confirmou a inscrição do usuário de cpf ' . $user->cpf . ', e id #' . $user->id;
            $admin_log->save();
            Mail::to($user->email)->send(new CaernConfirmRegistration($user, $category));

            session()->flash('success', 'Confirmou a inscrição do usuário com sucesso!');
            return back();
        } catch (Exception $e) {
            dd($e);
            session()->flash('erro', 'Um erro interno aconteceu, não foi possível concluir sua ação.');
            return back();
        }
    }

    public function estorno(Request $request, $registration_id)
    {
        try {
            $registration = PrfRegistration::find($registration_id);
            $voucher = PrfVauchers::find($registration->prf_vauchers_id);

            if ($registration->validated_by_admin == 1) {
                session()->flash('erro', 'A inscrição desse usuário foi liberada pelo admin. Não é permitido estornar inscrição.');
                return back();
            }

            if ($voucher && $registration->status_regitration_id == PrfRegistration::STATUS_CONFIRMADO && $voucher->desconto == 1) {
                session()->flash('erro', 'A inscrição desse usuário foi liberada por cupom ou voucher com 100% de desconto. Não é permitido estornar inscrição.');
                return back();
            }

            $registration->status_regitration_id = PrfRegistration::STATUS_ESTORNADA;
            $registration->observacao_estorno = $request->input('observacao_estorno');
            $registration->observacao = null;
            $registration->observacao_cancelamento = null;
            $registration->prf_vauchers_id = null;
            $registration->save();

            session()->flash('success', 'Status da inscrição alterado para "estornada".');
            return back();
        } catch (Exception $e) {
            dd($e);
            session()->flash('erro', 'Um erro interno aconteceu, não foi possível concluir sua ação.');
            return back();
        }
    }

    public function cancelamento(Request $request, $registration_id)
    {
        try {
            $registration = PrfRegistration::find($registration_id);

            $registration->status_regitration_id = PrfRegistration::STATUS_CANCELADA;
            $registration->validated_by_admin = 0;
            $registration->observacao_cancelamento = $request->input('observacao_cancelamento');
            $registration->observacao = null;
            $registration->observacao_estorno = null;
            $registration->prf_vauchers_id = null;
            $registration->save();

            session()->flash('success', 'Status da inscrição alterado para "cancelada".');
            return back();
        } catch (Exception $e) {
            session()->flash('erro', 'Um erro interno aconteceu, não foi possível concluir sua ação.');
            return back();
        }
    }

}
