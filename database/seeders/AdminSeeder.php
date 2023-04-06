<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'nome_completo' => 'Franklin Felipe de Oliveira Barbosa',
            'cpf' => '00000000000',
            'email' => 'franklin.felipe158@gmail.com',
            'password' => Hash::make('teste'),
            'rule_id' => 1,
            'federative_unit_id' => 11
        ]);
    }
}
