<?php

namespace App\Http\Controllers;

use App\Helpers\AgeBetweenDates;
use App\Helpers\VerifyRegistration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Mail\RegistrationDelete;
use App\Mail\RegistrationMail;
use App\Models\ActionsAdmin;
use App\Models\Address;
use App\Models\Admin;
use App\Models\FederativeUnit;
use App\Models\Modalities;
use App\Models\modalities_category;
use App\Models\Payment;
use App\Models\registration;
use App\Models\sub_categorys;
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
            $user = User::where('cpf', preg_replace( '/[^0-9]/is', '', $request->cpf))->first();
            $category_id = null;

            if(!$modalidade){
                return back();
            }
            if($admin->rule->id == 1){
                if(!$request->uf){
                    return back();
                }
            }
            if($modalidade->mode_modalities->id == 1){

                $category = $modalidade->modalities_categorys()->first();
                $category_id = $category->id;

                if($user){
                    if(VerifyRegistration::verifyConfirmRegistration($user)){
                        return back()->with('erro', 'Realize o pagamento das inscrições pendentes para criar uma nova inscrição');
                    }
                    if(VerifyRegistration::verifyUserIntoModalities($user, $category)){
                        return back()->with('erro','Usuário já está inscrito nessa modalidade');
                    }
                    if( VerifyRegistration::verifyUserLimitRegistrations($user, $modalidade)){
                        return back()->with('erro', 'O usuario já tem 2 inscrições ativas');
                    }
                }
                //if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $admin)){
                //    return back()->with('erro', 'Não existe mais vagas para essa modalidade');
                //}
                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category, $admin)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo masculino nessa modalidade');
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category, $admin)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo feminino nessa modalidade');
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $request->date_nasc, $modalidade)){
                    return back()->with('erro', "Desculpe, mas o minimo de idade para a modalidade ".$modalidade->nome." é $category->min_year anos");
                }

            }elseif($modalidade->mode_modalities->id == 2){
                if($user){
                    if(VerifyRegistration::verifyConfirmRegistration($user)){
                        return back()->with('erro', 'Realize o pagamento das inscrições pendentes para criar uma nova inscrição');
                    }
                    foreach ($user->registrations as $registration) {
                        if($registration->modalities->id == $modalidade->id){
                            return back()->with('erro', 'Usuário já tem inscrição nessa modalidade');
                        }
                    }

                    if( VerifyRegistration::verifyUserLimitRegistrations($user, $modalidade)){
                        return back()->with('erro', 'O usuario já tem 2 inscrições ativas');
                    }
                }

                foreach ($request->category  as $category) {
                $category = modalities_category::find($category);

                if(!$category){
                    return back();
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $admin)){
                    return back()->with('erro', "Não existe mais vagas para categoria $category->nome");
                }
                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category, $admin)){
                        return  back()->with('erro', "Não existe mais vagas para usuários do sexo masculino para categoria $category->nome");
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category, $admin)){
                        return  back()->with('erro', "Não existe mais vagas para usuários do sexo feminino para categoria $category->nome");
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $request->date_nasc, $modalidade)){
                    return back()->with('erro', "Desculpe, mas o minimo de idade para a categoria ".$category->nome." é $category->min_year anos");
                }
                }

            } else {
                $category = modalities_category::find($request->category);
                $category_id = $category->id;
                error_log($category);
                if(!$category){
                    return back();
                }

                if($user){
                    if(VerifyRegistration::verifyConfirmRegistration($user)){
                        return back()->with('erro', 'Este atleta está com pagamento pendente. Antes de realizar uma nova inscrição é preciso realizar o pagamento da inscrição anterior.');
                    }
                    if(VerifyRegistration::verifyUserIntoModalities($user, $category)){
                        return back()->with('erro','Usuário já está inscrito nessa categoria');
                    }
                    if( VerifyRegistration::verifyUserLimitRegistrations($user, $modalidade)){
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
                    if(VerifyRegistration::verifyModalitiesLimitMan($category, $admin)){
                        return  back()->with('erro', 'Não existe mais vagas para usuários do sexo masculino nessa modalidade');
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category, $admin)){
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
                $addres->federative_unit_id = $admin->rule->id == 1 ? $request->uf : $admin->federativeUnit->id;
                $addres->user_id = $user->id;
                $addres->save();
                $action_admin = new ActionsAdmin;
                $action_admin->type_actions_admin_id = 6;
                $action_admin->admin_id = $admin->id;
                $action_admin->description = 'ADM '.$admin->nome_completo.' cadastrou um novo atleta com CPF: '.preg_replace( '/[^0-9]/is', '', $user->cpf);
                $action_admin->save();
            }


            $registration = new registration;
            $payment = new Payment;
            $registration->user_id = $user->id;
            $registration->is_pcd = $request->pcd ? 1 : 0;
            $registration->sub_categorys_id = $request->sub_category ? $request->sub_category : null;
            $registration->modalities_id = $modalidade->id;
            $registration->modalities_category_id = $category_id;
            $registration->status_regitration_id = $request->payment == 1 ? 1 : 3;
            $registration->type_payment_id = $request->payment;
            if(Count($modalidade->ranges) != 0){
                $registration->range_id = $request->range;
            }
            $registration->save();
            if($modalidade->mode_modalities->id == 2){
                foreach ($request->category  as $category) {
                    $category = modalities_category::find($category);
                    $registration->modalities_categorys()->save($category);
                }
            }

            $payment->registration_id = $registration->id;
            $payment->status_payment_id = $registration->status_regitration_id == 1 ? 1 : 3;
            $payment->save();



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
        Mail::to($request->email)->send(new RegistrationMail($link, $registration));

            return redirect("/admin/modalidade/{$modalidade->id}");

        } catch(Exception $e){
            return back();
        }
    }


    public function delete(Request $request, $id){
        try{
           $registration = registration::find($id);
           $admin = $request->session()->get('admin');
           if(!$admin){

               return back();
            }
            if (!$registration){

                return back();
            }

            if($registration->status_regitration->id == 1){
                $registration_recent = $registration->user->registrations()->latest()->first();
                if( $registration_recent == $registration){
                    if($registration_recent->type_payment->id == 2){
                        return back();
                    }
                } else {
                    return back();
                }
            }

            $payment = $registration->payment;

            if (!$payment) {
                return back();
            }

            $user = $registration->user;
            $payment->delete();
            $registration->delete();
            
            $action_admin = new ActionsAdmin;
            $action_admin->type_actions_admin_id = 5;
            $action_admin->admin_id = $admin->id;
            $action_admin->description = 'Deletou a inscrição do atleta '.$registration->user->nome_completo.' na modalidade '.$registration->modalities->nome;
            $action_admin->save();
            Mail::to($user->email)->send(new RegistrationDelete($registration));
            return redirect("/admin/users/$user->id");
        } catch(Exception $e){
            return redirect("/admin/users/$user->id");
        }
    }

    public function create(Request $request, $id){
        try{
            $modalidade = Modalities::find($id);
            $type_payments = type_payment::all();
            $sub_categorys = sub_categorys::all();


            if(!$modalidade){
                return back();
            }
            if($modalidade->id == 9 || $modalidade->id == 10 ){
                if(!isset($_GET['gender'])){
                    error_log('entrou aqui 1');
                    return back();
                } else {
                    if(!($_GET['gender'] == "M" || $_GET['gender'] == "F")){
                        error_log('entrou aqui 2');
                        return back();
                    }
                }
            }

            return view('Admin.registrations_create', [
                'modalidade' => $modalidade,
                'type_payments' => $type_payments,
                'federative_units' => DB::table('federative_units')->orderBy('initials', 'asc')->get(),
                'sub_categorys' => $sub_categorys
            ]);

        }catch(Exception $e){
            return back();
        }
    }
}
