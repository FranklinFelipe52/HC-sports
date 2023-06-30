<?php

namespace App\Http\Controllers;

use App\Models\PrfCategorys;
use App\Models\PrfPackage;
use App\Models\PrfTshirt;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadesRequest;

class PrfCartController extends Controller
{
    public function show($category_id, $package_id){
        try{
            $category = PrfCategorys::find($category_id)->get();
            $package = PrfPackage::find($package_id)->get();

            if(!$category || ! $package){
                return back();
            }

          return  view('PRF.home', [
           'category' => $category,
           'package' => $package
          ]);

        } catch(Exception $e){

        }
    }

    public function putCart(Request $request, $category_id, $package_id){
        try{
            $category = PrfCategorys::find($category_id);
            $package = PrfPackage::find($package_id);
            $tshirts = PrfTshirt::all();

            if(!$category || ! $package){
                return back();
            }

            $cart = [
                'category' => $category,
                'package' => $package,
                'tshirts' => $tshirts
            ];
            $request->session()->put('cart', $cart);

          return  view('PRF.cart', [
           'tshirts' =>  $tshirts,
           'cart' => $request->session()->get('cart')
          ]);

        } catch(Exception $e){

        }
    }

    public function store(Request $request){
        try{
            $tshirts = $request->tshirts;

            $cart = $request->session()->get('cart');
            $cart['tshirts'] = $tshirts;
            $request->session()->put('cart', $cart);
           
            return redirect('/PRF/inscricao');
        } catch(Exception $e){
            error_log($e);
        }
    }
}
