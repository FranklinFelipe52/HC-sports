<?php

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
        Schema::create('prf_users', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo', 100)->nullable();
            $table->date('data_nasc');
            $table->string('cpf', 15)->unique();
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->boolean('is_pcd')->nullable();
            $table->string('sexo', 1);
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
        Schema::dropIfExists('prf_users');
    }
};
