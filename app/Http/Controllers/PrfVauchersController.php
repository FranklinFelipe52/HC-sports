<?php

namespace App\Http\Controllers;

use App\Helpers\CodeVaucherGenerate;
use App\Mail\MeiaConfirmRegistrationMailble;
use App\Models\PrfRegistration;
use App\Models\PrfVauchers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PrfVauchersController extends Controller
{

    public function index(Request $request)
    {
        try {

            $vouchers_and_cupons_query = DB::table('prf_vauchers')
                ->select('prf_vauchers.id', 'prf_vauchers.code', 'prf_vauchers.isCupom', 'prf_vauchers.descricao', 'prf_vauchers.desconto', 'prf_vauchers.validade', 'prf_vauchers.created_at')
                ->addSelect(DB::raw('(SELECT COUNT(*) FROM prf_registrations WHERE prf_registrations.prf_vauchers_id = prf_vauchers.id) as prf_registrations'))
                ->orderBy('prf_vauchers.validade', 'desc');

            if (isset($_GET["s"])) {
                $vouchers_and_cupons_query = $vouchers_and_cupons_query
                    ->where('code', 'LIKE', '%' . $_GET["s"] . '%')
                    ->orWhere('descricao', 'LIKE', '%' . $_GET["s"] . '%');
            }

            $vouchers_and_cupons = $vouchers_and_cupons_query->get();

            return view('PRF.Admin.discounts', [
                'vouchers_and_cupons' => $vouchers_and_cupons,
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Algo deu errado');
            return back();
        }
    }

    public function store_vouchers(Request $request)
    {
        try {
            for ($i = 0; $i < intval($request->quant_voucher); $i++) {
                $code = '';
                do {
                    $verify = true;
                    $code = CodeVaucherGenerate::generate();
                    error_log($code);
                    if (PrfVauchers::where('code', $code)->get()->count() == 0) {
                        $verify = false;
                    }
                } while ($verify);
                $vaucher = new PrfVauchers;
                $vaucher->code = $code;
                $vaucher->isCupom = false;
                $vaucher->descricao = $request->descricao_voucher;
                $vaucher->desconto = floatval($request->desconto_voucher) / 100;
                $vaucher->validade = $request->validade_voucher;
                $vaucher->save();
            }

            return redirect('/admin/discounts');
        } catch (Exception $e) {
            return back();
        }
    }

    public function show_voucher_relatorios()
    {
        try {
            return view('PRF.Admin.vauchers_relatorio');
        } catch (Exception $e) {
            session()->flash('erro', 'Algo deu errado');
            return back();
        }
    }
    public function all_vouchers_get()
    {
        try {
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
                    'desconto' => mb_convert_encoding(mb_strtoupper(($value->desconto * 100) . '%', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                    'validade' => mb_convert_encoding($value->validade ? date('d/m/Y', strtotime($value->validade)) : '', 'ISO-8859-1', "UTF-8")
                ];
                fputcsv($arquivo, $vaucher, ';');
            }
            fclose($arquivo);
            back();
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function vouchers_with_user()
    {
        try {
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
                        'desconto' => mb_convert_encoding(mb_strtoupper(($value->desconto * 100) . '%', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'validade' => mb_convert_encoding($value->validade ? date('d/m/Y', strtotime($value->validade)) : '', 'ISO-8859-1', "UTF-8")
                    ];
                    fputcsv($arquivo, $vaucher, ';');
                }
            }
            fclose($arquivo);
            back();
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function store_cupom(Request $request)
    {
        try {

            $code = $request->code_cupom;
            if (PrfVauchers::where('code', $code)->first()) {
                session()->flash('erro', 'Código já cadastrado');
                return back();
            }


            $vaucher = new PrfVauchers;
            $vaucher->code = $code;
            $vaucher->descricao = $request->descricao_cupom;
            $vaucher->desconto = floatval($request->desconto_cupom) / 100;
            $vaucher->isCupom = true;
            $vaucher->validade = $request->validade_cupom;
            $vaucher->save();

            return view('PRF.Admin.cupom_criado', [
                'cupom' => $vaucher->code,
            ]);

        } catch (Exception $e) {
            session()->flash('erro', 'Erro no sistema, estamos resolvendo');
            return back();
        }
    }

    public function store(Request $request, $id_registration)
    {
        try {
            error_log(CodeVaucherGenerate::delimitador($request->vaucher));
            $vaucher = PrfVauchers::where('code', $request->vaucher)->first();
            $registration = PrfRegistration::find($id_registration);
            if (!$registration) {
                session()->flash('erro', 'Erro ao encontrar inscrição');
                return back();
            }
            if (!$vaucher) {
                $vaucher = PrfVauchers::where('code', CodeVaucherGenerate::delimitador($request->vaucher))->first();
                if (!$vaucher) {
                    session()->flash('erro', 'Código de vaucher não encontrado');
                    return back();
                }

            }
            if ($vaucher->isCupom) {
                if ($vaucher->validade) {
                    if (date("Y-m-d") <= $vaucher->validade) {
                        $registration->prf_vauchers_id = $vaucher->id;
                        $registration->save();
                        session()->flash('success', 'Cupom adicionado com sucesso');


                        if ($vaucher->desconto == 1 && count($registration->tshirts) < 1) {
                            $registration->status_regitration_id = 1;
                            $registration->save();
                            Mail::to($registration->prf_user->email)->send(new MeiaConfirmRegistrationMailble($registration));
                        }

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

                    if ($vaucher->desconto == 1 && count($registration->tshirts) < 1) {
                        $registration->status_regitration_id = 1;
                        $registration->save();
                        Mail::to($registration->prf_user->email)->send(new MeiaConfirmRegistrationMailble($registration));
                    }

                    return back();
                }

            } else {
                if ($vaucher->prf_registrations()->count() == 1) {
                    session()->flash('erro', 'Código de vaucher já em uso');
                    return back();
                }
                if ($vaucher->validade) {
                    if (date("Y-m-d") <= $vaucher->validade) {
                        $registration->prf_vauchers_id = $vaucher->id;
                        $registration->save();
                        session()->flash('success', 'Voucher adicionado com sucesso');

                        if ($vaucher->desconto == 1 && count($registration->tshirts) < 1) {
                            $registration->status_regitration_id = 1;
                            $registration->save();
                            Mail::to($registration->prf_user->email)->send(new MeiaConfirmRegistrationMailble($registration));
                        }

                        return back();
                    } else {
                        session()->flash('erro', 'Validade do vaucher expirou');
                        return back();
                    }
                } else {
                    $registration->prf_vauchers_id = $vaucher->id;
                    $registration->save();
                    session()->flash('success', 'Voucher adicionado com sucesso');

                    if ($vaucher->desconto == 1 && count($registration->tshirts) < 1) {
                        $registration->status_regitration_id = 1;
                        $registration->save();
                        Mail::to($registration->prf_user->email)->send(new MeiaConfirmRegistrationMailble($registration));
                    }

                    return back();
                }
            }
        } catch (Exception $e) {
            session()->flash('erro', 'Erro no sistema, estamos resolvendo');
            return back();
        }
    }

    public function delete(Request $request, $voucher_id)
    {
        try {
            $voucher = PrfVauchers::find($voucher_id);
            $registrations = PrfRegistration::where('prf_vauchers_id', $voucher_id)->get();

            if (count($registrations) > 0) {
                session()->flash('erro', 'Não é possível excluir códigos de desconto que já foram usados.');
                return back();
            }

            $voucher->delete();

            session()->flash('success', 'Código de desconto excluído com sucesso.');
            return back();

        } catch (Exception $e) {
            session()->flash('erro', 'Erro no sistema, estamos resolvendo');
            return back();
        }
    }
}
