<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrfStoreRegistrationRequest;
use App\Models\PrfCategorys;
use App\Models\PrfPace;
use App\Models\PrfPackage;
use App\Models\PrfPayments;
use App\Models\PrfRegistration;
use App\Models\PrfTshirt;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PrfRegistrationController extends Controller
{

    
    public function create(Request $request, $category_id, $package_id){
        try{
            $paces = PrfPace::all();
            $category = PrfCategorys::find($category_id);
            $package = PrfPackage::find($package_id);

            if(!$category || !$package){
                return back();
            }
          return  view('PRF.registration', [
           'paces' => $paces,
           'category' => $category,
           'package' => $package,
           'tshirts' =>  PrfTshirt::all()
          ]);

        } catch(Exception $e){
            return back();
        }
    }

    public function store(PrfStoreRegistrationRequest $request, $category_id, $package_id){
        try{
            $category = PrfCategorys::find($category_id);
            $package = PrfPackage::find($package_id);

            if(!$category || !$package){
                return back();
            }
            if($request->password != $request->confirm_password){
                return back()->with('erro', 'Senhas diferentes');
            }

            $user = new PrfUser;
            $user->nome_completo = $request->nome;
            $user->cpf = preg_replace( '/[^0-9]/is', '', $request->cpf);
            $user->data_nasc = $request->data_nasc;
            $user->email = $request->email;
            $user->password =  Hash::make($request->password);
            $user->sexo = $request->sexo;
            $user->save();

            $registration = new PrfRegistration;
            $registration->prf_user_id = $user->id;
            $registration->prf_categorys_id = $category->id;
            $registration->prf_package_id = $package->id;
            $registration->prf_pace_id = $request->pace;
            $registration->status_regitration_id = 3;
            $registration->size_tshirt = $request->size_tshirt;
            $registration->equipe = $request->equipe;
            $registration->save();
            if(!is_null( $request->tshirts)){
                foreach ($request->tshirts as $tshirt_id) {
                    $tshirt = PrfTshirt::find($tshirt_id);
                    if($tshirt){
                        $registration->tshirts()->save($tshirt);
                    }
                }
            }
            $payment = new PrfPayments;
            $payment->prf_registration_id = $registration->id;
            $payment->status_payment_id = 3;
            $payment->save();
            
            $request->session()->put('prf_user', $user);
            return redirect('/dashboard');

        } catch(Exception $e){
            return back()->withInput();
        }
    }

    public function update_get(Request $request, $id){
        try{
        $user = PrfUser::find($request->session()->get('prf_user')->id);
        $registration = PrfRegistration::find($id);
        if(!$user){
            return back();
        }
        if(!$registration){
            return back();
        }
        if($registration->prf_user->id != $user->id){
            return back();
        }
        if($registration->status_regitration_id == 1){
            return back();
        }
        $shirts_sizes = ['P', 'M', 'G', 'GG'];
        return view('PRF.User.registration_update', [
            'paces' => PrfPace::all(),
            'categorys' => PrfCategorys::all(),
            'packages' => PrfPackage::all(),
            'registration' => $registration,
            'shirts_sizes' => $shirts_sizes,
            'tshirts' =>  PrfTshirt::all() 
        ]);

        } catch(Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function update_post(Request $request, $id){
        try{
            $user = PrfUser::find($request->session()->get('prf_user')->id);
            $registration = PrfRegistration::find($id);
            if(!$user){
                return back();
            }
            if(!$registration){
                return back();
            }
            if($registration->prf_user->id != $user->id){
                return back();
            }
            if($registration->status_regitration_id == 1){
                return back();
            }
            $registration->prf_categorys_id = $request->category;
            $registration->prf_package_id = $request->package;
            $registration->prf_pace_id = $request->pace;
            $registration->size_tshirt = $request->size_tshirt;
            $registration->equipe = $request->equipe;
            $registration->save();
            $registration_and_tshirts =  DB::table('prf_tshirt_and_prf_registrations')->where('prf_registration_id', $registration->id)->get();
                foreach ( $registration_and_tshirts as $value) {
                    error_log($value->id);
                    DB::table('prf_tshirt_and_prf_registrations')->delete($value->id);
                }
            if($request->tshirts){
                foreach ($request->tshirts as $tshirt_id) {
                    $tshirt = PrfTshirt::find($tshirt_id);
                    if($tshirt){
                           $registration->tshirts()->save($tshirt);
                    }
                    }
            }
            
            return redirect('/dashboard');
        } catch(Exception $e){
            return dd($e);
        }
    }

}
