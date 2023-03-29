<?php

namespace App\Http\Controllers;

use App\Models\group_category;
use App\Models\Modalities;
use App\Models\modalities_category;
use App\Models\Modalities_type;
use App\Models\mode_modalities;
use Exception;
use Illuminate\Http\Request;

class ModalidadeAdminController extends Controller
{
    public function show(Request $request){
        try{
            if(!($request->session()->get('admin')->rule->id == 1)){
                return back();
            }
            $modalidades = Modalities::all();
            $tipos_modalidades = Modalities_type::all();
            $groups = group_category::all();
            $mode = mode_modalities::all();
           

            return view('Admin.modalidades', [
               'modalidades'  => $modalidades,
               'modality_types' => $tipos_modalidades,
               'groups' => $groups,
               'mode' => $mode
            ]);
        } catch (Exception $e){
            return back();
        }
    }

    public function create(){
        try{
            $tipos_modalidades = Modalities_type::all();

            return view('Admin.create_modalidade', [
                'modality_types' => $tipos_modalidades
            ]);
        } catch (Exception $e){
            return back();
        }
    }

    public function store(Request $request){
        try{
            Modalities::create([
                'nome' => $request->nome,
                'limit_year_date' => $request->limit_year_date,
                'mode_modalities_id' => $request->mode,
                'modalities_type_id' => $request->type  
            ]);

            return back();
        }catch (Exception $e){
            return $e;
        }
    } 
}
