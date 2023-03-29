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
            $table->string('titulo');
            $table->integer('min_f');
            $table->integer('min_m');
            $table->integer('min_year');
            $table->foreignIdFor(Modalities::class);
            $table->foreignIdFor(group_category::class);
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
