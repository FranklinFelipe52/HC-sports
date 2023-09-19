<?php

namespace App\Http\Controllers;

use App\Models\PrfAdminLog;
use Illuminate\Support\Facades\DB;
use App\Models\PrfCategorys;
use App\Models\PrfRegistration;
use App\Models\PrfSizeTshirts;
use App\Models\PrfTshirt;
use App\Models\PrfUser;
use App\Models\PrfVauchers;
use Exception;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
    public function update_get(Request $request, $id)
    {
        try {
            $registration = PrfRegistration::find($id);
            $category = PrfCategorys::find($registration->prf_categorys_id);
            $size_tshirt = PrfSizeTshirts::find($registration->prf_size_tshirts_id);
            $user = PrfUser::find($registration->prf_user_id);

            if (!$user) {
                return back();
            }
            if (!$registration) {
                return back();
            }

            return view('PRF.Admin.registration_update', [
                'categorys' => PrfCategorys::all(),
                'category' => $category,
                'size_tshirts' => PrfSizeTshirts::all(),
                'size_tshirt' => $size_tshirt,
                'atleta' => $user,
                'registration' => $registration,
                'tshirts' => PrfTshirt::all()
            ]);

        } catch (Exception $e) {
            dd($e);
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function update_post(Request $request, $id)
    {
        try {
            $registration = PrfRegistration::find($id);
            $user = PrfUser::find($registration->prf_user_id);
            $admin = PrfUser::find($request->session()->get('admin')->id);

            $registration->prf_categorys_id = $request->category;
            $registration->prf_size_tshirts_id = $request->size_tshirt;
            $registration->equipe = $request->equipe;
            $registration->save();

            $admin_log = new PrfAdminLog;
            $admin_log->prf_admin_id = $admin->id;
            $admin_log->type_actions_admin_id = 3;
            $admin_log->description = 'Editou informações da inscrição #' . $registration->id . ' do usuário de cpf ' . $user->cpf;
            $admin_log->save();

            return redirect('/admin/users/' . $user->id);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }
}
