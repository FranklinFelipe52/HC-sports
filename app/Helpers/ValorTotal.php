<?php

namespace App\Helpers;

use App\Models\PrfRegistration;
use App\Models\PrfUser;
use Faker\Core\Number;

class ValorTotal
{

    public static function ValorComDescontos( PrfUser $user, PrfRegistration $registration){

                $priceRegistration = $registration->prf_package->price;
                $valor_bruto = $priceRegistration;
                $descontos = 0;
                if($registration->prf_vauchers){
                    $descontos = $registration->prf_vauchers->desconto > $descontos ? $registration->prf_vauchers->desconto : $descontos;
                }

                $valor_bruto = $valor_bruto - ($valor_bruto*$descontos);

        return $valor_bruto;
    }

    public static function DescontosTotais( PrfUser $user, PrfRegistration $registration){

        $descontos = 0;
        if($registration->prf_vauchers){
            $descontos = $registration->prf_vauchers->desconto > $descontos ? $registration->prf_vauchers->desconto : $descontos;
        }

return $descontos;
}
}
?>
