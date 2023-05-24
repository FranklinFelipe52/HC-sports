<?php

namespace App\Http\Controllers;

use App\Models\registration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportsController extends Controller
{
    public function RegistrationsReport(){
        try{
            $array_registrations = [];
            $registrations = registration::where('modalities_id', '<>', 11)->get();
            foreach ($registrations as $registration) {
                
                array_push($array_registrations, [
                    'Nome_completo' =>  mb_convert_encoding(mb_strtoupper($registration->user->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Data_nascimento' => mb_convert_encoding(date('d/m/Y', strtotime($registration->user->data_nasc)), 'ISO-8859-1', "UTF-8"),
                    'Genero' =>  mb_convert_encoding(mb_strtoupper($registration->user->sexo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'E-mail' =>  mb_convert_encoding(mb_strtoupper($registration->user->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Celular' =>   mb_convert_encoding($registration->user->phone_number ? mb_strtoupper($registration->user->phone_number, 'UTF-8') : '' , 'ISO-8859-1', "UTF-8"),
                    'Cidade' => mb_convert_encoding(mb_strtoupper($registration->user->address->cidade, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Estado' => mb_convert_encoding(mb_strtoupper($registration->user->address->federativeUnit->initials, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Modalidade' => str_replace('-', '',  mb_convert_encoding(mb_strtoupper($registration->modalities->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8")),
                    'Faixa' => mb_convert_encoding($registration->range ? mb_strtoupper($registration->range->range, 'UTF-8') : '' , 'ISO-8859-1', "UTF-8"),
                    'Categoria' => mb_convert_encoding(mb_strtoupper($registration->modalities_category->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Subcategoria' => mb_convert_encoding($registration->sub_category ? mb_strtoupper($registration->sub_category->nome, 'UTF-8') : '' , 'ISO-8859-1', "UTF-8"),
                    'Data_criacao' => mb_convert_encoding(date('d/m/Y h:i:s', strtotime($registration->created_at)), 'ISO-8859-1', "UTF-8"),
                    'tipo_pagamento' => mb_convert_encoding(mb_strtoupper($registration->type_payment->type, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'valor_pago' => mb_convert_encoding($registration->Payment->mount ? mb_strtoupper($registration->Payment->mount, 'UTF-8') : '', 'ISO-8859-1', "UTF-8"),
                    'status_pagamento' => mb_convert_encoding(mb_strtoupper($registration->Payment->status_payment->status, 'UTF-8'), 'ISO-8859-1', "UTF-8")
                ]);
            }
            $registrations = registration::where('modalities_id', 11)->join('natacao_categorias', 'natacao_categorias.registration_id', 'registrations.id')
            ->select('registrations.id', 'registrations.user_id', 'natacao_categorias.modalities_category_id', 'registrations.modalities_id', 'registrations.range_id', 'registrations.status_regitration_id', 'registrations.type_payment_id', 'registrations.created_at', 'registrations.is_pcd', 'registrations.sub_categorys_id')
            ->get();
            foreach ($registrations as $registration) {
                
                array_push($array_registrations, [
                    'Nome_completo' =>  mb_convert_encoding(mb_strtoupper($registration->user->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Data_nascimento' => mb_convert_encoding(date('d/m/Y', strtotime($registration->user->data_nasc)), 'ISO-8859-1', "UTF-8"),
                    'Genero' =>  mb_convert_encoding(mb_strtoupper($registration->user->sexo, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'E-mail' =>  mb_convert_encoding(mb_strtoupper($registration->user->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Celular' =>   mb_convert_encoding($registration->user->phone_number ? mb_strtoupper($registration->user->phone_number, 'UTF-8') : '' , 'ISO-8859-1', "UTF-8"),
                    'Cidade' => mb_convert_encoding(mb_strtoupper($registration->user->address->cidade, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Estado' => mb_convert_encoding(mb_strtoupper($registration->user->address->federativeUnit->initials, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Modalidade' => str_replace('-', '',  mb_convert_encoding(mb_strtoupper($registration->modalities->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8")),
                    'Faixa' => mb_convert_encoding($registration->range ? mb_strtoupper($registration->range->range, 'UTF-8') : '' , 'ISO-8859-1', "UTF-8"),
                    'Categoria' => mb_convert_encoding(mb_strtoupper($registration->modalities_category->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'Subcategoria' => mb_convert_encoding($registration->sub_category ? mb_strtoupper($registration->sub_category->nome, 'UTF-8') : '' , 'ISO-8859-1', "UTF-8"),
                    'Data_criacao' => mb_convert_encoding(date('d/m/Y h:i:s', strtotime($registration->created_at)), 'ISO-8859-1', "UTF-8"),
                    'tipo_pagamento' => mb_convert_encoding(mb_strtoupper($registration->type_payment->type, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'valor_pago' => '',
                    'status_pagamento' => mb_convert_encoding(mb_strtoupper($registration->Payment->status_payment->status, 'UTF-8'), 'ISO-8859-1', "UTF-8")
                ]);
            }

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_inscrições.csv');

            $arquivo = fopen("php://output", "w");
            $cabecalho = [
            mb_convert_encoding(mb_strtoupper('Nome completo', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Data de nascimento', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Gênero', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('E-mail', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Celular', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Cidade', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Estado', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Modalidade', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Faixa', 'UTF-8'), 'ISO-8859-1', "UTF-8") ,
            mb_convert_encoding(mb_strtoupper('Categoria', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Subcategoria', 'UTF-8') , 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Data de criação', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding(mb_strtoupper('Tipo de pagamento', 'UTF-8'), 'ISO-8859-1', "UTF-8") ,
            mb_convert_encoding(mb_strtoupper('valor pago', 'UTF-8'), 'ISO-8859-1', "UTF-8") ,
            mb_convert_encoding(mb_strtoupper('Status de pagamento', 'UTF-8'), 'ISO-8859-1', "UTF-8")];
            
           
            fputcsv($arquivo, $cabecalho, ';');
            $key_values = array_column($array_registrations,'Nome_completo');
            array_multisort($key_values, SORT_ASC, $array_registrations);
            foreach ($array_registrations as $value) {
                fputcsv($arquivo, $value, ';');
            }
            fclose($arquivo);
            back();

        }catch(Exception $e){
            return back();
        }
    }
}
