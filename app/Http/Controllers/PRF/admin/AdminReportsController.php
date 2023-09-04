<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Models\PrfPayments;
use App\Models\PrfRegistration;
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

    public function all_users_get()
    {
        try {
            $users = PrfUser::all();

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_Todos_Usuarios.csv');

            $arquivo = fopen("php://output", "w");

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Servidor', 'UTF-8'), 'ISO-8859-1', "UTF-8")
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($users);
            foreach ($users as $value) {
                $user = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($value->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding(mb_strtoupper($value->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $value->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Servidor' => mb_convert_encoding(mb_strtoupper($value->is_servidor == 1 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                ];
                fputcsv($arquivo, $user, ';');
            }
            fclose($arquivo);
            back();
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function all_servidores_get()
    {
        try {
            $users = PrfUser::where('is_servidor', 1)->get();

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_Todos_Servidores.csv');

            $arquivo = fopen("php://output", "w");

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Status da inscrição', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($users);
            foreach ($users as $value) {
                $user = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($value->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding($value->email, 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $value->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Inscrição' => mb_convert_encoding($value->registrations[0]->status_regitration->status, 'ISO-8859-1', "UTF-8"),
                ];
                fputcsv($arquivo, $user, ';');
            }
            fclose($arquivo);
            back();
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function all_confirm_registrations()
    {
        try {
            $registrations = PrfRegistration::where('status_regitration_id', 1)->get();

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=relatorio_inscricoes_confirmadas.csv');

            $arquivo = fopen("php://output", "w");

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Status da inscrição', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($registrations);
            foreach ($registrations as $value) {
                $user = PrfUser::find($value->user->id);;

                $registration = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($user->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding($user->email, 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $user->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Inscrição' => mb_convert_encoding($value->status_regitration->status, 'ISO-8859-1', "UTF-8"),
                ];
                fputcsv($arquivo, $registration, ';');
            }
            fclose($arquivo);
            back();
        } catch (Exception $e) {
            dd($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }



    public function all_paid_registrations()
    {
        try {
            $payments = PrfPayments::where('status_payment_id', 1)->get();

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=todas_inscricoes_pagas_prf.csv');

            $arquivo = fopen("php://output", "w");

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Pacote', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Categoria', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($payments);
            foreach ($payments as $value) {
                $registration = PrfRegistration::find($value->prf_registration_id);

                $user = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($registration->user->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding($registration->user->email, 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $registration->user->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Pacote' => mb_convert_encoding($registration->prf_package->nome, 'ISO-8859-1', "UTF-8"),
                    'Categoria' => mb_convert_encoding($registration->prf_category->nome, 'ISO-8859-1', "UTF-8"),
                ];
                fputcsv($arquivo, $user, ';');

            }
            fclose($arquivo);
            back();
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
