<?php

namespace App\Http\Controllers;

use App\Helpers\ColumnsCreateReports;
use App\Mail\ConfirmRegistrationRace;
use App\Mail\ConfirmUser;
use App\Models\registration;
use App\Models\status_regitration;
use App\Models\User;
use DateTime;
use Exception;
use FunctionsTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReportsController extends Controller
{

    public function create(Request $request)
    {
        try {


            if (!($request->session()->get('admin')->rule->id == 1)) {
                session()->flash('erro', 'Adm não é geral.');
                return back();
            }

            $date_oldest_registration =  date("Y-m-d", strtotime(registration::oldest()->first()->created_at));
            return view('Admin.reports', [
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get(),
                'status' => status_regitration::all(),
                'date_start_min' =>  $date_oldest_registration,
                'date_start_max' =>  date("Y-m-d", strtotime('-1 days')),
                'date_end_min' => date_format(date_modify(new DateTime($date_oldest_registration), '+1 days'), 'Y-m-d'),
                'date_end_max' =>  date("Y-m-d")
            ]);
        } catch (Exception $e) {
            error_log($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function Store(Request $request)
    {
        try {
            if ($request->date_end && !$request->date_start) {
                error_log('erro date entry');
                session()->flash('erro', 'Para obter o intervalo, digite a data de inicio.');
                return back();
            }




            $array_registrations = [];
            $registrations = registration::where('modalities_id', '<>', 11)->join('addresses', 'addresses.user_id', 'registrations.user_id')
                ->select('registrations.id', 'registrations.user_id', 'registrations.modalities_category_id', 'registrations.modalities_id', 'registrations.range_id', 'registrations.status_regitration_id', 'registrations.type_payment_id', 'registrations.created_at', 'registrations.is_pcd', 'registrations.sub_categorys_id', 'addresses.federative_unit_id');

            if ($request->date_start) {
                if ($request->date_end) {
                    $registrations = $registrations->whereBetween('registrations.created_at', [$request->date_start, $request->date_end]);
                } else {
                    $registrations = $registrations->whereBetween('registrations.created_at', [$request->date_start, date("Y-m-d H:i:s")]);
                }
            }
            if ($request->uf) {
                $registrations = $registrations->where('federative_unit_id', $request->uf);
            }

            if ($request->status) {
                $registrations = $registrations->where('status_regitration_id', $request->status);
            }
            $registrations = $registrations->get();


            foreach ($registrations as $registration) {

                array_push($array_registrations, ColumnsCreateReports::createColumns($request->colunas, $registration));
            }
            $registrations = registration::where('modalities_id', 11)->join('natacao_categorias', 'natacao_categorias.registration_id', 'registrations.id')->join('addresses', 'addresses.user_id', 'registrations.user_id')
                ->select('registrations.id', 'registrations.user_id', 'natacao_categorias.modalities_category_id', 'registrations.modalities_id', 'registrations.range_id', 'registrations.status_regitration_id', 'registrations.type_payment_id', 'registrations.created_at', 'registrations.is_pcd', 'registrations.sub_categorys_id', 'addresses.federative_unit_id');

            if ($request->date_start) {
                if ($request->date_end) {
                    $registrations = $registrations->whereBetween('registrations.created_at', [$request->date_start, $request->date_end]);
                } else {
                    $registrations = $registrations->whereBetween('registrations.created_at', [$request->date_start, date("Y-m-d H:i:s")]);
                }
            }
            if ($request->uf) {
                $registrations = $registrations->where('federative_unit_id', $request->uf);
            }

            if ($request->status) {
                $registrations = $registrations->where('status_regitration_id', $request->status);
            }
            $registrations = $registrations->get();
            foreach ($registrations as $registration) {
                array_push($array_registrations, ColumnsCreateReports::createColumns($request->colunas, $registration));
            }

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=Relatório_inscrições.csv');

            $arquivo = fopen("php://output", "w");
            $cabecalho = ColumnsCreateReports::createColumnsHeader($request->colunas);

            fputcsv($arquivo, $cabecalho, ';');
            $key_values = array_column($array_registrations, 'Nome_completo');
            array_multisort($key_values, SORT_ASC, $array_registrations);
            foreach ($array_registrations as $value) {
                fputcsv($arquivo, $value, ';');
            }
            fclose($arquivo);
            back();
        } catch (Exception $e) {
            error_log($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function scriptUserss(){
        try{
            $users = User::where('registered', 0)->get();
            foreach ($users as $user) {
                $senha = 'CAA'.$user->address->federativeUnit->initials;
                $user->nome_completo = $user->nome_completo ? $user->nome_completo : 'Nome';
                $user->password = Hash::make($senha);
                $user->registered = 1;
                $user->save();
                Mail::to($user->email)->send(new ConfirmUser($user, $senha));
            }
            return redirect('/admin/dashboard');
        } catch (Exception $e){
            dd($e);
        }
    }
    public function scriptUsers(){
        try{
            $emails = ['aline.040197@gmail.com',
            'marinaribeirodealmeida@hotmail.com',
            'adervaladv@hotmail.com',
            'henryque.resende@gmail.com',
            'fabiofariasantos.adv@gmail.com',
            'gustavodeassissouza@gmail.com',
            'ludmillla@hotmail.com',
            'joicekellysoares@gmail.com',
            'advogado.heliomorato@gmail.com',
            'doutorajuliane@gmail.com',
            'paulohenrique@pinheiroadvogados.net',
            'luhelenafranca@hotmail.com',
            'vilmarprocopio@outlook.com',
            'caionaves2@gmail.com',
            'francoalmeidaadv@gmail.com',
            'eduardololli.adv@gmail.com',
            'silvestre132@gmail.com',
            'jgadv@live.com',
            'gabriellabandeira12229@gmail.com',
            'amaralbritto@gmail.com',
            'claudio.dias@peixotoediasadvogados.com',
            'claudineia.pereira@jacocoelho.com.br',
            'tomaz963@hotmail.com',
            'ernane.nardelli@gmail.com',
            'romulo.almeida@jacocoelho.com.br',
            'mariacarolina.balestra@jacocoelho.com.br',
            'tarcilla.faria@jacocoelho.com.br',
            'ludmilla.coelho@jacocoelho.com.br',
            'karynnemayer@gmail.com',
            'matheus.coelho@jacocoelho.com.br',
            'joicekellysoares@gmail.com',
            'lucimer.coelho@jacocoelho.com.br',
            'ferdinand_felipe@hotmail.com',
            'danilorodriguesdesouza7@gmail.com',
            'noiltodr@hotmail.com',
            'csizervincio@gmail.com',
            'gesnersouto@gmail.com',
            'rafaelamorimsa@gmail.com',
            'thalitamonferrari@gmail.com',
            'domerviljunior@gmail.com',
            'myllenasouzalins@gmail.com',
            'talitahayasaki@gmail.com',
            'paula.andreia@ahbnadvogados.com.br',
            'claudiodelano@gmail.com',
            'isabellafb3braga@gmail.com',
            'ivanalmascarenhas@gmail.com',
            'filipe.denki@laramartinsadvogados.com.br',
            'joaogabrielsts@gmail.com',
            'davigualbertoadv@hotmail.com',
            'fabio.aso@gmail.com',
            'thiagohenriqueresende@gmail.com',
            'laraavila95@gmail.com',
            'breno@silvadiasadvogados.com.br',
            'jessica-cms@live.com',
            'valeriaanzai.adv@gmail.com',
            'heitorhourani03@gmail.com',
            'carlafernanda245@gmail.com',
            'adv.kahikonofre@hotmail.com',
            'neto.ademario@gmail.com',
            'biancadap@hotmail.com',
            'fabiofariasantos.adv@gmail.com',
            'luciana@recordtvgoias.com.br',
            'henrique@lola.beer',
            'alexandre@bandnewsgoiania.com.br',
            'elianaqueirozz@hotmail.com',
            'alexaugusto.adv@gmail.com',
            'elisamarodrigues.adv@gmail.com',
            'gabrieldiasmota99@gmail.com',
            'cesarcg@ymail.com',
            'titiorules@gmail.com',
            'adangone@hotmail.com',
            'gustavofat1996@gmail.com',
            'jsp.paiva@gmail.com',
            'gustavocastroadvogado@gmail.com',
            'deborateodoroalmeida@gmail.com',
            'dramonicaleite@hotmail.com',
            'nathaliacaetano1413@gmail.com',
            'joaopedrojube@hotmail.com',
            'euripedes.emiliano@hotmail.com',
            'marianabd@hotmail.com',
            'natygobbo@hotmail.com',
            'ativa.fernando@hotmail.com',
            'anacfbrandao24@gmail.com',
            'cyncardoso23@gmail.com',
            'nathalia.fds1920@gmail.com',
            'adv.pedrobispo@gmail.com',
            'pedropaulovicentee@gmail.com',
            'felipe.belchior12@gmail.com',
            'gabreelcl@hotmail.com',
            'cesar_breno@msn.com',
            'lucimarlelesadv@gmail.com',
            'mikhaelmoraes@gmail.com',
            'lulu_portella@hotmail.com',
            'leticiabeatrizmg@hotmail.com',
            'adrianocap3i13@yahoo.com.br',
            'adv.juniorribeiro@gmail.com',
            'ludmilla.coelho@jacocoelho.com.br',
            'larissagodoysinha.adv@gmail.com',
            'juhliocsl@gmail.com',
            'paulormdecaris28@gmail.com',
            'peaga0803@gmail.com',
            'filipebarbosa.jornalista@gmail.com',
            'wpasquetto@gmail.com',
            'matheus.coelho@jacocoelho.com.br',
            'ladetos@gmail.com',
            'alef.moraes@hotmail.com.br',
            'franklin.felipe158@gmail.com',
            'cesimar.xavier@navi.ifrn.edu.br'];

            foreach ($emails as $email) {
                Mail::to($email)->send(new ConfirmRegistrationRace());
            }
            return redirect('/admin/dashboard');

        } catch (Exception $e){
            dd($e);
        }
    }
    
}
