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
use Illuminate\Support\Facades\Log;
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
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function store(StoreRegistrationRequest $request, $id){
        try{
            if($request->session()->get('admin')->rule->id != 1){
                session()->flash('erro', 'Inscrições encerradas.');
                return back();
            }
           
            
            $modalidade = Modalities::find($id);
            $admin = $request->session()->get('admin');
            $user = User::where('cpf', preg_replace( '/[^0-9]/is', '', $request->cpf))->first();
            $category_id = null;
            $federativeUnit = $admin->federativeUnit->id;

            if(!$user && User::where('email', $request->email)->first()){
                session()->flash('erro', 'Já existe um atleta com esse email');
                return back()->withInput();
            }

            if(!$modalidade){
                return back();
            }
            if($admin->rule->id == 1){
                if(!$request->uf){
                    return back();
                }
                $federativeUnit = $request->uf;
            }
            if(strlen($request->phone_number) < 13 ){
                session()->flash('erro', 'Número inválido, digite novamente');
                    return back()->withInput();
            }


            if($modalidade->mode_modalities->id == 1){

                $category = $modalidade->modalities_categorys()->first();
                $category_id = $category->id;

                if($user){
                    if(VerifyRegistration::verifyConfirmRegistration($user)){
                        session()->flash('erro', 'Realize o pagamento das inscrições pendentes para criar uma nova inscrição');
                        return back()->withInput();
                    }
                    if(VerifyRegistration::verifyUserIntoModalities($user, $category)){
                        session()->flash('erro', 'Usuário já está inscrito nessa modalidade');
                        return back()->withInput();
                    }
                    if( VerifyRegistration::verifyUserLimitRegistrations($user, $modalidade)){
                        session()->flash('erro', 'O usuario já tem 2 inscrições ativas');
                        return back()->withInput();
                    }
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $federativeUnit)){
                    session()->flash('erro', 'Não existe mais vagas para essa modalidade');
                    return back()->withInput();
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccional($category, $federativeUnit)){
                    session()->flash('erro', 'Não existe mais vagas para essa modalidade na sua seccional');
                    return back()->withInput();
                }
                if($request->range){
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeMan($category, $request->range, $federativeUnit)){
                        session()->flash('erro', "Não existe mais vagas masculinas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeWomen($category, $request->range, $federativeUnit)){
                        session()->flash('erro', "Não existe mais vagas femininas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                }


                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category, $federativeUnit)){
                        session()->flash('erro', 'Não existe mais vagas para usuários do sexo masculino nessa modalidade');
                        return back()->withInput();
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category, $federativeUnit)){
                        session()->flash('erro', 'Não existe mais vagas para usuários do sexo feminino nessa modalidade');
                        return back()->withInput();
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $request->date_nasc, $modalidade, $federativeUnit)){
                    session()->flash('erro', "Desculpe, mas o minimo de idade para a modalidade ".$modalidade->nome." é $category->min_year anos");
                    return back()->withInput();
                }

            }elseif($modalidade->mode_modalities->id == 2){
                if($user){
                    if(VerifyRegistration::verifyConfirmRegistration($user)){
                        session()->flash('erro', 'Realize o pagamento das inscrições pendentes para criar uma nova inscrição');
                        return back()->withInput();
                    }

                    if( VerifyRegistration::verifyUserLimitRegistrations($user, $modalidade)){
                        session()->flash('erro', 'O usuario já tem 2 inscrições ativas');
                        return back()->withInput();
                    }
                }

                foreach ($request->category  as $category) {
                $category = modalities_category::find($category);

                if(!$category){
                    return back();
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $federativeUnit)){
                    session()->flash('erro', "Não existe mais vagas para categoria $category->nome");
                    return back()->withInput();
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccional($category, $federativeUnit)){
                    session()->flash('erro', "Não existe mais vagas para categoria $category->nome na sua seccional");
                    return back()->withInput();
                }
                if($request->range){
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeMan($category, $request->range, $federativeUnit)){
                        session()->flash('erro', "Não existe mais vagas masculinas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeWomen($category, $request->range, $federativeUnit)){
                        session()->flash('erro', "Não existe mais vagas femininas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                }
                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category, $federativeUnit)){
                        session()->flash('erro', "Não existe mais vagas para usuários do sexo masculino para categoria $category->nome");
                        return back()->withInput();
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category, $federativeUnit)){
                        session()->flash('erro', "Não existe mais vagas para usuários do sexo feminino para categoria $category->nome");
                        return back()->withInput();
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $request->date_nasc, $modalidade, $federativeUnit)){
                    session()->flash('erro', "Desculpe, mas o minimo de idade para a categoria " . $category->nome . " é $category->min_year anos");
                    return back()->withInput();
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
                        session()->flash('erro', 'Este atleta está com pagamento pendente. Antes de realizar uma nova inscrição é preciso realizar o pagamento da inscrição anterior.');
                        return back()->withInput();
                    }
                    if(VerifyRegistration::verifyUserIntoModalities($user, $category)){
                        session()->flash('erro', 'Usuário já está inscrito nessa categoria');
                        return back()->withInput();
                    }
                    if( VerifyRegistration::verifyUserLimitRegistrations($user, $modalidade)){
                        session()->flash('erro', 'O usuario já tem 2 inscrições ativas');
                        return back()->withInput();
                    }
                    foreach ($user->registrations as $registration) {
                        if(!(($modalidade->id == 16) || ($modalidade->id == 13) || ($modalidade->id == 6) || ($modalidade->id == 4)) && $registration->modalities->id == $modalidade->id){
                            session()->flash('erro', 'Usuário já tem inscrição nessa modalidade');
                            return back()->withInput();
                        }
                    }
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $federativeUnit)){
                    session()->flash('erro', 'Não existe mais vagas para essa modalidade');
                    return back()->withInput();
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccional($category, $federativeUnit)){
                    session()->flash('erro', 'Não existe mais vagas para essa modalidade na sua seccional');
                    return back()->withInput();
                }
                if($request->range){
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeMan($category, $request->range, $federativeUnit)){
                        session()->flash('erro', "Não existe mais vagas masculinas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeWomen($category, $request->range, $federativeUnit)){
                        session()->flash('erro', "Não existe mais vagas femininas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                }
                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category, $federativeUnit)){
                        session()->flash('erro', 'Não existe mais vagas para usuários do sexo masculino nessa modalidade');
                        return back()->withInput();
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category, $federativeUnit)){
                        session()->flash('erro', 'Não existe mais vagas para usuários do sexo feminino nessa modalidade');
                        return back()->withInput();
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $request->date_nasc, $modalidade, $federativeUnit)){
                    session()->flash('erro', "Desculpe, mas o minimo de idade para a categoria " . $category->nome . " é $category->min_year anos");
                    return back()->withInput();
                }

            }

            if(!$user){
                $user = new User;
                $user->email = $request->email;
                $user->cpf = preg_replace( '/[^0-9]/is', '', $request->cpf);
                $user->data_nasc = $request->date_nasc;
                $user->phone_number = $request->phone_number;
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

            $valor = 0;
            if($modalidade->id == 19){
                $valor = 80;
            } else {
                $registrations_payment = 0;
                foreach ($user->registrations as $registrationn) {
                    if(($registrationn->Payment->status_payment->id == 1) && ($registrationn->modalities->id != 19)){
                        if($registrationn->id != $registration->id){
                            $registrations_payment++;
                        }

                    }
                }
                switch ($registrations_payment) {
                    case 0:
                        $valor = 200.00;
                        break;
                    case 1:
                        $valor = 100.00;
                        break;
                    case 3:
                        return back();
                        break;
                }
            }
            $payment->mount = $valor;
            $payment->save();



        $payload = [
            "email" => $user->email,
            "date_nasc" => $user->data_nasc,
            "phone_number" => $user->phone_number,
            "cpf" => $user->cpf,
            "sexo" => $user->sexo,
            "uf" => $user->address->federativeUnit->initials,
            "exp" => time() + (60 * 60 * 24 * 30),
        ];
        $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');
        $host = request()->getSchemeAndHttpHost();
        $link = "{$host}/confirm_registration/{$jwt}";
        $user->link_register = $link;
        $user->save();
        session()->flash('success', 'Inscrição efetuada com sucesso!');
        Mail::to($request->email)->send(new RegistrationMail($link, $registration));


        return redirect("/admin/modalidade/{$modalidade->id}");
       
        } catch(Exception $e){
            Log::alert($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
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
            if($admin->rule->id == 2){
                if($registration->status_regitration->id == 1){
                    $registration_recent = $registration->user->registrations()->latest()->first();
    
                    if( $registration_recent->id == $registration->id){
                        if($registration_recent->type_payment->id == 2){
                            session()->flash('erro', 'Exclusão de inscrição não permitida.');
                            return back();
                        }
                    } else {
                        session()->flash('erro', 'Exclusão de inscrição não permitida.');
                        return back();
                    }
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
            $action_admin->description = 'Deletou a inscrição do atleta '.$registration->user->nome_completo.' com CPF '.$registration->user->cpf.' na modalidade '.$registration->modalities->nome;
            $action_admin->save();
            Mail::to($user->email)->send(new RegistrationDelete($registration));
            session()->flash('success', 'A inscrição foi excluída com sucesso');
            return redirect("/admin/users/$user->id");
        } catch(Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function create(Request $request, $id){
        try{
            if($request->session()->get('admin')->rule->id != 1){
                session()->flash('erro', 'Inscrições encerradas.');
                return back();
            }
            
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
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function edit_get(Request $request, $id) {
        try {
            
            $registration = registration::find($id);
            if(!$registration){
                return back();
            }
            $type_payments = type_payment::all();
            $sub_categorys = sub_categorys::all();

            return view('Admin.registrations_update', [
                'registration' => $registration,
                'type_payments' => $type_payments,
                'sub_categorys' => $sub_categorys
            ]);

        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function edit_post(Request $request, $id) {
        try {
            $registration = registration::find($id);
            $category = null;
            if($registration->modalities->mode_modalities->id != 2){
                $category = modalities_category::find($request->category);
            }
            if(!$registration){
                return back();
            }
            if(($registration->type_payment_id == 2) && ($registration->status_regitration_id == 1)){
                return back();
            }

            if($registration->modalities->mode_modalities->id == 1){
                $category = $registration->modalities->modalities_categorys()->first();

                if(!$category){
                    return back();
                }

            } elseif($registration->modalities->mode_modalities->id == 2){

                foreach ($request->category  as $category) {
                $category = modalities_category::find($category);

                if(!$category){
                    return back();
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $registration->user->address->federativeUnit->id)){
                    session()->flash('erro', "Não existe mais vagas para categoria $category->nome");
                    return back()->withInput();
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccional($category, $registration->user->address->federativeUnit->id)){
                    session()->flash('erro', "Não existe mais vagas para categoria $category->nome na sua seccional");
                    return back()->withInput();
                }
                if($request->range){
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeMan($category, $request->range, $registration->user->address->federativeUnit->id)){
                        session()->flash('erro', "Não existe mais vagas masculinas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeWomen($category, $request->range, $registration->user->address->federativeUnit->id)){
                        session()->flash('erro', "Não existe mais vagas femininas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                }
                if($registration->user->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category, $registration->user->address->federativeUnit->id)){
                        session()->flash('erro', "Não existe mais vagas para usuários do sexo masculino para categoria $category->nome");
                        return back()->withInput();
                    }
                }
                if($registration->user->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category, $registration->user->address->federativeUnit->id)){
                        session()->flash('erro', "Não existe mais vagas para usuários do sexo feminino para categoria $category->nome");
                        return back()->withInput();
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $registration->user->data_nasc, $registration->modalities,  $registration->user->address->federativeUnit->id)){
                    session()->flash('erro', "Desculpe, mas o minimo de idade para a categoria ".$category->nome." é $category->min_year anos");
                    return back()->withInput();
                }
                }

            } elseif($registration->modalities->mode_modalities->id == 3) {
                $category = modalities_category::find($request->category);
                if(!$category){
                    return back();
                }

                if(VerifyRegistration::verifyModalitiesLimitRegistrations($category, $registration->user->address->federativeUnit->id)){
                    session()->flash('erro', 'Não existe mais vagas para essa modalidade');
                    return back()->withInput();
                }
                if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccional($category, $registration->user->address->federativeUnit->id)){
                    session()->flash('erro', 'Não existe mais vagas para essa modalidade na sua seccional');
                    return back()->withInput();
                }
                if($request->range){
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeMan($category, $request->range, $registration->user->address->federativeUnit->id)){
                        session()->flash('erro', "Não existe mais vagas masculinas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                    if(VerifyRegistration::verifyModalitiesLimitRegistrationsSeccionalByRangeWomen($category, $request->range, $registration->user->address->federativeUnit->id)){
                        session()->flash('erro', "Não existe mais vagas femininas para categoria $category->nome e faixa selecionada na sua seccional");
                        return back()->withInput();
                    }
                }
                if($request->sexo == 'M'){
                    if(VerifyRegistration::verifyModalitiesLimitMan($category, $registration->user->address->federativeUnit->id)){
                        session()->flash('erro', 'Não existe mais vagas para usuários do sexo masculino nessa modalidade');
                        return back()->withInput();
                    }
                }
                if($request->sexo == 'F'){
                    if(VerifyRegistration::verifyModalitiesLimitWomen($category, $registration->user->address->federativeUnit->id)){
                        session()->flash('erro', 'Não existe mais vagas para usuários do sexo feminino nessa modalidade');
                        return back()->withInput();
                    }
                }
                if(VerifyRegistration::verifyModalitiesMinYear($category, $registration->user->data_nasc, $registration->modalities,  $registration->user->address->federativeUnit->id)){
                    session()->flash('erro', "Desculpe, mas o minimo de idade para a categoria ".$category->nome." é $category->min_year anos");
                    return back()->withInput();
                }

            }

            $registration->user_id = $registration->user->id;
            $registration->is_pcd = $request->pcd ? 1 : 0;
            $registration->sub_categorys_id = $request->sub_category ? $request->sub_category : null;
            $registration->modalities_id = $registration->modalities->id;
            $registration->modalities_category_id = !is_null($category) ? $category->id : null;
            $registration->status_regitration_id = $request->payment == 1 ? 1 : 3;
            $registration->type_payment_id = $request->payment;
            $registration->Payment->status_payment_id =  $request->payment == 1 ? 1 : 3;

            if(Count($registration->modalities->ranges) != 0){
                $registration->range_id = $request->range;
            }
            $registration->Payment->save();
            $registration->save();
            if($registration->modalities->mode_modalities->id == 2){
                $registration_categorys = DB::table('natacao_categorias')->where('registration_id', $registration->id)->get();
                if($registration_categorys){
                    foreach ($registration_categorys as $value) {
                        DB::table('natacao_categorias')->delete($value->id);
                    }
                }
                foreach ($request->category  as $category) {
                    $category = modalities_category::find($category);
                    $registration->modalities_categorys()->save($category);
                }
            }

            return redirect("/admin/modalidade/$registration->modalities_id");

        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
