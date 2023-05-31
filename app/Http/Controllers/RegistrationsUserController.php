<?php

namespace App\Http\Controllers;

use App\Helpers\AgeBetweenDates;
use App\Models\log_payment;
use App\Models\Modalities;
use App\Models\modalities_category;
use App\Models\payment;
use App\Models\registration;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\Count;

class RegistrationsUserController extends Controller
{
    public function show(Request $request, $id){

        try {
            $registration = registration::find($id);

            return view('User.registration', [
                'registration'  => $registration
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function store(Request $request){
        try{
            if(!$request->session()->has('user')){
                return redirect('/login');
            }
            if(Count($request->session()->get('cart')) === 0){
                return back();
            }


            $user = User::find($request->session()->get('user')->id);

            if(!(Count($user->registrations) + Count($request->session()->get('cart')) <= 2)){
                return back()->with('erro', "Desculpe, mas o limite de inscrições já foi atingido");
            }




            foreach ($request->session()->get('cart') as $value) {

                if(Modalities::find($value['modalidade']->id)){
                    foreach ($value['categorys'] as $category) {
                        if($category->min_year <= AgeBetweenDates::calc_idade($user->data_nasc, $value['modalidade']->limit_year_date)){
                            if($value['modalidade']->mode_modalities->code == 1){
                                return back()->with('erro', "Desculpe, mas o limite de idade para a modalidade ".$value['modalidade']->nome." é $category->min_year anos");
                            }
                            return back()->with('erro', "Desculpe, mas o limite de idade para a categoria $category->titulo na modalidade ".$value['modalidade']->nome." é $category->min_year anos");
                        }

                    }
                    $payment = new payment;
                    $payment->status_payment_id = 1;
                    $payment->save();
                    $registration = new registration;
                    if($value['modalidade']->modalities_type->id == 1){
                        $registration->status_regitration_id = 2;
                    }
                    $registration->user_id = $user->id;
                    $registration->modalities_id = $value['modalidade']->id;
                    $registration->payment_id = $payment->id;
                    $registration->save();
                    foreach ($value['categorys'] as $category) {
                        $registration->modalities_categorys()->save($category);
                    }
                } else {
                    return back()->with('erro', 'Houve um erro na inscrição, tente novamente.');
                }

            }
            $request->session()->put('cart', []);

            return redirect('/my-registrations');

        } catch (Exception $e){
            return back()->with('erro', 'Houve um erro na inscrição, tente novamente.');
        }
    }

    public function myRegistrations(Request $request){
        try{
            $user = User::find($request->session()->get('user')->id);
            if($user){
                return view('User.myRegistrations', [
                    'registrations' => $user->registrations,
                ]);
            }

            return back();
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
