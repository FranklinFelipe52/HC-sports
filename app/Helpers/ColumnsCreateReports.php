<?php

namespace App\Helpers;
class ColumnsCreateReports
{
    
    public static function createColumns(array $colunasRequest, $registration){
        $colunas = [];
        $colunas['Nome_completo'] = mb_convert_encoding(mb_strtoupper($registration->user->nome_completo, 'UTF-8'), 'ISO-8859-1', "UTF-8");
        foreach ($colunasRequest as $coluna) {
            switch ($coluna) {
                case '002':
                    $colunas['CPF'] = preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $registration->user->cpf);
                    break;
                case '003':
                    $colunas['Data_nascimento'] = mb_convert_encoding(date('d/m/Y', strtotime($registration->user->data_nasc)), 'ISO-8859-1', "UTF-8");
                    break;
                case '004':
                    $colunas['Genero'] = mb_convert_encoding(mb_strtoupper($registration->user->sexo, 'UTF-8'), 'ISO-8859-1', "UTF-8");
                    break;
                case '005':
                    $colunas['E-mail'] = mb_convert_encoding(mb_strtoupper($registration->user->email, 'UTF-8'), 'ISO-8859-1', "UTF-8");
                    break;
                case '006':
                    $colunas['Celular'] = mb_convert_encoding($registration->user->phone_number ? mb_strtoupper($registration->user->phone_number, 'UTF-8') : '', 'ISO-8859-1', "UTF-8");
                    break;
                case '007':
                    $colunas['Cidade'] = mb_convert_encoding(mb_strtoupper($registration->user->address->cidade, 'UTF-8'), 'ISO-8859-1', "UTF-8");
                    break;
                case '008':
                    $colunas['Estado'] = mb_convert_encoding(mb_strtoupper($registration->user->address->federativeUnit->initials, 'UTF-8'), 'ISO-8859-1', "UTF-8");
                    break;
                case '009':
                    $colunas['Modalidade'] = str_replace('?', '',  mb_convert_encoding(mb_strtoupper($registration->modalities->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '010':
                    $colunas['Faixa'] = mb_convert_encoding($registration->range ? mb_strtoupper($registration->range->range, 'UTF-8') : '', 'ISO-8859-1', "UTF-8");
                    break;
                case '011':
                    $colunas['Categoria'] = mb_convert_encoding(mb_strtoupper($registration->modalities_category->nome, 'UTF-8'), 'ISO-8859-1', "UTF-8");
                    break;
                case '012':
                    $colunas['Subcategoria'] = mb_convert_encoding($registration->sub_category ? mb_strtoupper($registration->sub_category->nome, 'UTF-8') : '', 'ISO-8859-1', "UTF-8");
                    break;
                case '013':
                    $colunas['Data_criacao'] = mb_convert_encoding(date('d/m/Y h:i:s', strtotime($registration->created_at)), 'ISO-8859-1', "UTF-8");
                    break;
                case '014':
                    $colunas['tipo_pagamento'] = mb_convert_encoding(mb_strtoupper($registration->type_payment->type, 'UTF-8'), 'ISO-8859-1', "UTF-8");
                    break;
                case '015':
                    $colunas['valor_pago'] = mb_convert_encoding($registration->Payment->mount ? "R$ " . number_format($registration->Payment->mount, 2, ',', '') : '', 'ISO-8859-1', "UTF-8");
                    break;
                case '016':
                    $colunas['status_pagamento'] = mb_convert_encoding(mb_strtoupper($registration->Payment->status_payment->status, 'UTF-8'), 'ISO-8859-1', "UTF-8");
                    break;
                case '017':
                    $colunas['pcd'] = mb_convert_encoding(mb_strtoupper($registration->user->is_pcd ? 'SIM' : 'NÃO', 'UTF-8'), 'ISO-8859-1', "UTF-8");
                    break;
                default:
                    break;
            }
        }

        return $colunas;
    }

    public static function createColumnsHeader(array $colunasRequest){
        $headers = [];
        array_push($headers, mb_convert_encoding(mb_strtoupper('Nome completo', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
        foreach ($colunasRequest as $coluna) {
            switch ($coluna) {
                case '002':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('CPF', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '003':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Data de nascimento', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '004':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Gênero', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '005':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('E-mail', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '006':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Celular', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '007':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Cidade', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '008':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Estado', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '009':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Modalidade', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '010':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Faixa', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '011':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Categoria', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '012':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Subcategoria', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '013':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Data de criação', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '014':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Tipo de pagamento', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '015':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Valor pago', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '016':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('Status de pagamento', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                case '017':
                    array_push($headers, mb_convert_encoding(mb_strtoupper('PCD', 'UTF-8'), 'ISO-8859-1', "UTF-8"));
                    break;
                default:
                    break;
            }
        }

        return $headers;
    }
}
?>