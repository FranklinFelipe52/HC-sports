<?php

use App\Models\FederativeUnit;
use App\Models\Rule;
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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo', 100);
            $table->string('cpf', 15);
            $table->string('email', 50);
            $table->string('password', 100);
            $table->foreignIdFor(FederativeUnit::class)->nullable();
            $table->foreignIdFor(Rule::class);
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
        Schema::dropIfExists('admins');
    }
};
