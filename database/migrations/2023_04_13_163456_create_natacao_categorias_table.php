<?php

use App\Models\modalities_category;
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
        Schema::create('natacao_categorias', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(registration::class);
            $table->foreignIdFor(modalities_category::class);
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
        Schema::dropIfExists('natacao_categorias');
    }
};
