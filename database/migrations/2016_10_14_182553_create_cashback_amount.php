<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashbackAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->float('offer_cashback_amount')->nullable();
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->float('store_cashback_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn('offer_cashback_amount');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('store_cashback_amount');
        });
    }
}
