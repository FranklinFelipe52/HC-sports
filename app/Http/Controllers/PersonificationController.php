<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;

class PersonificationController extends Controller
{
    public function Personification(Request $request){
        try{
            $admin = Admin::find($request->session()->get('admin')->id);
            $admin->personification = $request->uf;
            $admin->save();
            $request->session()->put('admin', $admin);
            return back();
        } catch (Exception $e){ 
            return back();
        }
    }

    public function Personification_off(Request $request){
        try{
            $admin = Admin::find($request->session()->get('admin')->id);
            $admin->personification = null;
            $admin->save();
            $request->session()->put('admin', $admin);
            return back();
        } catch (Exception $e){ 
            return back();
        }
    }
}
