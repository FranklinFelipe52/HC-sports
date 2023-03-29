<?php

namespace Database\Seeders;

use App\Models\permissions;
use App\Models\Rule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RulesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
    $rule_adm_geral = Rule::find(1);
    $rule_adm_geral->permissions()->save(permissions::find(1));
    $rule_adm_geral->permissions()->save(permissions::find(2));
    $rule_adm_geral->permissions()->save(permissions::find(3));
    $rule_adm_geral->permissions()->save(permissions::find(4));
    $rule_adm_geral->permissions()->save(permissions::find(5));
    $rule_adm_geral->save();

    $rule_adm_fe = Rule::find(2);
    $rule_adm_fe->permissions()->save(permissions::find(1));
    $rule_adm_fe->permissions()->save(permissions::find(2));
    $rule_adm_fe->permissions()->save(permissions::find(4));
    $rule_adm_fe->save();

    $rule_adm_avaliador = Rule::find(3);
    $rule_adm_avaliador->permissions()->save(permissions::find(4));
    $rule_adm_avaliador->save();
    }
}
