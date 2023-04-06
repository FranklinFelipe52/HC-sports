<?php

use App\Models\group_category;
use App\Models\Modalities;
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
        Schema::create('modalities_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('max_total')->nullable();
            $table->integer('max_f')->nullable();
            $table->integer('max_m')->nullable();
            $table->integer('min_year')->nullable();
            $table->foreignIdFor(Modalities::class);
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
        Schema::dropIfExists('modalities_categories');
    }
};
