<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\RangeCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            FederativeUnitSeeder::class,
            ModalitiesTypeSeeder::class,
            RuleSeeder::class,
            AdminSeeder::class,
            ModeModalitiesSeeder::class,
            StatusRegitrationSeeder::class,
            RangeSeeder::class,
            TypePaymentSeeder::class,
            ModalitiesSeeder::class,
            ModalitiesCategorySeeder::class,
            RangeModalitySeeder::class
        ]);
    }
}
