<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show(Request $request){
        try{
           
            function separateCatOfRange($modalidades){
                $array = [];
                foreach ($modalidades as $modalidade) {
                    array_push($array, [
                        'modalidade' => $modalidade,
                        'categorias' => $modalidade->modalities_categorys()->where('group_category_id', 1)->get(),
                        'faixas' => $modalidade->modalities_categorys()->where('group_category_id', 2)->get()
                    ]);
                }

                return $array;
            }


           if(isset($_GET["s"])){
               $modalidades = separateCatOfRange(Modalities::where('nome', 'LIKE', '%'.$_GET["s"].'%')->get());
           } else {
               $modalidades = separateCatOfRange(Modalities::all());
           }
            return view('User.home', [
               'modalidades'  => $modalidades
            ]);
        } catch (Exception $e){
            return back();
        }
    }
}
