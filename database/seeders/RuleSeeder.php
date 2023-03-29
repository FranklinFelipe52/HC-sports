<?php

namespace Database\Seeders;

use App\Models\permissions;
use App\Models\Rule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rule::truncate();

        $json = File::get(database_path('json/rules.json'));
        $rules = json_decode($json);
    
        foreach ($rules as $value) {
          $rule = Rule::create([
            'tipo' => $value->tipo, 
          ]);

          
        }
    }
}
