<?php

namespace App\Helpers;
class CodeVaucherGenerate
{
    
    public static function generate(  ){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($j = 0; $j < 3; $j++) {
            for ($i = 0; $i < 3; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
            }
        $randomString = $j != 2 ? $randomString.'-' : $randomString;
     }
        return $randomString;
    }

    public static function delimitador( $code ){
        $code_aux = str_replace(' ', '', $code);
        $code_array=[];
        $code_array = str_split($code_aux, 1);
        if(Count($code_array) < 9){
            return $code; 
        }
        $code_end= '';
        for ($j = 0; $j < 9; $j++) {
            if( $j == 2 || $j == 5){
                $code_end .= $code_array[$j].'-';
            } else {
                $code_end .= $code_array[$j];
            }
     }
     
        return $code_end;
    }
}
?>