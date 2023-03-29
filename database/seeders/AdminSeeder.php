<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'password' => 'teste',
            'rule_id' => 1,
            'federative_unit_id' => 11
        ]);
    }
}
