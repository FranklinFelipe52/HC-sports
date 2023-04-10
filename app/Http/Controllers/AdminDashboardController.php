<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use Exception;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function show(Request $request){
        try{
            $modalidades = [];
            $admin = $request->session()->get('admin');
            foreach (Modalities::all() as $modalidade) {
                    $users = [];
                    $total = 0;

                    foreach ( $modalidade->registrations as $registration) {
                        if(!in_array($registration->user, $users)){
                            array_push($users, $registration->user);
                        }
                    }

                    if($modalidade->mode_modalities->id == 1){
                        $total = $modalidade->modalities_categorys->first()->max_total;
                    } else {
                        foreach ($modalidade->modalities_categorys as $categoria) {
                            $total = $total + $categoria->max_total;
                        }
                    }

                    array_push($modalidades, [
                        'modalidade' => $modalidade,
                        'total_modalidade' => $total
                    ]);
            }

            return view('Admin.dashboard', [
               'modalidades'  => $modalidades,
            ]);

        } catch (Exception $e){
            return $e;
        }
    }
}
