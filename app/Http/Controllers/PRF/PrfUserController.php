<?php

namespace App\Http\Controllers\PRF;

use App\Http\Controllers\Controller;
use App\Models\PrfUser;
use Exception;
use Illuminate\Http\Request;

class PrfUserController extends Controller
{
    public function profile(Request $request)
    {
        try {
            return view('PRF.User.profile');
        } catch (Exception $e) {
            return back();
        }
    }
}
