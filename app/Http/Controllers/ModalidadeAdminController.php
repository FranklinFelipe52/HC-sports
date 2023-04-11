<?php

namespace App\Http\Controllers;

use App\Models\group_category;
use App\Models\Modalities;
use App\Models\modalities_category;
use App\Models\Modalities_type;
use App\Models\mode_modalities;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModalidadeAdminController extends Controller
{
    public function single(Request $request, $id){
        try{
            $admin = $request->session()->get('admin');
            $modalidade = Modalities::find($id);
            if($modalidade){
                if(!($admin->rule->id == 1)){
                    $users = [];
                    $registrations = [];

                    foreach ($modalidade->registrations as $registration) {
                        if($registration->user->addres->federativeUnit->id == $admin->federativeUnit->id){
                            array_push($registrations, $registration);
                        }
                    }

                    foreach ( $registrations as $registration) {
                        if(!in_array($registration->user, $users)){
                            array_push($users, $registration->user);
                        }
                    }
                } else {
                    $users = [];
                    $registrations = $modalidade->registrations;
                    foreach ( $registrations as $registration) {
                        if(!in_array($registration->user, $users)){
                            array_push($users, $registration->user);
                        }
                    }
                }
                
                

               
                return view('Admin.modalidade', [
                    'modalidade'  => $modalidade,
                    'users' => $users,
                    
                 ]);
            } 
            return back();
        } catch (Exception $e){
            return dd($e);
        }
    }

    public function show(Request $request){
        try{
            $modalidades = [];
            $admin = $request->session()->get('admin');
            foreach (Modalities::all() as $modalidade) {
                if(!($admin->rule->id == 1)){
                    $users = [];
                    $registrations = [];

                    foreach ($modalidade->registrations as $registration) {
                        if($registration->user->addres->federativeUnit->id == $admin->federativeUnit->id){
                            array_push($registrations, $registration);
                        }
                    }

                    foreach ( $registrations as $registration) {
                        if(!in_array($registration->user, $users)){
                            array_push($users, $registration->user);
                        }
                    }

                    array_push($modalidades, [
                        'modalidade' => $modalidade,
                        'users' => $users
                    ]);
                } else {
                    $users = [];
                    $registrations = $modalidade->registrations;
                    foreach ( $registrations as $registration) {
                        if(!in_array($registration->user, $users)){
                            array_push($users, $registration->user);
                        }
                    }
                    array_push($modalidades, [
                        'modalidade' => $modalidade,
                        'users' => $users
                    ]);
                }
            }

            return view('Admin.modalidades', [
               'modalidades'  => $modalidades,
            ]);

        } catch (Exception $e){
            return back();
        }
    }

    public function create(Request $request){
        try{
            error_log('g');
            $tipos_modalidades = Modalities_type::all();
            $mode = mode_modalities::all();
            error_log('e');
            return view('Admin.create_modalidade', [
                'modality_types' => $tipos_modalidades,
               'mode' => $mode
            ]);
        } catch (Exception $e){
            return $e;
        }
    }

    public function store(Request $request){
        try{
            Modalities::create([
                'nome' => $request->nome,
                'limit_year_date' => $request->limit_year_date,
                'mode_modalities_id' => $request->mode,
                'modalities_type_id' => $request->type  
            ]);

            return back();
        }catch (Exception $e){
            return $e;
        }
    } 
}
