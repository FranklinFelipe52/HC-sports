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
            StatusRegitrationSeeder::class,
            RangeSeeder::class,
            TypePaymentSeeder::class,
            StatusPaymentSeeder::class,
            TypeActionsAdminSeeder::class,
            PrfAdminSeeder::class,
            PackageSeeder::class,
        ]);
    }
}
