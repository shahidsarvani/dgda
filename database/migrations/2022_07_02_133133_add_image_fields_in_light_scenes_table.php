<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageFieldsInLightScenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('light_scenes', function (Blueprint $table) {
            //
            $table->text('image_en');
            $table->text('image_ar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('light_scenes', function (Blueprint $table) {
            //
            $table->dropColumn('image_en');
            $table->dropColumn('image_ar');
        });
    }
}
