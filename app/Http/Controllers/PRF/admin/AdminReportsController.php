<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Models\PrfRegistration;
use App\Models\PrfSizeTshirts;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function index(Request $request)
    {
        try {
            return view('PRF.Admin.reports');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    // Converte string para ISO-8859-1 maiúsculo (compatibilidade CSV Excel)
    private function enc(?string $str): string
    {
        return mb_convert_encoding(mb_strtoupper($str ?? '', 'UTF-8'), 'ISO-8859-1', 'UTF-8');
    }

    public function all_users_get()
    {
        try {
            $users = PrfUser::with(['registrations.prf_categorys', 'registrations.prf_size_tshirts', 'caern_address.federativeUnit'])->get();

            $cabecalho = [
                $this->enc('Nome'),
                $this->enc('Email'),
                $this->enc('Telefone'),
                $this->enc('CPF'),
                $this->enc('Nascimento'),
                $this->enc('Sexo'),
                $this->enc('CEP'),
                $this->enc('Rua'),
                $this->enc('Número'),
                $this->enc('Bairro'),
                $this->enc('Cidade'),
                $this->enc('Estado'),
                $this->enc('Complemento'),
                $this->enc('Categoria'),
                $this->enc('Tamanho da camisa'),
                $this->enc('Equipe'),
                $this->enc('Documento de acesso'),
                $this->enc('Status da inscrição'),
            ];

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Atletas_CircuitoDunas2026.csv');

            $arquivo = fopen('php://output', 'w');
            fputcsv($arquivo, $cabecalho, ';');

            foreach ($users as $user) {
                $registration = $user->registrations->first();
                $address      = $user->caern_address;

                $row = [
                    $this->enc($user->nome_completo),
                    $this->enc($user->email),
                    $this->enc($user->phone),
                    $this->enc(preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $user->cpf)),
                    $this->enc($user->data_nasc ? date('d/m/Y', strtotime($user->data_nasc)) : ''),
                    $this->enc($user->sexo),
                    $this->enc($address?->cep),
                    $this->enc($address?->rua),
                    $this->enc($address?->number),
                    $this->enc($address?->bairro),
                    $this->enc($address?->cidade),
                    $this->enc($address?->federativeUnit?->initials),
                    $this->enc($address?->complemento),
                    $this->enc($registration?->prf_categorys?->nome),
                    $this->enc(PrfSizeTshirts::find($registration?->prf_size_tshirts_id)?->nome),
                    $this->enc($registration?->equipe),
                    $this->enc($registration?->whitelist_document),
                    $this->enc($registration?->status_regitration?->status),
                ];

                fputcsv($arquivo, $row, ';');
            }

            fclose($arquivo);

        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

}
