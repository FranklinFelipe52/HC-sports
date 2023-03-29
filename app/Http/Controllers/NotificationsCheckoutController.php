<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsCheckoutController extends Controller
{
    public function store(Request $request){
        error_log($request);
    }
}
