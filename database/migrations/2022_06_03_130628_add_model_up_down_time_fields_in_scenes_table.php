<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelUpDownTimeFieldsInScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scenes', function (Blueprint $table) {
            //
            $table->integer('model_up_delay')->nullable();
            $table->integer('model_down_delay')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scenes', function (Blueprint $table) {
            //
            $table->dropColumn('model_up_delay');
            $table->dropColumn('model_down_delay');
        });
    }
}
