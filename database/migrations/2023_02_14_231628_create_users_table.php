<?php

use App\Models\Address;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo', 100)->nullable();
            $table->date('data_nasc');
            $table->string('cpf', 15);
            $table->string('email', 50);
            $table->string('password', 100)->nullable();
            $table->boolean('is_pcd')->nullable();
            $table->string('sexo', 1);
            $table->boolean('registered');
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
        Schema::dropIfExists('users');
    }
};
