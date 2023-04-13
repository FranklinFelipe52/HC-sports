<?php

namespace Database\Seeders;

use App\Models\sub_categorys;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SubCategorysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('json/sub_categorys.json'));
        $sub_categorys = json_decode($json);
    
        foreach ($sub_categorys as $value) {
          sub_categorys::create([
            "nome" => $value->nome
          ]);
        }
    }
}
