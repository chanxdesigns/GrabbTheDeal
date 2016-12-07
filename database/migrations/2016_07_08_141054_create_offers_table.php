<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->integer('offer_id');
            $table->string('offer_store_id');
            $table->string('offer_name');
            $table->text('offer_details');
            $table->string('offer_coupon_code')->nullable();
            $table->integer('offer_cashback');
            $table->boolean('offer_verified');
            $table->boolean('offer_featured');
            $table->string('offer_link');
            $table->date('offer_validity');
            $table->string('offer_store_logo');
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
        Schema::dropIfExists('offers');
    }
}
