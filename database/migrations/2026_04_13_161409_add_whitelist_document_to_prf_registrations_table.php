<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('prf_registrations', function (Blueprint $table) {
            $table->string('whitelist_document')->nullable()->after('prf_vauchers_id')
                ->comment('CPF ou CNPJ usado para validar acesso na whitelist');
        });
    }

    public function down()
    {
        Schema::table('prf_registrations', function (Blueprint $table) {
            $table->dropColumn('whitelist_document');
        });
    }
};
