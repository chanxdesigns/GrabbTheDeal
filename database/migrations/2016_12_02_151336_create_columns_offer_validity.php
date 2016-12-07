<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnsOfferValidity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_offers', function (Blueprint $table) {
           $table->dateTime('offer_validity')->nullable();
        });

        Schema::table('parent_category_offers', function (Blueprint $table) {
            $table->dateTime('offer_validity')->nullable();
        });

        Schema::table('store_offers', function (Blueprint $table) {
            $table->dateTime('offer_validity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_offers', function (Blueprint $table) {
            $table->dropColumn('offer_validity');
        });

        Schema::table('parent_category_offers', function (Blueprint $table) {
            $table->dropColumn('offer_validity');
        });

        Schema::table('store_offers', function (Blueprint $table) {
            $table->dropColumn('offer_validity');
        });
    }
}
