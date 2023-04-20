<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use App\Models\Modalities_type;
use Exception;
use Illuminate\Http\Request;

class ModalidadeUserController extends Controller
{
    public function show(){
        try{
           if(isset($_GET["s"])){
               $modalidades = Modalities::where('nome', 'LIKE', '%'.$_GET["s"].'%')->get();
           } else {
               $modalidades = Modalities::all();
           }
            return view('User.home', [
               'modalidades'  => $modalidades
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
                'multi_category' => $request->multi_category ? '1' : '0',
                'is_default' => '1',
                'modalities_type_id' => $request->type  
            ]);
        }catch (Exception $e){
            return back();
        }
    } 
}
