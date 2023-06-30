<?php

use App\Models\PrfCategorys;
use App\Models\PrfPace;
use App\Models\PrfPackage;
use App\Models\PrfUser;
use App\Models\status_regitration;
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
        Schema::create('prf_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(PrfUser::class);
            $table->foreignIdFor(PrfCategorys::class);
            $table->foreignIdFor(PrfPackage::class)->nullable();
            $table->foreignIdFor(PrfPace::class);
            $table->foreignIdFor(status_regitration::class);
            $table->string('size_tshirt');
            $table->string('equipe');
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
        Schema::dropIfExists('prf_registrations');
    }
};
