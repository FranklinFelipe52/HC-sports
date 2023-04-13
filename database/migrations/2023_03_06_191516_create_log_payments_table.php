<?php

use App\Models\registration;
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
        Schema::create('log_payments', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('id_transaction');
            $table->string('id_payment');

            $table->foreignIdFor(registration::class);
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
        Schema::dropIfExists('log_payments');
    }
};
