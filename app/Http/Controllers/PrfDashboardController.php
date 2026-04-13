<?php

namespace App\Http\Controllers;

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

            $registrations = $user->registrations->map(function ($registration) use ($user) {
                $address = $user->caern_address;
                return [
                    'id'                  => $registration->id,
                    'created_at'          => $registration->created_at,
                    // Dados da corrida
                    'categoria'           => $registration->prf_categorys->nome,
                    'status_registration' => $registration->status_regitration,
                    'size_tshirt'         => $registration->prf_size_tshirts->nome,
                    'equipe'              => $registration->equipe,
                    // Dados pessoais
                    'nome'                => $user->nome_completo,
                    'cpf'                 => $user->cpf,
                    'data_nasc'           => $user->data_nasc,
                    'sexo'                => $user->sexo,
                    'phone'               => $user->phone,
                    'email'               => $user->email,
                    // Endereço
                    'cep'                 => $address?->cep,
                    'rua'                 => $address?->rua,
                    'numero'              => $address?->number,
                    'bairro'              => $address?->bairro,
                    'complemento'         => $address?->complemento,
                    'cidade'              => $address?->cidade,
                    'uf'                  => $address?->federativeUnit?->initials,
                ];
            });

            return view('PRF.User.dashboard', [
                'user'          => $user,
                'registrations' => $registrations,
            ]);
        } catch (Exception $e) {
            return back();
        }
    }
}
