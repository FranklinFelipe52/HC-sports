<?php

use App\Models\modalities_category;
use App\Models\Range;
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
        Schema::create('range_has_modality_category', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(modalities_category::class);
            $table->foreignIdFor(Range::class);
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
        Schema::dropIfExists('range_has_modality_category');
    }
};
