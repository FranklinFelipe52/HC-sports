<?php

namespace App\Helpers;

use App\Models\modalities_category;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyRegistration
{

    public static function verifyConfirmRegistration($user){

        foreach ($user->registrations as $registration) {
            if($registration->status_regitration->id != 1){
                return true;
            }
           
        }
        return false;
    }
    public static function verifyModalitiesMinYear($category, $data_nasc, $modalidade){
        if($category->min_year && $category->min_year > AgeBetweenDates::calc_idade($data_nasc, $modalidade->limit_year_date)){
            return true;
         
        }
        return false;
    }
    public static function verifyModalitiesLimitWomen($category){
        $women = 0;
        foreach ($category->registrations as $registration) {
            if( $registration->user->sexo == 'F'){
                $women++;
            }
        }
        error_log($women);
        error_log($category->max_f);
        if(!is_null($category->max_f) && !($women < $category->max_f)){
            error_log('entrou');
            return true;
            
        }
        return false;
    }
    public static function verifyModalitiesLimitMan($category){
        $man = 0;
        foreach ($category->registrations as $registration) {
            if( $registration->user->sexo == 'M'){
                $man++;
            }
        }
        if(!is_null($category->max_m) && !($man < $category->max_m)){
            
                return true;
            
        }
        return false;
    }
    public static function verifyModalitiesLimitRegistrations($category, $admin){
        $n_registrations = 0;
        foreach ($category->registrations as $registration) {
            error_log($registration->user);
            if($registration->user->address->federativeUnit->id == $admin->federativeUnit->id){
                $n_registrations++;
            }
        }
        if($category->max_total && ($category->max_total <= $n_registrations)){
            return true;
           
        }
    return false;
}
    public static function verifyUserLimitRegistrations($user, $modalidade){
            $n_registrations = 0;
            $limit_registrations = 2;

            if($modalidade->id == 19){
                $limit_registrations = 3;
            }

            foreach ($user->registrations as $registration) {
                if($registration->modalities->id == 19){
                    $limit_registrations = 3;
                }
                $n_registrations++;
            }

            if(!($n_registrations <  $limit_registrations) ){
                return true;
              
            }
        return false;
    }

    public static function verifyUserIntoModalities($user, $category){
            foreach ($user->registrations as $registration) {
                
                if($registration->modalities_category->id == $category->id){
                    return true;
                  
                }
            }
            return false;
    }
}
?>