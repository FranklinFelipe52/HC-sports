<?php

namespace App\Http\Controllers;

use App\Models\PrfRegistration;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrfReportsController extends Controller
{
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
                mb_convert_encoding(mb_strtoupper('Telefone', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Servidor', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Status da inscrição', 'UTF-8'), 'ISO-8859-1', "UTF-8")
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($users);
            foreach ($users as $value) {
                $user = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($value->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding(mb_strtoupper($value->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $value->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Telefone' => mb_convert_encoding(mb_strtoupper($value->phone, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Servidor' => mb_convert_encoding(mb_strtoupper($value->is_servidor == 1 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Inscrição' => mb_convert_encoding(mb_strtoupper($value->registrations[0]->status_regitration->status, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
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

    public function all_pending_registrations_get()
    {
        try {
            $registrations = PrfRegistration::where('status_regitration_id', 2)
                ->orWhere('status_regitration_id', 3)
                ->get();
            // dd($registrations[0]->prf_user->phone);

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_Inscrições_Pendentes.csv');

            $arquivo = fopen("php://output", "w");

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Telefone', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Servidor', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($registrations);
            foreach ($registrations as $value) {
                $registration = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($value->prf_user->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding(mb_strtoupper($value->prf_user->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $value->prf_user->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Telefone' => mb_convert_encoding(mb_strtoupper($value->prf_user->phone, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Servidor' => mb_convert_encoding(mb_strtoupper($value->prf_user->is_servidor == 1 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                ];
                fputcsv($arquivo, $registration, ';');
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
                mb_convert_encoding(mb_strtoupper('Telefone', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Status da inscrição', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($users);
            foreach ($users as $value) {
                $user = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($value->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding($value->email, 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $value->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Telefone' => mb_convert_encoding(mb_strtoupper($value->phone, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
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
}
