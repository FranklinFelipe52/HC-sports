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
}
?>