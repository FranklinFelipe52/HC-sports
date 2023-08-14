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
        Schema::table('prf_users', function (Blueprint $table) {
            $table->tinyInteger('is_servidor')->default(0);
            $table->string('servidor_matricula')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prf_users', function (Blueprint $table) {
            $table->dropColumn('is_servidor');
            $table->dropColumn('servidor_matricula');
        });
    }
};
