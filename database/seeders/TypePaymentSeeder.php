<?php

namespace Database\Seeders;

use App\Models\type_payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypePaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Caixa federal', 'Atleta'];

        foreach ($types as $value) {
            type_payment::create([
              'type' => $value
            ]);
          }
    }
}
