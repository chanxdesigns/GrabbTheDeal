<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSliderExtraColumnsExpiryMainSub extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
           $table->boolean('main_featured')->nullable();
           $table->boolean('sub_featured')->nullable();
            $table->dateTime('expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('main_featured');
            $table->dropColumn('sub_featured');
            $table->dropColumn('expiry');
        });
    }
}
