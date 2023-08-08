<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\PrfAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function login(LoginRequest $request)
    {

        $admin = PrfAdmin::where('email', $request->email)->first();

        if (!$admin) {
            session()->flash('erro', 'E-mail ou senha inválida');
            return back();
        }

        if (Hash::check($request->password, $admin->password)) {
            $request->session()->put('admin', $admin);
            return redirect('/admin/dashboard');
        } else {
            session()->flash('erro', 'E-mail ou senha inválida');
            return back();
        }
    }

    public function logout(Request $request)
    {
        if ($request->session()->has('admin')) {
            $request->session()->forget('admin');
        }

        return redirect('/admin/login');
    }

    public function gen_password($password)
    {
        $gen_pass = Hash::make($password);
        dd($password, $gen_pass);
    }

    public function store()
    {
        //
    }

    public function profile(Request $request)
    {
        $admin = $request->session()->get('admin');

        return view('PRF.Admin.profile', ['admin' => $admin]);
    }
}
