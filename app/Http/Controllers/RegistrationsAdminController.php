<?php

namespace App\Http\Controllers;

use App\Helpers\AgeBetweenDates;
use App\Helpers\VerifyRegistration;
use App\Http\Requests\StoreRegistrationRequest;
use App\Mail\RegistrationDelete;
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
            $user = User::where('cpf', preg_replace( '/[^0-9]/is', '', $request->cpf))->first();
            
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
                $addres->federative_unit_id = $admin->rule->id == 1 ? $request->uf : $admin->federativeUnit->id;
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
        Mail::to($request->email)->send(new RegistrationMail($link, $registration));

            return redirect("/admin/modalidade/{$modalidade->id}");

        } catch(Exception $e){
            return $e;
        }
    }


    public function delete(Request $request, $id){
        try{
           $registration = registration::find($id);
            if(!$registration){
                return back();
            }
            $registration->delete();
            Mail::to($registration->user->email)->send(new RegistrationDelete($registration));
            return redirect('/admin/users/{{$id}}');
        } catch(Exception $e){
            return redirect('/admin/users/{{$id}}');
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
                'type_payments' => $type_payments,
                'federative_units' => FederativeUnit::all()
            ]);

        }catch(Exception $e){
            return $e;
        }
    }
}
