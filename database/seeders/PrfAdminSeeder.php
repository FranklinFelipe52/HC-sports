<?php

namespace Database\Seeders;

use App\Models\PrfAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class PrfAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrfAdmin::create([
            'nome_completo' => 'Alex Pereira',
            'cpf' => '00000000000',
            'email' => 'alex@hcsports.com.br',
            'password' => Hash::make('U2y0U13y*8*1'),
        ]);

        PrfAdmin::create([
            'nome_completo' => 'Couceiro',
            'cpf' => '00000000001',
            'email' => 'imprensacbmrn@gmail.com',
            'password' => Hash::make('54]&Xua8$xu'),
        ]);
    }
}
