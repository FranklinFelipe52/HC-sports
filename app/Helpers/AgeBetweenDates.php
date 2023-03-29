<?php

namespace App\Helpers;
class AgeBetweenDates
{
    
    public static function calc_idade( $data_nasc, $data_referencia ){
        $data_nasc = date("d-m-Y", strtotime($data_nasc));
        $data_nasc = explode("-", $data_nasc);
        $data = date("d-m-Y", strtotime($data_referencia));
        $data = explode("-", $data);
        
        $anos = $data[2] - $data_nasc[2];
        
        if ( $data_nasc[1] >= $data[1] ){
        
        if ( $data_nasc[0] <= $data[0] ){
        
        return $anos;
        
        }else{
        
        return $anos-1;
        
        }
        
        }else{
        
        return $anos;
        
        }
        
        }
}
?>