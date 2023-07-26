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
                $valor_bruto = $priceTshirts + $priceRegistration;
                if(AgeBetweenDates::calc_idade($user->data_nasc, "28-12-".date("Y")) >= 60 || $user->prf_deficiency_id){
                    $valor_bruto = $valor_bruto*0.5;
                }
            
        return $valor_bruto;
    }

    public static function DescontosTotais( PrfUser $user){
            
        $descontos = 0;
        if(AgeBetweenDates::calc_idade($user->data_nasc, "28-12-".date("Y")) >= 60 || $user->prf_deficiency_id){
            $descontos = 0.5;
        }
    
return $descontos == 0 ? 1 : $descontos;
}
}
?>