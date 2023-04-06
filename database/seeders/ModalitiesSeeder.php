<?php

namespace Database\Seeders;

use App\Models\Modalities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ModalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modalities::truncate();

        $json = File::get(database_path('json/modalities.json'));
        $modalities = json_decode($json);
    
        foreach ($modalities as $value) {
          Modalities::create([
            'nome' => $value->nome,
            'limit_year_date' => $value->limit_year_date,
            'mode_modalities_id' => $value->mode_modalities_id,
            'modalities_type_id' => $value->modalities_type_id
          ]);
        }
    }
}
