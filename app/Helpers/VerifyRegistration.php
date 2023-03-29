<?php

namespace App\Helpers;

use App\Models\modalities_category;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyRegistration
{
    
    public static function verify(Request $request, $modalidade, $categorys ){
        $user = User::find($request->session()->get('user')->id);
        foreach ($categorys as $category) {
            if($category->min_year <= AgeBetweenDates::calc_idade($user->data_nasc, $modalidade->limit_year_date)){
                return back()->with('erro', "Desculpe, mas o limite de idade para a categoria $category->titulo na modalidade $modalidade->nome é $category->min_year anos");
            }
            
        }
        
        }

        public static function verify_backup(Request $request, $modalidade, $categorys ){
            /*foreach ($cat->registrations as $registration) {
                if($registration->payment->status == 'APROVADO'){
                    $registration->user->sexo == 'M' ? $genderValue['M'] = $genderValue['M'] + 1 : $genderValue['F'] = $genderValue['F'] + 1;
                }
            }
            if($request->session()->get('user')->sexo == 'M'){
                $genderValue['M'] < $cat->min_m ? null : (back()->with('erro', "O limite de inscrições já foi atingido"));
            } else {
                $genderValue['F'] < $cat->min_f ? null : (back()->with('erro', "O limite de inscrições já foi atingido"));
            }*/

        }

}
?>