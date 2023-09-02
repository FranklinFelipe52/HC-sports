<?php

namespace Database\Seeders;

use App\Models\PrfPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrfPackage::create([
            'nome' => 'Servidor',
            'descricao' => 'Pacote para servidores da segurança pública',
            'price' => 0,
        ]);

        PrfPackage::create([
            'nome' => 'Padrão',
            'descricao' => 'Pacote padrão com taxa',
            'price' => 10.00,
        ]);
    }
}
