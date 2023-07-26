<?php

use App\Models\PrfSizeTshirts;
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
        Schema::table('prf_registrations', function (Blueprint $table) {
            $table->dropColumn('prf_pace_id');
            $table->dropColumn('size_tshirt');
            $table->foreignIdFor(PrfSizeTshirts::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
