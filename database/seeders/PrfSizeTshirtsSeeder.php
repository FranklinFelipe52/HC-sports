<?php

namespace Database\Seeders;

use App\Models\PrfSizeTshirts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PrfSizeTshirtsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PrfSizeTshirts::truncate();

        $json = File::get(database_path('json/SizeTshirts.json'));
        $SizeTshirts = json_decode($json);
    
        foreach ($SizeTshirts as $value) {
            PrfSizeTshirts::create([
            "nome" => $value->nome,
          ]);
        }
    }
}
