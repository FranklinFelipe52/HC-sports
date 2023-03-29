<?php

namespace Database\Seeders;

use App\Models\FederativeUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FederativeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FederativeUnit::truncate();

        $json = File::get(database_path('json/federative_units.json'));
        $federative_units = json_decode($json);
    
        foreach ($federative_units as $value) {
          FederativeUnit::create([
            'name' => $value->name,
            'code' => $value->code,
            'initials' => $value->initials,
            
          ]);
        }
    
    }
}
