<?php

namespace App\Http\Controllers;

use App\Helpers\CodeVaucherGenerate;
use App\Models\PrfRegistration;
use App\Models\PrfVauchers;
use Exception;
use Illuminate\Http\Request;

class PrfVauchersController extends Controller
{
    public function create_voucher(Request $request) {
        try {
            return view('PRF.Admin.criar_voucher');
        } catch(Exception $e) {
            session()->flash('erro', 'Algo deu errado');
            return back();
        }
    }

    public function store_vouchers(Request $request){
        try{
            for($i = 0; $i < intval($request->quant); $i++){
                $code = '';
                do {
                    $verify = true;
                    $code = CodeVaucherGenerate::generate();
                    error_log($code);
                    if(PrfVauchers::where('code', $code)->get()->count() == 0){
                        $verify = false;
                    }
                } while($verify);
              $vaucher = new PrfVauchers;
              $vaucher->code = $code;
              $vaucher->isCupom = false;
              $vaucher->descricao = $request->descricao;
              $vaucher->desconto = floatval($request->desconto) / 100;
              $vaucher->validade =  $request->validade;
              $vaucher->save();
            }

            return redirect('/');
        }
        catch(Exception $e){
            return back();
        }
    }

    public function show_voucher_relatorios() {
        try{
            return view('PRF.Admin.vauchers_relatorio');
        } catch(Exception $e){
            session()->flash('erro', 'Algo deu errado');
            return back();
        }
    }
    public function all_vouchers_get(){
        try{
            $vauchers = PrfVauchers::all();
            
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_Todos_Vauchers.csv');
            
            $arquivo = fopen("php://output", "w");
            
            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Código', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Descrição', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Desconto', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Validade', 'UTF-8'), 'ISO-8859-1', "UTF-8")
            ];
            fputcsv($arquivo, $cabecalho, ';');
            error_log($vauchers);
            foreach ($vauchers as $value) {
                $vaucher = [
                    'codigo' => mb_convert_encoding(mb_strtoupper($value->code, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'descricao' => mb_convert_encoding(mb_strtoupper($value->descricao, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'desconto' =>  mb_convert_encoding(mb_strtoupper(($value->desconto*100).'%', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'validade' => mb_convert_encoding($value->validade ? date('d/m/Y', strtotime($value->validade)): '', 'ISO-8859-1', "UTF-8")
                ];
                fputcsv($arquivo, $vaucher, ';');
            }
            fclose($arquivo);
            back();
        } catch(Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function vouchers_with_user(){
        try{
            $vauchers = PrfVauchers::all();
            
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_Todos_Vauchers.csv');
            
            $arquivo = fopen("php://output", "w");
            
            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Código', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Atleta', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Desconto', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Validade', 'UTF-8'), 'ISO-8859-1', "UTF-8")
            ];
            fputcsv($arquivo, $cabecalho, ';');
            foreach ($vauchers as $value) {
                foreach ($value->prf_registrations as $registration) {
                    $vaucher = [
                        'codigo' => mb_convert_encoding(mb_strtoupper($value->code, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'atleta' => mb_convert_encoding(mb_strtoupper($registration->prf_user->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'desconto' =>  mb_convert_encoding(mb_strtoupper(($value->desconto*100).'%', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'validade' => mb_convert_encoding($value->validade ? date('d/m/Y', strtotime($value->validade)): '', 'ISO-8859-1', "UTF-8")
                    ];
                    fputcsv($arquivo, $vaucher, ';');
                }
            }
            fclose($arquivo);
            back();
        } catch(Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
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
                
                    $code = $request->code;
                    if(PrfVauchers::where('code', $code)->first()){
                        session()->flash('erro', 'Código já cadastrado');
                        return back();
                    }
                   
               
              $vaucher = new PrfVauchers;
              $vaucher->code = $code;
              $vaucher->descricao = $request->descricao;
              $vaucher->desconto = floatval($request->desconto) / 100;
              $vaucher->isCupom = true;
              $vaucher->validade =  $request->validade;
              $vaucher->save();
            
            return view('PRF.Admin.cupom_criado', [
                'cupom' => $vaucher->code,
            ]);

        } catch(Exception $e){
            session()->flash('erro', 'Erro no sistema, estamos resolvendo');
            return back();
        }
    }

    public function store(Request $request, $id_registration){
        try{
            error_log(CodeVaucherGenerate::delimitador($request->vaucher));
            $vaucher = PrfVauchers::where('code', $request->vaucher)->first();
            $registration = PrfRegistration::find($id_registration);
            if(!$registration){
                    session()->flash('erro', 'Erro ao encontrar inscrição');
                    return back();
            }
            if(!$vaucher){
                $vaucher = PrfVauchers::where('code', CodeVaucherGenerate::delimitador($request->vaucher))->first();
                if(!$vaucher){
                    session()->flash('erro', 'Código de vaucher não encontrado');
                    return back();
                }
                
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
