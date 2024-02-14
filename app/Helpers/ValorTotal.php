<?php

namespace App\Helpers;

use App\Models\PrfRegistration;
use App\Models\PrfUser;
use Faker\Core\Number;

class ValorTotal
{

    public static function ValorComDescontos( PrfUser $user, PrfRegistration $registration){

                $priceTshirts = 0;
                foreach ( $registration->tshirts as $tshirt) {
                    $priceTshirts = $priceTshirts + $tshirt->price;
                }
                $priceRegistration = $registration->prf_categorys->price;
                $valor_bruto = $priceRegistration;
                $descontos = 0;
                if(AgeBetweenDates::calc_idade($user->data_nasc) >= 60 || $user->prf_deficiency_id){
                    $descontos = 0.5;
                }elseif($user->desconto_CAERN){
                    $descontos = 0.4;
                }
                if($registration->prf_vauchers){
                    $descontos = $registration->prf_vauchers->desconto > $descontos ? $registration->prf_vauchers->desconto : $descontos;
                }

                $valor_bruto = $valor_bruto - ($valor_bruto*$descontos);
                $valor_bruto = $valor_bruto + $priceTshirts;

        return $valor_bruto;
    }

    public static function DescontosTotais( PrfUser $user, PrfRegistration $registration){

        $descontos = 0;
        if(AgeBetweenDates::calc_idade($user->data_nasc) >= 60 || $user->prf_deficiency_id){
            $descontos = 0.5;
        }elseif($user->desconto_CAERN){
            $descontos = 0.4;
        }
        if($registration->prf_vauchers){
            $descontos = $registration->prf_vauchers->desconto > $descontos ? $registration->prf_vauchers->desconto : $descontos;
        }

return $descontos;
}
}
?>
