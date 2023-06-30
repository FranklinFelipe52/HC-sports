<?php

use App\Models\PrfUser;
use App\Models\StatusNotificatios;
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
        Schema::create('prf_actions_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PrfUser::class);
            $table->foreignIdFor(StatusNotificatios::class);
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
        Schema::dropIfExists('prf_actions_notifications');
    }
};
