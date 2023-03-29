<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use App\Models\modalities_category;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function show(){
        try{
            return view('User.cart', []);
        } catch (Exception $e){
            return back();
        }
    }

    public function delete(Request $request, $key){
        try{
            $cart = $request->session()->get('cart');
            if($cart){
                unset($cart[$key]); 
            }
            $request->session()->put('cart', $cart);


            return back();

        } catch(Exception $e){
            return back();
        }
    }

    public function store(Request $request, $id){
        try{
            $modalidade = Modalities::find($id);
            $cart = $request->session()->get('cart');
            $categorys = [];

            if(Count($cart) >= 2){
                return back()->with('erro', 'Desculpe, mas o carrinho já está cheio');
            }

            if($modalidade){

                if($modalidade->mode_modalities->code == 1){
                    $categorys = [$modalidade->modalities_categorys()->first()];
                                     
                } elseif ($modalidade->mode_modalities->code == 2){ 
                    foreach ($request->checkbox as $cat) {
                        $c = modalities_category::find($cat);
                        if($c){
                            array_push($categorys, $c);
                        } else {
                            return back();
                        }
                    }            
                } else {
                    foreach ($request->category as $value) {
                        $c = modalities_category::find($value);
                    if($c){
                        array_push($categorys, $c);
                    } else {
                        return back();
                    }
                    }
                    
                }
                array_push($cart, [
                    'modalidade' => $modalidade,
                    'categorys' => $categorys ]); 
                $request->session()->put('cart', $cart);
                
                return back()->with('message', 'Modalidade adicionada com sucesso.');
            } else {
                return back();
            }
        
        } catch (Exception $e){
            return back()->with('erro', 'Houve um erro na inscrição, tente novamente.');
        }
    }
}
