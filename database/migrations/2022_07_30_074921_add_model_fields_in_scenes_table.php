<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddModelFieldsInScenesTable extends Migration
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
            $table->integer('model_up_delay_ar')->nullable();
            $table->integer('model_down_delay_ar')->nullable();
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
            $table->dropColumn('model_up_delay_ar');
            $table->dropColumn('model_down_delay_ar');
        });
    }
}
