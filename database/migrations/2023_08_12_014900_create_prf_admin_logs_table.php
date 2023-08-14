<?php

use App\Models\PrfAdmin;
use App\Models\TypeActionsAdmin;
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
        Schema::create('prf_admin_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TypeActionsAdmin::class);
            $table->foreignIdFor(PrfAdmin::class);
            $table->string('description', 500);
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
        Schema::dropIfExists('prf_admin_logs');
    }
};
