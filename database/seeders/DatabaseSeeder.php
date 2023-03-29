<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            UserSeeder::class,
            RuleSeeder::class,
            PermissionsSeeder::class,
            RulesPermissionsSeeder::class,
            AdminSeeder::class,
            ModeModalitiesSeeder::class,
            StatusPaymentSeeder::class,
            GroupCategorySeeder::class,
            StatusRegitrationSeeder::class
        ]);
    }
}
