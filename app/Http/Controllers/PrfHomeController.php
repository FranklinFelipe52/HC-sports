<?php

namespace App\Http\Controllers;

use App\Helpers\CodeVaucherGenerate;
use App\Models\PrfCategorys;
use App\Models\PrfPackage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PrfHomeController extends Controller
{
    public function show(){
        try{

            $categorys = new PrfCategorys;
            $categorys_geral = $categorys->all();
            $categorys_kids =$categorys->setConnection('mysql2')->with('prf_package')->get();

            $packages = PrfPackage::all();
            
          return  view('PRF.home', [
           'categorys_geral' => $categorys_geral,
           'categorys_kids' => $categorys_kids,
           'packages' => $packages
          ]);

        } catch(Exception $e){
            dd($e);
        }
    }
}
