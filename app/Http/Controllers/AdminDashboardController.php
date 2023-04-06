<?php

namespace App\Http\Controllers;

use App\Models\Modalities;
use Exception;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function show(){
        try{
            $modalidades = Modalities::all();
            return view('Admin.dashboard', [
               'modalidades'  => $modalidades,
            ]);

        } catch (Exception $e){
            return back();
        }
    }
}
