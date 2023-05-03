<?php

namespace Database\Seeders;

use App\Models\TypeActionsAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TypeActionsAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('json/type_actions_admin.json'));
        $type_actions_admin = json_decode($json);
    
        foreach ($type_actions_admin as $value) {
          TypeActionsAdmin::create([
            "type" => $value->type
          ]);
        } 
    }
}
