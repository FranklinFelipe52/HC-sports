<?php

use App\Models\Admin;
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
        Schema::create('actions_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TypeActionsAdmin::class);
            $table->foreignIdFor(Admin::class);
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
        Schema::dropIfExists('actions_admins');
    }
};
