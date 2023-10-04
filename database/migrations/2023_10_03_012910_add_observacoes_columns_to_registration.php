<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prf_registrations', function (Blueprint $table) {
            $table->string('observacao_estorno', 250)->nullable();
            $table->string('observacao_cancelamento', 250)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prf_registrations', function (Blueprint $table) {
            $table->dropColumn('observacao_estorno');
            $table->dropColumn('observacao_cancelamento');
        });
    }
};
