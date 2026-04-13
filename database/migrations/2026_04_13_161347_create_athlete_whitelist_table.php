<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('athlete_whitelist', function (Blueprint $table) {
            $table->id();
            $table->string('document')->unique()->comment('CPF ou CNPJ apenas dígitos');
            $table->enum('type', ['cpf', 'cnpj']);
            $table->unsignedInteger('max_registrations')->nullable()->comment('null = sem limite');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('athlete_whitelist');
    }
};
