<?php

namespace App\Http\Controllers;

use App\Helpers\AgeBetweenDates;
use App\Helpers\VerifyRegistration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Mail\RegistrationMail;
use App\Models\Address;
use App\Models\FederativeUnit;
use App\Models\Modalities;
use App\Models\modalities_category;
use App\Models\registration;
use App\Models\type_payment;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegistrationsAdminController extends Controller
{
    public function show(Request $request, $id)
    {
        try {
            $registration = registration::find($id);

            return view('Admin.registration', [
                'registration'  => $registration
            ]);
        } catch (Exception $e) {
            return back();
        }
    }

    public function store(StoreRegistrationRequest $request, $id){
        try{

            $modalidade = Modalities::find($id);
            $admin = $request->session()->get('admin');
            $user = User::where('email', $request->email)->first();
            
            if(!$modalidade){
                return back();
            }
            if($modalidade->mode_modalities->id == 1){
                $category = $modalidade->modalities_categorys()->first();
                
                if($user){
                    if(VerifyRegistration::verifyUserIntoModalities($user, $category)){
                        return back()->with('erro','Usuário já está inscrito nessa modalidade');
                    }
                    if( VerifyRegistration::verifyUserLimitRegistrations($user)){
                        return back()->with('erro', 'O usuario já tem 2 inscrições ativas');
                    }
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $admin)){
                    return back()->with('erro', 'Não existe mais vagas para essa modalidade');
                }
                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo masculino nessa modalidade');
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo feminino nessa modalidade');
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $request->date_nasc, $modalidade)){
                    return back()->with('erro', "Desculpe, mas o minimo de idade para a modalidade ".$modalidade->nome." é $category->min_year anos");
                }
                 
            }elseif($modalidade->mode_modalities->id == 2){
                $category = modalities_category::find($request->category);
                
                if(!$category){
                    return back();
                }
                if($user){
                    if(VerifyRegistration::verifyUserIntoModalities($user, $category)){
                        return back()->with('erro','Usuário já está inscrito nessa categoria');
                    }
                    if( VerifyRegistration::verifyUserLimitRegistrations($user)){
                        return back()->with('erro', 'O usuario já tem 2 inscrições ativas');
                    }
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $admin)){
                    return back()->with('erro', 'Não existe mais vagas para essa modalidade');
                }
                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo masculino nessa modalidade');
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo feminino nessa modalidade');
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $request->date_nasc, $modalidade)){
                    return back()->with('erro', "Desculpe, mas o minimo de idade para a categoria ".$category->nome." é $category->min_year anos");
                }
            } else {
                $category = modalities_category::find($request->category);
                
                if(!$category){
                    return back();
                }
                
                if($user){
                    if(VerifyRegistration::verifyUserIntoModalities($user, $category)){
                        return back()->with('erro','Usuário já está inscrito nessa categoria');
                    }
                    if( VerifyRegistration::verifyUserLimitRegistrations($user)){
                        return back()->with('erro', 'O usuario já tem 2 inscrições ativas');
                    }
                    foreach ($user->registrations as $registration) {
                        if($registration->modalities->id == $modalidade->id){
                            return back()->with('erro', 'Usuário já tem inscrição nessa modalidade');
                        }
                    }
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $admin)){
                    return back()->with('erro', 'Não existe mais vagas para essa modalidade');
                }
                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo masculino nessa modalidade');
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo feminino nessa modalidade');
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $request->date_nasc, $modalidade)){
                    return back()->with('erro', "Desculpe, mas o minimo de idade para a categoria ".$category->nome." é $category->min_year anos");
                }
                
            }
           
            if(!$user){
                $user = new User;
                $user->email = $request->email;
                $user->cpf = preg_replace( '/[^0-9]/is', '', $request->cpf);
                $user->data_nasc = $request->date_nasc;
                $user->sexo = $request->sexo;
                $user->registered = false;
                $user->save();
                $addres = new Address();
                $addres->federative_unit_id = $admin->federativeUnit->id;
                $addres->user_id = $user->id;
                $addres->save();
            }
            $registration = new registration;
            $registration->user_id = $user->id;
            $registration->modalities_id = $modalidade->id;
            $registration->modalities_category_id = $modalidade->mode_modalities->id == 1 ? $modalidade->modalities_categorys()->first()->id : $request->category;
            $registration->status_regitration_id = $request->payment == 1 ? 1 : 3;
            $registration->type_payment_id = $request->payment;
            if(Count($modalidade->ranges) != 0){
                $registration->range_id = $request->range;
            }
            $registration->save();

        $payload = [
            "email" => $user->email,
            "date_nasc" => $user->data_nasc,
            "cpf" => $user->cpf,
            "sexo" => $user->sexo,
            "uf" => $admin->federativeUnit->initials,
            "exp" => time() + (60 * 60 * 24 * 30),
        ];
        $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
        $host = request()->getSchemeAndHttpHost();
        $link = "{$host}/confirm_registration/{$jwt}";
        Mail::to($request->email)->send(new RegistrationMail($link));

            return redirect("/admin/modalidade/{$modalidade->id}");

        } catch(Exception $e){
            return $e;
        }
    }

    public function registration(Request $request, $id)
    {
        try {
            $modalidade = Modalities::find($id);
            $admin = $request->session()->get('admin');


            if ($modalidade) {
                $s = isset($_GET["s"]) ? $_GET["s"] : '';
                $uf = isset($_GET["uf"]) ? $_GET["uf"] : '';
                error_log($s);
                error_log($uf);

                if ($admin->rule->id == 1) {
                    $registrations = DB::table('registrations')
                        ->join('status_regitrations', 'registrations.status_regitration_id', '=', 'status_regitrations.id')
                        ->join('modalities', 'registrations.modalities_id', '=', 'modalities.id')
                        ->where('modalities_id', $modalidade->id)
                        ->join('users', 'registrations.user_id', '=', 'users.id')
                        ->join('addresses', 'addresses.user_id', '=', 'users.id')
                        ->join('federative_units', 'addresses.federative_unit_id', '=', 'federative_units.id')
                        ->join('payments', 'payments.id', '=', 'registrations.payment_id')
                        ->join('status_payments', 'status_payments.id', '=', 'payments.status_payment_id')
                        ->select('registrations.id', 'users.nome_completo', 'users.cpf', 'modalities.nome', 'addresses.federative_unit_id', 'status_regitrations.status as status_registration', 'modalities.modalities_type_id' , 'federative_units.initials', 'status_payments.status')
                        ->where('nome_completo', 'LIKE', '%'.$s.'%');
                        $registrations = isset($_GET["uf"]) ? $registrations->where('federative_unit_id', '=', $_GET["uf"])->get() : $registrations->get();
                        error_log($registrations);
                } else {
                    $registrations = DB::table('registrations')
                            ->join('status_regitrations', 'registrations.status_regitration_id', '=', 'status_regitrations.id')
                            ->join('modalities', 'registrations.modalities_id', '=', 'modalities.id')
                            ->where('modalities_id', $modalidade->id)
                            ->join('users', 'registrations.user_id', '=', 'users.id')
                            ->join('addresses', 'addresses.user_id', '=', 'users.id')
                            ->join('federative_units', 'addresses.federative_unit_id', '=', 'federative_units.id')
                            ->join('payments', 'payments.id', '=', 'registrations.payment_id')
                            ->join('status_payments', 'status_payments.id', '=', 'payments.status_payment_id')
                            ->where('federative_unit_id', $admin->federative_unit_id)
                            ->select('registrations.id', 'users.nome_completo', 'users.cpf', 'modalities.nome', 'addresses.federative_unit_id', 'federative_units.initials', 'status_regitrations.status as status_registration', 'status_payments.status')
                            ->where('nome_completo', 'LIKE', '%' .$s. '%')
                            ->get();
                }
            }


            return view('Admin.single_registration', [
                'registrations'  => $registrations,
                'modalidade' => $modalidade,
                'federative_units' => FederativeUnit::all()
            ]);
        } catch (Exception $e) {
            return $e;
        }
    }

    public function valid_registration(Request $request){
        try{
            if(!$request->checkbox || Count($request->checkbox) == 0){
                return back()->with('erro', "Nenhuma inscrição foi selecionada");
            }

            foreach ($request->checkbox as $value) {
                $registration = registration::find($value);
                if($registration && $registration->status_regitration->id == 1){
                    $registration->status_regitration_id = 2;
                    $registration->save();
                }
                
            }

            return redirect()->back();
        } catch(Exception $e){
            return back();
        }
    }

    public function create(Request $request, $id){
        try{
            $modalidade = Modalities::find($id);
            $type_payments = type_payment::all();

            if(!$modalidade){
                return back();
            }

            return view('Admin.registrations_create', [
                'modalidade' => $modalidade,
                'type_payments' => $type_payments
            ]);

        }catch(Exception $e){
            return $e;
        }
    }
}
