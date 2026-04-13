<?php

namespace App\Http\Controllers;

use App\Models\AthleteWhitelist;
use App\Models\Caern_adresses;
use App\Models\FederativeUnit;
use App\Models\PrfCategorys;
use App\Models\PrfPackage;
use App\Models\PrfRegistration;
use App\Models\PrfSizeTshirts;
use App\Models\PrfUser;
use App\Rules\CpfValidate;
use App\Rules\PrfCpfUserExist;
use App\Rules\PrfEmailUserExist;
use App\Mail\PrfConfirmRegistration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class PrfRegistrationController extends Controller
{
    public function create(Request $request, $category_id, $package_id)
    {
        try {
            $category = PrfCategorys::find($category_id);
            $package  = PrfPackage::find($package_id);

            if (!$category || !$package) {
                return back();
            }

            return view('PRF.registration', [
                'category'       => $category,
                'size_tshirts'   => PrfSizeTshirts::all(),
                'federativeUnits' => FederativeUnit::all(),
            ]);
        } catch (Exception $e) {
            return back();
        }
    }

    public function store(Request $request, $category_id, $package_id)
    {
        try {
            $category = PrfCategorys::find($category_id);
            $package  = PrfPackage::find($package_id);

            if (!$category || !$package) {
                return back();
            }

            // Validação do documento na whitelist
            $rawDocument = preg_replace('/[^0-9]/', '', $request->input('document'));
            $entry = AthleteWhitelist::findDocument($rawDocument);

            if (!$entry) {
                return back()
                    ->withInput()
                    ->with('erro', 'CPF/CNPJ não identificado. Procure a Arena das Dunas!');
            }

            if (!$entry->hasSlotAvailable()) {
                return back()
                    ->withInput()
                    ->with('erro', 'O limite de inscrições para este CNPJ foi atingido. Procure a Arena das Dunas!');
            }

            // Validação dos campos do formulário
            $request->validate([
                'document' => ['required'],
                'email'    => ['required', 'email', new PrfEmailUserExist],
                'cpf'      => ['required', new CpfValidate, new PrfCpfUserExist],
                'password' => ['required', Password::min(8)],
                'nome'     => ['required'],
                'data_nasc' => ['required'],
                'sexo'     => ['required'],
                'phone'    => ['required'],
                'cep'      => ['required'],
                'cidade'   => ['required'],
                'estado'   => ['required'],
                'rua'      => ['required'],
                'number'   => ['required'],
                'bairro'   => ['required'],
                'size_tshirt' => ['required'],
            ], [
                'email.required' => 'E-mail é obrigatório',
                'email.email'    => 'Digite um E-mail válido',
                'cpf.required'   => 'CPF é obrigatório',
                'password'       => 'Digite uma senha válida',
                'nome.required'  => 'Nome é obrigatório',
                'size_tshirt.required' => 'Selecione o tamanho da camiseta',
            ]);

            if ($request->password !== $request->confirm_password) {
                return back()->withInput()->with('erro', 'As senhas não conferem.');
            }

            $nascimento = Carbon::createFromFormat('d/m/Y', $request->data_nasc);

            if ($nascimento->year < 1943) {
                return back()->withInput()->withErrors(['data_nasc' => 'O ano de nascimento não pode ser menor que 1943']);
            }

            DB::beginTransaction();

            $user = new PrfUser;
            $user->nome_completo = $request->nome;
            $user->cpf           = preg_replace('/[^0-9]/', '', $request->cpf);
            $user->data_nasc     = $nascimento->format('Y-m-d');
            $user->phone         = $request->phone;
            $user->email         = $request->email;
            $user->password      = Hash::make($request->password);
            $user->sexo          = $request->sexo;
            $user->save();

            $address = new Caern_adresses;
            $address->prf_user_id       = $user->id;
            $address->cep               = $request->cep;
            $address->cidade            = $request->cidade;
            $address->bairro            = $request->bairro;
            $address->rua               = $request->rua;
            $address->federative_unit_id = $request->estado;
            $address->number            = $request->number;
            $address->complemento       = $request->complemento;
            $address->save();

            $registration = new PrfRegistration;
            $registration->prf_user_id         = $user->id;
            $registration->prf_categorys_id     = $category->id;
            $registration->prf_package_id       = $package->id;
            $registration->status_regitration_id = PrfRegistration::STATUS_CONFIRMADO;
            $registration->prf_size_tshirts_id  = $request->size_tshirt;
            $registration->equipe               = $request->equipe;
            $registration->whitelist_document   = $rawDocument;
            $registration->save();

            $request->session()->put('prf_user', $user);

            DB::commit();

            try {
                Mail::to($user->email)->send(new PrfConfirmRegistration($user, $registration));
            } catch (Exception) {
                // falha no e-mail não deve impedir a inscrição
            }

            session()->flash('success', 'Inscrição realizada com sucesso!');
            return redirect('/dashboard');

        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('erro', 'Erro ao realizar inscrição. Tente novamente.');
        }
    }

    public function update_get(Request $request, $id)
    {
        try {
            $user         = PrfUser::find($request->session()->get('prf_user')->id);
            $registration = PrfRegistration::find($id);

            if (!$user || !$registration) {
                return back();
            }
            if ($registration->prf_user->id != $user->id) {
                return back();
            }

            return view('PRF.User.registration_update', [
                'categorys'   => PrfCategorys::all(),
                'user'        => $user,
                'registration' => $registration,
                'shirts_sizes' => PrfSizeTshirts::all(),
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function update_post(Request $request, $id)
    {
        try {
            $user         = PrfUser::find($request->session()->get('prf_user')->id);
            $registration = PrfRegistration::find($id);

            if (!$user || !$registration) {
                return back();
            }
            if ($registration->prf_user->id != $user->id) {
                return back();
            }

            $registration->prf_categorys_id    = $request->category;
            $registration->prf_size_tshirts_id = $request->size_tshirt;
            $registration->equipe              = $request->equipe;
            $registration->save();

            return redirect('/dashboard');
        } catch (Exception $e) {
            return back();
        }
    }

    public function cancelamento(Request $request, $registration_id)
    {
        try {
            $registration = PrfRegistration::find($registration_id);

            $registration->status_regitration_id      = PrfRegistration::STATUS_CANCELADA;
            $registration->observacao_cancelamento     = $request->input('observacao_cancelamento');
            $registration->observacao                  = null;
            $registration->observacao_estorno          = null;
            $registration->save();

            session()->flash('success', 'Inscrição cancelada com sucesso.');
            return back();
        } catch (Exception $e) {
            session()->flash('erro', 'Não foi possível concluir sua ação.');
            return back();
        }
    }
}
