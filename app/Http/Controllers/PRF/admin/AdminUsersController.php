<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrfUserUpdateRequest;
use App\Mail\PrfEmailUpdate;
use App\Models\Caern_adresses;
use App\Models\FederativeUnit;
use App\Models\PrfAdminLog;
use App\Models\PrfRegistration;
use App\Models\PrfSizeTshirts;
use App\Models\PrfUser;
use App\Models\PrfAdmin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class AdminUsersController extends Controller
{
    public function index(Request $request)
    {
        try {
            $admin = $request->session()->get('admin');
            $users_query = PrfUser::orderBy('nome_completo', 'asc');

            if (isset($_GET["s"]) && $_GET["s"] !== '') {
                $searchTerm = $_GET["s"];
                $users_query->where(function ($query) use ($searchTerm) {
                    $query->where('nome_completo', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('servidor_matricula', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('cpf', preg_replace("/[^0-9]/", "", $searchTerm));

                });
            }

            $users = $users_query->get();

            return view('PRF.Admin.users', [
                'admin' => $admin,
                'atletas' => $users,
            ]);
        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function single(Request $request, $id)
    {
        try {
            $user = PrfUser::find($id);

            if (!$user) {
                return back();
            }

            $registration = $user->registrations->first();
            $size_tshirt = $registration ? PrfSizeTshirts::find($registration->prf_size_tshirts_id) : null;

            return view('PRF.Admin.user', [
                'atleta'       => $user,
                'registration' => $registration,
                'size_tshirt'  => $size_tshirt,
            ]);

        } catch (Exception $e) {
            session()->flash('erro', 'Devido a algum problema no sistema, não foi possível efetuar sua ação.');
            return back();
        }
    }

    public function update_form(Request $request, $id)
    {
        try {
            $user = PrfUser::find($id);

            if (!$user) {
                return back();
            }

            return view('PRF.Admin.user_update', [
                'atleta'          => $user,
                'federativeUnits' => FederativeUnit::all(),
            ]);
        } catch (Exception $e) {
            return back();
        }
    }

    public function update(PrfUserUpdateRequest $request, $id)
    {
        try {
            $user = PrfUser::find($id);
            $admin = PrfAdmin::find($request->session()->get('admin')->id);

            $user->cpf = preg_replace('/[^0-9]/is', '', $request->cpf);

            if ($user->email != $request->email) {
                $old_email = $user->email;
                $updated_email = $request->email;

                $email_has_user = PrfUser::where('email', $request->email)->first();

                // verificar se o email já existe antes de salvar
                if ($email_has_user) {
                    session()->flash('erro', 'O email que você tentou adicionar já está sendo usado por outro usuário.');
                    return back();
                } else {
                    $user->email = $request->email;
                }

                Mail::to($request->email)->send(new PrfEmailUpdate($old_email, $updated_email));

            }

            $user->nome_completo = $request->nome;
            $user->phone         = $request->phone;
            $user->sexo          = $request->sexo;
            $data_convertida     = Carbon::createFromFormat('d/m/Y', $request->data_nasc);
            $user->data_nasc     = $data_convertida->format('Y-m-d');
            $user->save();

            if ($request->filled('cep')) {
                $address = $user->caern_address ?? new Caern_adresses(['prf_user_id' => $user->id]);
                $address->cep                = $request->cep;
                $address->cidade             = strtoupper($request->cidade);
                $address->bairro             = strtoupper($request->bairro);
                $address->rua                = strtoupper($request->rua);
                $address->number             = $request->number;
                $address->complemento        = $request->complemento ? strtoupper($request->complemento) : null;
                $address->federative_unit_id = $request->estado;
                $address->prf_user_id        = $user->id;
                $address->save();
            }

            $admin_log = new PrfAdminLog;
            $admin_log->prf_admin_id = $admin->id;
            $admin_log->type_actions_admin_id = 3;
            $admin_log->description = 'Editou informações do usuário de cpf ' . $user->cpf . ', e id #' . $user->id;
            $admin_log->save();

            session()->flash('success', 'Dados atualizados');
            return back();

        } catch (Exception $e) {
            dd($e);
            return back();
        }
    }

}
