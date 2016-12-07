<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConversionTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking', function (Blueprint $table) {
            $table->string('offer_id');
            $table->string('source')->nullable();
            $table->string('payout');
            $table->string('transaction_id');
            $table->string('store_id');
            $table->longText('aff_sub_1')->nullable();
            $table->longText('aff_sub_2')->nullable();
            $table->longText('aff_sub_3')->nullable();
            $table->longText('aff_sub_4')->nullable();
            $table->longText('aff_sub_5')->nullable();
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
        Schema::dropIfExists('tracking');
    }
}
