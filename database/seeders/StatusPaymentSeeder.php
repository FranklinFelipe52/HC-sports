<?php

namespace Database\Seeders;

use App\Models\status_payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class StatusPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get(database_path('json/status_payment.json'));
        $status_payments = json_decode($json);
    
        foreach ($status_payments as $value) {
          status_payment::create([
            "status" => $value->status
          ]);
        }
    }
}
