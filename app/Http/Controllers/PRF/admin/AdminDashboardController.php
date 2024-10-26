<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Models\PrfPayments;
use App\Models\PrfRegistration;
use App\Models\PrfVauchers;
use App\Models\PrfCategorys;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $registrations = PrfRegistration::all();
        $pagamentos = PrfPayments::where('status_payment_id', 1)->orderBy('created_at', 'desc')->get();
        $descontos = PrfVauchers::all();
        $vouchers = PrfVauchers::where('isCupom', 0)->get();
        $cupoms = PrfVauchers::where('isCupom', 1)->get();
        $categorys = PrfCategorys::all();

        return view('PRF.Admin.dashboard',
            [
                'registrations' => $registrations,
                'pagamentos' => $pagamentos,
                'descontos' => $descontos,
                'vouchers' => $vouchers,
                'cupoms' => $cupoms,
                'categorys' => $categorys
            ]
        );
    }
}
