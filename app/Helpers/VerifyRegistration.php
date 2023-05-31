<?php

namespace App\Helpers;

use App\Models\modalities_category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        error_log($data_nasc);
        if($category->min_year && $category->min_year > AgeBetweenDates::calc_idade($data_nasc, $modalidade->limit_year_date)){
            return true;
        }
        return false;
    }
    public static function verifyModalitiesLimitWomen($category, $federativeUnit){
        $women = 0;
        if($category->modalities->mode_modalities->id == 2){
            foreach ($category->registrationss as $registration) {
                if($registration->user->address->federativeUnit->id == $federativeUnit){
                    if( $registration->user->sexo == 'F'){
                        $women++;
                    }
                }
               
            }
        } else {
            foreach ($category->registrations as $registration) {
                if($registration->user->address->federativeUnit->id == $federativeUnit){
                    if( $registration->user->sexo == 'F'){
                        $women++;
                    }
                }
               
            }
        }
        
        if(!is_null($category->max_f) && !($women < $category->max_f)){
            return true;
            
        }
        return false;
    }
    public static function verifyModalitiesLimitMan($category, $federativeUnit){
        $man = 0;
        if($category->modalities->mode_modalities->id == 2){
            foreach ($category->registrationss as $registration) {
                if($registration->user->address->federativeUnit->id == $federativeUnit){
                    if( $registration->user->sexo == 'M'){
                        $man++;
                    }
                }
               
            }
        } else {
            foreach ($category->registrations as $registration) {
                if($registration->user->address->federativeUnit->id == $federativeUnit){
                    if( $registration->user->sexo == 'M'){
                        $man++;
                    }
                }
               
            }
        }

        if(!is_null($category->max_m) && !($man < $category->max_m)){
            
                return true;
            
        }
        return false;
    }
    public static function verifyModalitiesLimitRegistrationsSeccional($category, $federativeUnit){
        
        $n_registrations = 0;
        if($category->modalities->mode_modalities->id == 2){
            foreach ($category->registrationss as $registration) {
                if($registration->user->address->federativeUnit->id == $federativeUnit){
                    $n_registrations++;
                }
            }
        }else {
            foreach ($category->registrations as $registration) {
                if($registration->user->address->federativeUnit->id == $federativeUnit){
                    $n_registrations++;
                }
            }
        } 
        
        if($category->max_secc && !($n_registrations < $category->max_secc)){
            error_log('entrou 2');
            return true;
        }
    return false;
}

public static function verifyModalitiesLimitRegistrationsSeccionalByRangeMan($category, $range_id, $federativeUnit){
    $man = 0;
    foreach ($category->registrations as $registration) {
        if($registration->user->address->federativeUnit->id == $federativeUnit){
            error_log('passou federative');
            if($registration->range->id == $range_id){
                error_log('passou range');
                if( $registration->user->sexo == 'M'){
                    error_log('passou gender');
                    $man++;
                }
            }
            
        }
    }
    
    if(!($man < 4)){ 
        return true;
    }
return false;
}
public static function verifyModalitiesLimitRegistrationsSeccionalByRangeWomen($category, $range_id, $federativeUnit){
    $women = 0;
    foreach ($category->registrations as $registration) {
        if($registration->user->address->federativeUnit->id == $federativeUnit){
            if($registration->range->id == $range_id){
                if( $registration->user->sexo == 'F'){
                    $women++;
                }
            }
            
        }
    }
    if(!($women < 4)){ 
        return true;
    }
return false;
}

public static function verifyModalitiesLimitRegistrations($category){
    $n_registrations = 0;
    if($category->modalities->mode_modalities->id == 2){
        foreach ($category->registrationss as $registration) {
            $n_registrations++;
    }
    } else {
        foreach ($category->registrations as $registration) {
            $n_registrations++;
    }
    }
   
    if($category->max_total && !($n_registrations < $category->max_total)){
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
                if($registration->modalities_category){
                    if($registration->modalities_category->id == $category->id){
                        return true;
                    }
                } 
                
            }
            return false;
    }
}
