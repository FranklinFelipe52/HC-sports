<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('json/Range_modality.json'));
        $range_categorys = json_decode($json);
    
        foreach ($range_categorys as $value) {
          RangeModality::create([
            "modalities_id" => $value->modalities_id,
            "range_id" => $value->range_id
          ]);
        }
    }
}
