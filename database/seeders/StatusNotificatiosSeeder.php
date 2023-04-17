<?php

namespace Database\Seeders;

use App\Models\StatusNotificatios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusNotificatiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Validou o cadastro', 'Realizou um pagamento', 'Solicitou cancelamento da inscrição'];

        foreach ($types as $value) {
            StatusNotificatios::create([
              'status' => $value
            ]);
          }
    }
}
