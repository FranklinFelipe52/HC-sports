<?php

namespace Database\Seeders;

use App\Models\PrfDeficiency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PrfDeficiencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrfDeficiency::truncate();

        $json = File::get(database_path('json/Deficiency.json'));
        $PrfDeficiency = json_decode($json);
    
        foreach ($PrfDeficiency as $value) {
            PrfDeficiency::create([
            "nome" => $value->nome,
          ]);
        }
    }
}
