<?php

use App\Models\FederativeUnit;
use App\Models\PrfUser;
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
        Schema::create('caern_adresses', function (Blueprint $table) {
            $table->id();
            $table->string('cep', 80);
            $table->string('rua');
            $table->string('cidade');
            $table->string('bairro');
            $table->integer('number');
            $table->foreignIdFor(FederativeUnit::class);
            $table->string('complemento')->nullable();
            $table->foreignIdFor(PrfUser::class);
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
        Schema::dropIfExists('caern_adresses');
    }
};
