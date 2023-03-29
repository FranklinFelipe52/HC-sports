<?php

namespace Database\Seeders;

use App\Models\Modalities_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalitiesTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['individual', 'coletiva'];

        foreach ($types as $value) {
            Modalities_type::create([
              'type' => $value,
            ]);
          }
    }
}
