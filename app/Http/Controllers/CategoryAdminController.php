<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use App\Models\modalities_category;
use Exception;
use Illuminate\Http\Request;

class CategoryAdminController extends Controller
{
    public function store(Request $request){
        try{
            $modalidade = Modalities::find($request->modalidade_id);
            modalities_category::create([
                'titulo' => $modalidade->mode_modalities->code == 1 ? $modalidade->mode_modalities->mode : $request->nome,
                'min_f' => $request->min_f,
                'min_m' => $request->min_m,
                'min_year' => $request->limit_year,
                'modalities_id' => $request->modalidade_id,
                'group_category_id' => $request->group
            ]);

            return back();


        } catch (Exception $e) {
            return $e;
        }
    }
}
