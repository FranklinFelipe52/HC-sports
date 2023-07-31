<?php

namespace App\Http\Controllers;

use App\Helpers\CodeVaucherGenerate;
use App\Models\PrfRegistration;
use App\Models\PrfVauchers;
use Exception;
use Illuminate\Http\Request;

class PrfVauchersController extends Controller
{
    public function create_vaucher(Request $request) {
        try {
            return view('PRF.Admin.criar_voucher');
        } catch(Exception $e) {
            session()->flash('erro', 'Algo deu errado');
            return back();
        }
    }

    public function store_vauchers(Request $request){
        try{
            for($i = 0; $i < intval($request->quant); $i++){
                $code = '';
                do {
                    $verify = false;
                    $code = CodeVaucherGenerate::generate();
                    if(!PrfVauchers::where('code', $code )->first()){
                        $verify = true;
                    }
                } while($verify);
              $vaucher = new PrfVauchers;
              $vaucher->code = $code;
              $vaucher->descricao = $request->descricao;
              $vaucher->desconto = floatval($request->desconto);
              $vaucher->validade =  $request->validade;
              $vaucher->save();
            }

            return redirect('/admin/voucher_criado');
        }
        catch(Exception $e){
            return back();
        }
    }

    public function create_cupom(Request $request) {
        try {
            return view('PRF.Admin.criar_cupom');
        } catch(Exception $e) {
            session()->flash('erro', 'Algo deu errado');
            return back();
        }
    }

    public function store_cupom(Request $request){
        try{
            for($i = 0; $i < $request->quant; $i++){
                $code = '';
                do {
                    $verify = false;
                    $code = $request->cupom;
                    if(!PrfVauchers::where('code', $code)->first()){
                        $verify = true;
                    }
                } while($verify);
              $vaucher = new PrfVauchers;
              $vaucher->code = $code;
              $vaucher->descricao = $request->descricao;
              $vaucher->desconto = $request->desconto;
              $vaucher->isCupom = true;
              $vaucher->validade =  $request->validade;
              $vaucher->save();
            }

            return view('PRF.Admin.cupom_criado', [
                'cupom' => $request->cupom,
            ]);

        } catch(Exception $e){
            return back();
        }
    }

    public function store(Request $request, $id_registration){
        try{
            $vaucher = PrfVauchers::where('code', $request->vaucher)->first();
            $registration = PrfRegistration::find($id_registration);
            if(!$registration){
                    session()->flash('erro', 'Erro ao encontrar inscrição');
                    return back();
            }
            if(!$vaucher){
                session()->flash('erro', 'Código de vaucher não encontrado');
                return back();
            }
            if($vaucher->isCupom){
                if($vaucher->validade){
                    if(date("Y-m-d") <= $vaucher->validade){
                        $registration->prf_vauchers_id = $vaucher->id;
                        $registration->save();
                        session()->flash('success', 'Cupom adicionado com sucesso');
                        return back();
                    } else {
                        error_log(date("Y-m-d"));
                        session()->flash('erro', 'Validade do cupom expirou');
                        return back();
                    }
                } else {
                    $registration->prf_vauchers_id = $vaucher->id;
                    $registration->save();
                    session()->flash('success', 'Cupom adicionado com sucesso');
                    return back();
                }

            } else {
                if($vaucher->prf_registrations()->count() == 1){
                    session()->flash('erro', 'Código de vaucher já em uso');
                    return back();
                }
                if($vaucher->validade){
                    if(date("Y-m-d") <= $vaucher->validade){
                        $registration->prf_vauchers_id = $vaucher->id;
                        $registration->save();
                        session()->flash('success', 'Vaucher adicionado com sucesso');
                        return back();
                    } else {
                        session()->flash('erro', 'Validade do vaucher expirou');
                        return back();
                    }
                } else {
                    $registration->prf_vauchers_id = $vaucher->id;
                    $registration->save();
                    session()->flash('success', 'Vaucher adicionado com sucesso');
                    return back();
                }
            }
        }
        catch(Exception $e){
            session()->flash('erro', 'Erro no sistema, estamos resolvendo');
            return back();
        }
    }
}
