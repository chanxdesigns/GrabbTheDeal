<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeCashbackNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers', function ($table) {
           $table->float('offer_cashback')->nullable()->change();
        });

        Schema::table('stores', function ($table) {
            $table->float('store_cashback')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers', function ($table) {
            $table->float('offer_cashback');
        });

        Schema::table('stores', function ($table) {
            $table->float('store_cashback');
        });
    }
}
