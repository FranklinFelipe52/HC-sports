<?php

namespace Database\Seeders;

use App\Models\permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        permissions::truncate();

        $json = File::get(database_path('json/permissions.json'));
        $permissions = json_decode($json);
    
        foreach ($permissions as $value) {
          permissions::create([
            'permission_desc' => $value->permission_desc, 
          ]);
        }
    }
}
