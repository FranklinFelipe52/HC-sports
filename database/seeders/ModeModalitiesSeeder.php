<?php

namespace Database\Seeders;

use App\Models\mode_modalities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ModeModalitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            mode_modalities::truncate();
    
            $json = File::get(database_path('json/mode_modalities.json'));
            $mode_modalities = json_decode($json);
        
            foreach ($mode_modalities as $value) {
                mode_modalities::create([
                'mode' => $value->mode,
                'code' => $value->code,
              ]);
            }
        }
    }
}
