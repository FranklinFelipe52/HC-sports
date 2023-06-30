<?php

use App\Models\PrfRegistration;
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
        Schema::create('prf_log_payments', function (Blueprint $table) {
            $table->id();
            $table->string('id_payment')->nullable();
            $table->string('amount')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('prf_log_payments');
    }
};
