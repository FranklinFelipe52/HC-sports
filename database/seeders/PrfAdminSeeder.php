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
            'password' => Hash::make('teste'),
        ]);
    }
}
