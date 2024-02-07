<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Models\PrfPayments;
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

    public function all_users_get()
    {
        try {
            $users = PrfUser::all();

            $dados = [];

            foreach ($users as $value) {
                if (count($value->registrations) > 0) {
                    $size_tshirt = PrfSizeTshirts::find($value->registrations[0]->prf_size_tshirts_id);
                    $size_tshirt_nome = '-';
                    if ($size_tshirt) {
                        $size_tshirt_nome = $size_tshirt->nome;
                    }

                    $equipe = '-';
                    if ($value->registrations[0]->equipe) {
                        $equipe = $value->registrations[0]->equipe;
                    }

                    $contato = '-';
                    if ($value->phone) {
                        $contato = $value->phone;
                    }

                    $category = '-';
                    if ($value->registrations[0]->prf_category) {
                        $category = $value->registrations[0]->prf_category;
                    }


                    $user = [
                        'Nome' => mb_convert_encoding(mb_strtoupper($value->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Email' => mb_convert_encoding(mb_strtoupper($value->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Contato' => mb_convert_encoding(mb_strtoupper($contato, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $value->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Nascimento' => mb_convert_encoding(mb_strtoupper(date('d/m/Y', strtotime($value->data_nasc)), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Sexo' => mb_convert_encoding(mb_strtoupper($value->sexo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Camisa' => mb_convert_encoding($size_tshirt_nome, 'ISO-8859-1', "UTF-8"),
                        'Equipe' => mb_convert_encoding(mb_strtoupper($equipe, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Servidor' => mb_convert_encoding(mb_strtoupper($value->is_servidor == 1 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'PCD' => mb_convert_encoding(mb_strtoupper($value->prf_deficiency ? $value->prf_deficiency->nome : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Inscrição' => mb_convert_encoding(mb_strtoupper($value->registrations[0]->status_regitration->status, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Categoria' => mb_convert_encoding(mb_strtoupper($category, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Pacote' => mb_convert_encoding(mb_strtoupper($value->registrations[0]->prf_package->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Ação social' => mb_convert_encoding(mb_strtoupper(count($value->registrations[0]->tshirts) > 0 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    ];

                    array_push($dados, $user);
                }
            }

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Contato', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Nascimento', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Sexo', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Tamanho da camisa', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Equipe', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Servidor', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('PCD', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Status da inscrição', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Categoria', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Pacote', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Ação social', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Todos Usuários - CorridaDaAgua.csv');

            $arquivo = fopen("php://output", "w");
            fputcsv($arquivo, $cabecalho, ';');

            foreach ($dados as $user) {
                fputcsv($arquivo, $user, ';');
            }

            fclose($arquivo);
            back();

        } catch (Exception $e) {
            dd($e);
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
                $user = PrfUser::find($value->user->id);
                ;

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

    public function all_pending_registrations_get()
    {
        try {
            $registrations = PrfRegistration::where('status_regitration_id', 2)->orwhere('status_regitration_id', 3)->get();

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_Usuarios_Pendentes.csv');

            $arquivo = fopen("php://output", "w");

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Servidor', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($registrations);
            foreach ($registrations as $value) {
                $registration = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($value->prf_user->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding(mb_strtoupper($value->prf_user->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $value->prf_user->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Servidor' => mb_convert_encoding(mb_strtoupper($value->prf_user->is_servidor == 1 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
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

    public function all_confirmed_registrations()
    {
        try {
            $registrations = PrfRegistration::where('status_regitration_id', 1)->get();

            $dados = [];

            foreach ($registrations as $registration) {

                $size_tshirt = PrfSizeTshirts::find($registration->prf_size_tshirts_id);
                $size_tshirt_nome = '-';
                if ($size_tshirt) {
                    $size_tshirt_nome = $size_tshirt->nome;
                }

                $equipe = '-';
                if ($registration->equipe) {
                    $equipe = $registration->equipe;
                }

                $contato = '-';
                if ($registration->prf_user->phone) {
                    $contato = $registration->prf_user->phone;
                }

                $category = '';
                if ($registration->prf_categorys) {
                    $category = $registration->prf_categorys->nome;
                }

                // dd($registration->prf_categorys->nome);

                $user = [
                    'Nome' => mb_convert_encoding(mb_strtoupper($registration->prf_user->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Email' => mb_convert_encoding(mb_strtoupper($registration->prf_user->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Contato' => mb_convert_encoding(mb_strtoupper($contato, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $registration->prf_user->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Nascimento' => mb_convert_encoding(mb_strtoupper(date('d/m/Y', strtotime($registration->prf_user->data_nasc)), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Sexo' => mb_convert_encoding(mb_strtoupper($registration->prf_user->sexo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Camisa' => mb_convert_encoding($size_tshirt_nome, 'ISO-8859-1', "UTF-8"),
                    'Equipe' => mb_convert_encoding(mb_strtoupper($equipe, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Servidor' => mb_convert_encoding(mb_strtoupper($registration->prf_user->is_servidor == 1 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'PCD' => mb_convert_encoding(mb_strtoupper($registration->prf_user->prf_deficiency ? $registration->prf_user->prf_deficiency->nome : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Inscrição' => mb_convert_encoding(mb_strtoupper($registration->status_regitration->status, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Categoria' => mb_convert_encoding(mb_strtoupper($category, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Pacote' => mb_convert_encoding(mb_strtoupper($registration->prf_package->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Ação social' => mb_convert_encoding(mb_strtoupper(count($registration->tshirts) > 0 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                ];

                array_push($dados, $user);
            }

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Contato', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Nascimento', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Sexo', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Tamanho da camisa', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Equipe', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Servidor', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('PCD', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Status da inscrição', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Categoria', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Pacote', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Ação social', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Inscrições confirmadas - CorridaDaAgua.csv');

            $arquivo = fopen("php://output", "w");
            fputcsv($arquivo, $cabecalho, ';');

            foreach ($dados as $user) {
                fputcsv($arquivo, $user, ';');
            }

            fclose($arquivo);
            back();

        } catch (Exception $e) {
            dd($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function all_not_confirmed_registrations()
    {
        try {
            $users = PrfUser::where('status_regitration_id', '!=', 1)->get();

            $dados = [];

            foreach ($users as $value) {
                if (count($value->registrations) > 0) {
                    $size_tshirt = PrfSizeTshirts::find($value->registrations[0]->prf_size_tshirts_id);
                    $size_tshirt_nome = '-';
                    if ($size_tshirt) {
                        $size_tshirt_nome = $size_tshirt->nome;
                    }

                    $equipe = '-';
                    if ($value->registrations[0]->equipe) {
                        $equipe = $value->registrations[0]->equipe;
                    }

                    $contato = '-';
                    if ($value->phone) {
                        $contato = $value->phone;
                    }


                    $user = [
                        'Nome' => mb_convert_encoding(mb_strtoupper($value->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Email' => mb_convert_encoding(mb_strtoupper($value->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Contato' => mb_convert_encoding(mb_strtoupper($contato, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Cpf' => mb_convert_encoding(mb_strtoupper(preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $value->cpf), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Nascimento' => mb_convert_encoding(mb_strtoupper(date('d/m/Y', strtotime($value->data_nasc)), 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Camisa' => mb_convert_encoding($size_tshirt_nome, 'ISO-8859-1', "UTF-8"),
                        'Equipe' => mb_convert_encoding(mb_strtoupper($equipe, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Servidor' => mb_convert_encoding(mb_strtoupper($value->is_servidor == 1 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'PCD' => mb_convert_encoding(mb_strtoupper($value->prf_deficiency ? $value->prf_deficiency->nome : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Inscrição' => mb_convert_encoding(mb_strtoupper($value->registrations[0]->status_regitration->status, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Categoria' => mb_convert_encoding(mb_strtoupper($value->registrations[0]->prf_categorys->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Pacote' => mb_convert_encoding(mb_strtoupper($value->registrations[0]->prf_package->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'Ação social' => mb_convert_encoding(mb_strtoupper(count($value->registrations[0]->tshirts) > 0 ? 'Sim' : 'Não', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    ];

                    array_push($dados, $user);
                }
            }

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Nome', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Email', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Contato', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Cpf', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Nascimento', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Tamanho da camisa', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Equipe', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Servidor', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('PCD', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Status da inscrição', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Categoria', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Pacote', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Ação social', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            ];

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_Todos_Usuarios.csv');

            $arquivo = fopen("php://output", "w");
            fputcsv($arquivo, $cabecalho, ';');

            foreach ($dados as $user) {
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
