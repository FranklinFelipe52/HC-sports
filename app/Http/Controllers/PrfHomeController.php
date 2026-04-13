<?php

namespace App\Http\Controllers;

use App\Models\PrfCategorys;
use App\Models\PrfPackage;
use Exception;

class PrfHomeController extends Controller
{
    public function show(){
        try{

            $categorys_geral = PrfCategorys::on('mysql')->get();
            $packages = PrfPackage::all();

          return  view('PRF.home', [
           'categorys_geral' => $categorys_geral,
           'packages' => $packages
          ]);

        } catch(Exception $e){
            dd($e);
        }
    }
}
