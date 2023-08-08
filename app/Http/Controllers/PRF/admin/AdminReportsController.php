<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function index(Request $request)
    {
        try {
            return view('PRF.Admin.reports');
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}