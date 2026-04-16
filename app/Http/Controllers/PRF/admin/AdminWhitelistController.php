<?php

namespace App\Http\Controllers\PRF\admin;

use App\Http\Controllers\Controller;
use App\Models\AthleteWhitelist;
use Exception;
use Illuminate\Http\Request;

class AdminWhitelistController extends Controller
{
    public function index()
    {
        $entries = AthleteWhitelist::orderBy('type')->orderBy('document')->get();

        return view('PRF.Admin.whitelist', [
            'entries' => $entries,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $raw = preg_replace('/[^0-9]/', '', $request->input('document', ''));

            if ($raw === '') {
                session()->flash('erro', 'Informe um CPF ou CNPJ válido.');
                return back();
            }

            $type = strlen($raw) === 14 ? 'cnpj' : 'cpf';

            if ($type === 'cpf' && strlen($raw) !== 11) {
                session()->flash('erro', 'Documento inválido. CPF deve ter 11 dígitos e CNPJ 14 dígitos.');
                return back();
            }

            if (AthleteWhitelist::where('document', $raw)->exists()) {
                session()->flash('erro', 'Este documento já está na whitelist.');
                return back();
            }

            $maxReg = null;
            if ($type === 'cnpj' && $request->filled('max_registrations')) {
                $maxReg = (int) $request->input('max_registrations');
                if ($maxReg <= 0) {
                    $maxReg = null;
                }
            }

            AthleteWhitelist::create([
                'document'          => $raw,
                'type'              => $type,
                'max_registrations' => $maxReg,
            ]);

            session()->flash('success', 'Documento adicionado à whitelist com sucesso.');
            return back();

        } catch (Exception $e) {
            session()->flash('erro', 'Não foi possível adicionar o documento. Tente novamente.');
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $entry = AthleteWhitelist::find($id);

            if (!$entry) {
                session()->flash('erro', 'Registro não encontrado.');
                return back();
            }

            $entry->delete();

            session()->flash('success', 'Documento removido da whitelist.');
            return back();

        } catch (Exception $e) {
            session()->flash('erro', 'Não foi possível remover o documento. Tente novamente.');
            return back();
        }
    }
}
