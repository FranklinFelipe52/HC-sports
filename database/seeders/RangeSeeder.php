<?php

namespace Database\Seeders;

use App\Models\Range;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Branca', 'Azul/Roxa', 'Marrom/Preta'];

        foreach ($types as $value) {
            Range::create([
              'range' => $value
            ]);
          }
    }
}
