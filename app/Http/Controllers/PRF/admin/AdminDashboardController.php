<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('PRF.Admin.dashboard');
    }
}
