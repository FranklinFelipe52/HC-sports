<?php

use App\Models\PrfRegistration;
use App\Models\PrfTshirt;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prf_tshirt_and_prf_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PrfTshirt::class);
            $table->foreignIdFor(PrfRegistration::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prf_tshirt_and_prf_registrations');
    }
};
