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
                Log::error($registration->Payment);
                array_push($array_registrations, [
                    'Nome_completo' =>  mb_convert_encoding($registration->user->nome_completo, 'ISO-8859-1', "UTF-8"),
                    'E-mail' =>  mb_convert_encoding($registration->user->email, 'ISO-8859-1', "UTF-8"),
                    'Data_nascimento' => mb_convert_encoding(date('d/m/Y', strtotime($registration->user->data_nasc)), 'ISO-8859-1', "UTF-8"),
                    'Estado' => mb_convert_encoding($registration->user->address->federativeUnit->initials, 'ISO-8859-1', "UTF-8"),
                    'Cidade' => mb_convert_encoding($registration->user->address->cidade, 'ISO-8859-1', "UTF-8"),
                    'Modalidade' => mb_convert_encoding($registration->modalities->nome, 'ISO-8859-1', "UTF-8"),
                    'Faixa' => mb_convert_encoding($registration->range ? $registration->range->range : '' , 'ISO-8859-1', "UTF-8"),
                    'Categoria' => mb_convert_encoding($registration->modalities_category->nome, 'ISO-8859-1', "UTF-8"),
                    'Subcategoria' => mb_convert_encoding($registration->sub_category ? $registration->sub_category->nome : '' , 'ISO-8859-1', "UTF-8"),
                    'Data_criacao' => mb_convert_encoding(date('d/m/Y h:i:s', strtotime($registration->created_at)), 'ISO-8859-1', "UTF-8"),
                    'tipo_pagamento' => mb_convert_encoding($registration->type_payment->type, 'ISO-8859-1', "UTF-8"),
                    'status_pagamento' => mb_convert_encoding($registration->Payment->status_payment->status, 'ISO-8859-1', "UTF-8")
                ]);
            }
            $registrations = registration::where('modalities_id', 11)->join('natacao_categorias', 'natacao_categorias.registration_id', 'registrations.id')->get();
            foreach ($registrations as $registration) {
                Log::error($registration->Payment);
                array_push($array_registrations, [
                    'Nome_completo' =>  mb_convert_encoding($registration->user->nome_completo, 'ISO-8859-1', "UTF-8"),
                    'E-mail' =>  mb_convert_encoding($registration->user->email, 'ISO-8859-1', "UTF-8"),
                    'Data_nascimento' => mb_convert_encoding(date('d/m/Y', strtotime($registration->user->data_nasc)), 'ISO-8859-1', "UTF-8"),
                    'Estado' => mb_convert_encoding($registration->user->address->federativeUnit->initials, 'ISO-8859-1', "UTF-8"),
                    'Cidade' => mb_convert_encoding($registration->user->address->cidade, 'ISO-8859-1', "UTF-8"),
                    'Modalidade' => mb_convert_encoding($registration->modalities->nome, 'ISO-8859-1', "UTF-8"),
                    'Faixa' => mb_convert_encoding($registration->range ? $registration->range->range : '' , 'ISO-8859-1', "UTF-8"),
                    'Categoria' => mb_convert_encoding($registration->modalities_category->nome, 'ISO-8859-1', "UTF-8"),
                    'Subcategoria' => mb_convert_encoding($registration->sub_category ? $registration->sub_category->nome : '' , 'ISO-8859-1', "UTF-8"),
                    'Data_criacao' => mb_convert_encoding(date('d/m/Y h:i:s', strtotime($registration->created_at)), 'ISO-8859-1', "UTF-8"),
                    'tipo_pagamento' => mb_convert_encoding($registration->type_payment->type, 'ISO-8859-1', "UTF-8"),
                    'status_pagamento' => mb_convert_encoding($registration->Payment->status_payment->status, 'ISO-8859-1', "UTF-8")
                ]);
            }

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_inscrições.csv');

            $arquivo = fopen("php://output", "w");
            $cabecalho = [mb_convert_encoding('Nome completo', 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('E-mail', 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('Data de nascimento', 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('Estado', 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('Cidade', 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('Modalidade', 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('Faixa', 'ISO-8859-1', "UTF-8") ,
            mb_convert_encoding('Categoria', 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('Subcategoria' , 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('Data de criação', 'ISO-8859-1', "UTF-8"),
            mb_convert_encoding('Tipo de pagamento', 'ISO-8859-1', "UTF-8") ,
            mb_convert_encoding('Status de pagamento', 'ISO-8859-1', "UTF-8")];
            
           
            fputcsv($arquivo, $cabecalho, ';');
            foreach ($array_registrations as $value) {
                fputcsv($arquivo, $value, ';');
            }
            fclose($arquivo);
            back();

        }catch(Exception $e){
            return $e;
        }
    }
}
