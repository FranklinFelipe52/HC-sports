<?php

namespace Database\Seeders;

use App\Models\status_regitration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusRegitrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $types = ['Confirmado', 'Aguardando aceite', 'Aguardando pagamento', 'Aguardando avaliação'];

        foreach ($types as $value) {
            status_regitration::create([
              'status' => $value
            ]);
          }
    }
}
