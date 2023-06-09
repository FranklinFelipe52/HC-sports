<?php

namespace App\Http\Controllers;

use App\Models\FederativeUnit;
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
                $registrations = [];
                $federative_units = [];
                if(!($admin->rule->id == 1)){

                        foreach ($modalidade->registrations as $registration) {
                                if ($registration->user->address->federative_unit_id == Session('admin')->federative_unit_id ) {
                                  array_push($registrations, $registration);
                                }
                            }
                } else {
                    if($admin->personification){
                        foreach ($modalidade->registrations as $registration) {
                                if ($registration->user->address->federative_unit_id == $admin->personification ) {
                                  array_push($registrations, $registration);
                                }
                            }
                    } else {
                        $registrations = $modalidade->registrations;
                        foreach ($registrations as $registration) {
                            foreach(FederativeUnit::all() as $federative_unit) {
                                if ($registration->user->address->federative_unit_id == $federative_unit->id) {
                                    if (!in_array($federative_unit, $federative_units)) {
                                        array_push($federative_units, $federative_unit);
                                    }
                                }
                            }
                        }
                    }

                }

                usort($federative_units, function ($a, $b) {
                    return strcmp($a->name, $b->name);
                });

                return view('Admin.modalidade', [
                    'modalidade'  => $modalidade,
                    'registrations' => $registrations,
                    'federative_units' => $federative_units,
                 ]);

            }
            return back();
        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function show(Request $request){
        try{
            $modalidades = Modalities::orderBy('nome', 'asc')->get();
            $admin = $request->session()->get('admin');


            return view('Admin.modalidades', [
               'modalidades'  => $modalidades,
            ]);

        } catch (Exception $e){
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
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
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
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
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
