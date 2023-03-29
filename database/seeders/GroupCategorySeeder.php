<?php

namespace Database\Seeders;

use App\Models\group_category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Categoria', 'Faixa'];

        foreach ($types as $value) {
            group_category::create([
              'tipo' => $value,
            ]);
          }
    }
}
