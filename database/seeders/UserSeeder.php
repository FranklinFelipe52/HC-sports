<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\FederativeUnit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 2; $i++) {
            $gender = ($i%2) == 0 ? "M" : "F";
            $user = User::create([
                'nome_completo'=> fake()->name(),
                'data_nasc' => fake()->date(),
                'cpf' => fake()->numberBetween(100000000, 90000000000),
                'is_pcd' => fake()->numberBetween(0, 1),
                'n_oab' => fake()->numberBetween(100000000, 90000000000),
                'sexo' => $gender,
                'email' => fake()->email(),
                'password' => base64_encode(fake()->name()),             
            ]);

            $addres = new Address;
            $addres->cidade = "Natal";
            $addres->federative_unit_id = 11;
            $addres->user_id = $user->id;
            $addres->save();
        }
    }
}
