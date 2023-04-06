<?php

namespace Database\Seeders;

use App\Models\modalities_category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ModalitiesCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        modalities_category::truncate();

        $json = File::get(database_path('json/modalities_categorys.json'));
        $modalities_categorys = json_decode($json);

        foreach ($modalities_categorys as $value) {
            modalities_category::create([
                'nome' => $value->nome,
                "max_total" => $value->max_total,
                "max_f" => $value->max_f,
                "max_m" => $value->max_m,
                "min_year" => $value->min_year,
                "modalities_id" => $value->modalities_id
            ]);
        }
    }
}
