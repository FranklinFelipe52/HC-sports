<?php

use App\Models\Modalities;
use App\Models\modalities_category;
use App\Models\Range;
use App\Models\status_regitration;
use App\Models\type_payment;
use App\Models\User;
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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Modalities::class);
            $table->foreignIdFor(Range::class)->nullable();
            $table->foreignIdFor(modalities_category::class);
            $table->foreignIdFor(status_regitration::class);
            $table->foreignIdFor(type_payment::class);
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
        Schema::dropIfExists('registrations');
    }
};
