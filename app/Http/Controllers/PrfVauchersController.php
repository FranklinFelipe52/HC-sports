<?php

namespace App\Http\Controllers;

use App\Helpers\CodeVaucherGenerate;
use App\Models\PrfAdmin;
use App\Models\PrfAdminLog;
use App\Models\PrfRegistration;
use App\Models\PrfVauchers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
            header('Content-Disposition: attachment; filename=vouchers_seminario.csv');

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
            header('Content-Disposition: attachment; filename=vouchers_utilizados_seminario.csv');

            $arquivo = fopen("php://output", "w");

            $cabecalho = [
                mb_convert_encoding(mb_strtoupper('Usuário', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Código', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Descrição', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Desconto', 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                mb_convert_encoding(mb_strtoupper('Validade', 'UTF-8'), 'ISO-8859-1', "UTF-8")
            ];
            fputcsv($arquivo, $cabecalho, ';');
            foreach ($vauchers as $value) {
                foreach ($value->prf_registrations as $registration) {
                    $vaucher = [
                        'usuario' => mb_convert_encoding(mb_strtoupper($registration->prf_user->email, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'codigo' => mb_convert_encoding(mb_strtoupper($value->code, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
                        'descricao' => mb_convert_encoding(mb_strtoupper($value->descricao, 'UTF-8'), 'ISO-8859-1', "UTF-8"),
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

                        if ($vaucher->desconto == 1) {
                            $registration->status_regitration_id = 1;
                            $registration->save();
                            session()->flash('success', 'Cupom de 100% adicionado com sucesso, inscrição confirmada!');
                            return back();
                        } else {
                            session()->flash('success', 'Cupom adicionado com sucesso');
                            return back();
                        }
                    } else {
                        error_log(date("Y-m-d"));
                        session()->flash('erro', 'Validade do cupom expirou');
                        return back();
                    }
                } else {
                    $registration->prf_vauchers_id = $vaucher->id;
                    $registration->save();

                    if ($vaucher->desconto == 1) {
                        $registration->status_regitration_id = 1;
                        $registration->save();
                        session()->flash('success', 'Cupom com desconto de 100% adicionado com sucesso, inscrição confirmada!');
                        return back();
                    } else {
                        session()->flash('success', 'Cupom adicionado com sucesso');
                        return back();
                    }
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

                        if ($vaucher->desconto == 1) {
                            $registration->status_regitration_id = 1;
                            $registration->save();
                            session()->flash('success', 'Voucher com desconto de 100% adicionado com sucesso, inscrição confirmada!');
                            return redirect('/dashboard');
                        } else {
                            session()->flash('success', 'Voucher adicionado com sucesso');
                            return redirect('/dashboard');
                        }

                    } else {
                        session()->flash('erro', 'Validade do vaucher expirou');
                        return redirect('/dashboard');
                    }
                } else {
                    $registration->prf_vauchers_id = $vaucher->id;
                    $registration->save();

                    if ($vaucher->desconto == 1) {
                        $registration->status_regitration_id = 1;
                        $registration->save();
                        session()->flash('success', 'Voucher com desconto de 100% adicionado com sucesso, inscrição confirmada!');
                        return redirect('/dashboard');
                    } else {
                        session()->flash('success', 'Voucher adicionado com sucesso');
                        return redirect('/dashboard');
                    }
                }
            }
        } catch (Exception $e) {
            session()->flash('erro', 'Um erro aconteceu, não foi possível concluir sua ação.');
            return back();
        }
    }

    public function delete(Request $request, $voucher_id)
    {
        try {
            $voucher = PrfVauchers::find($voucher_id);
            $admin = PrfAdmin::find($request->session()->get('admin')->id);


            if (count($voucher->prf_registrations) == 0) {
                $voucher->delete();

                $admin_log = new PrfAdminLog;
                $admin_log->prf_admin_id = $admin->id;
                $admin_log->type_actions_admin_id = 3;
                $admin_log->description = 'Excluiu o voucher de id #'.$voucher_id ;
                $admin_log->save();


                session()->flash('success', 'Excluiu o código de desconto com sucesso.');
                return redirect('/admin/discounts');
            } else {

                session()->flash('erro', 'Não é possível excluír um código que já foi utilizado.');
                return redirect('/admin/discounts');
            }

        } catch (Exception $e) {
            session()->flash('erro', 'Um erro aconteceu, não foi possível concluir sua ação.');
            return redirect('/admin/discounts');
        }

    }
}
