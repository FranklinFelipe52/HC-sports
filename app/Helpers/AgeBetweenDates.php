<?php

namespace App\Helpers;

use DateTime;

class AgeBetweenDates
{

    public static function calc_idade($dataNascimento)
    {
        $dataNascimento = new DateTime($dataNascimento);

        $anoAtual = date("Y");

        $ultimoDiaDoAno = new DateTime("$anoAtual-12-31");

        $diferenca = $dataNascimento->diff($ultimoDiaDoAno);

        return $diferenca->y;
    }

    public static function calc_idade_old($data_nasc, $data_referencia)
    {
        $data_nasc = date("d-m-Y", strtotime($data_nasc));
        $data_nasc = explode("-", $data_nasc);
        $data = date("d-m-Y", strtotime($data_referencia));
        $data = explode("-", $data);

        $anos = $data[2] - $data_nasc[2];

        if ($data_nasc[1] >= $data[1]) {

            if ($data_nasc[0] <= $data[0]) {

                return $anos;

            } else {

                return $anos - 1;

            }

        } else {

            return $anos;

        }

    }
}
?>