<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Models\PrfRegistration;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('PRF.Admin.dashboard', [
            'total_registrations' => PrfRegistration::count(),
            'confirmed'           => PrfRegistration::where('status_regitration_id', PrfRegistration::STATUS_CONFIRMADO)->count(),
            'cancelled'           => PrfRegistration::where('status_regitration_id', PrfRegistration::STATUS_CANCELADA)->count(),
        ]);
    }
}
