<?php

namespace App\Http\Controllers;

use App\Models\PrfCategorys;
use App\Models\PrfPackage;
use Exception;
use Illuminate\Http\Request;

class PrfHomeController extends Controller
{
    public function show(){
        try{
            $categorys = PrfCategorys::all();
            $packages = PrfPackage::all();
          return  view('PRF.home', [
           'categorys' => $categorys,
           'packages' => $packages
          ]);

        } catch(Exception $e){
            dd($e);
        }
    }
}
