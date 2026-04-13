<?php

namespace App\Http\Controllers\PRF;

use App\Http\Controllers\Controller;
use App\Models\Caern_adresses;
use App\Models\FederativeUnit;
use App\Models\PrfUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PrfUserController extends Controller
{
    public function profile(Request $request)
    {
        try {
            $user = PrfUser::find(Session('prf_user')->id);
            $whitelist_document = $user->registrations()->whereNotNull('whitelist_document')->value('whitelist_document');
            return view('PRF.User.profile', [
                'user'               => $user,
                'whitelist_document' => $whitelist_document,
            ]);
        } catch (Exception $e) {
            return back();
        }
    }

    public function edit(Request $request)
    {
        try {
            $user = PrfUser::find(Session('prf_user')->id);
            return view('PRF.User.profile_edit', [
                'user'            => $user,
                'federativeUnits' => FederativeUnit::all(),
            ]);
        } catch (Exception $e) {
            return back();
        }
    }

    public function update(Request $request)
    {
        try {
            $user = PrfUser::find(Session('prf_user')->id);

            $request->validate([
                'nome'      => ['required', 'string'],
                'email'     => ['required', 'email', Rule::unique('prf_users', 'email')->ignore($user->id)],
                'phone'     => ['required'],
                'data_nasc' => ['required'],
                'sexo'      => ['required', 'in:M,F'],
                'cep'       => ['required'],
                'cidade'    => ['required'],
                'estado'    => ['required'],
                'rua'       => ['required'],
                'number'    => ['required'],
                'bairro'    => ['required'],
            ], [
                'email.unique' => 'Este e-mail já está em uso por outro cadastro.',
            ]);

            $nascimento = Carbon::createFromFormat('d/m/Y', $request->data_nasc);
            if ($nascimento->year < 1943) {
                return back()->withInput()->withErrors(['data_nasc' => 'O ano de nascimento não pode ser menor que 1943.']);
            }

            $user->nome_completo = strtoupper($request->nome);
            $user->email         = $request->email;
            $user->phone         = $request->phone;
            $user->data_nasc     = $nascimento->format('Y-m-d');
            $user->sexo          = $request->sexo;
            $user->save();

            $address = $user->caern_address ?? new Caern_adresses(['prf_user_id' => $user->id]);
            $address->cep                = $request->cep;
            $address->cidade             = strtoupper($request->cidade);
            $address->bairro             = strtoupper($request->bairro);
            $address->rua                = strtoupper($request->rua);
            $address->number             = strtoupper($request->number);
            $address->complemento        = $request->complemento ? strtoupper($request->complemento) : null;
            $address->federative_unit_id = $request->estado;
            $address->prf_user_id        = $user->id;
            $address->save();

            // Atualiza sessão com dados novos
            $request->session()->put('prf_user', $user->fresh());

            session()->flash('success', 'Dados atualizados com sucesso!');
            return redirect('/profile');
        } catch (Exception $e) {
            return back()->withInput()->with('erro', 'Erro ao salvar. Tente novamente.');
        }
    }
}
