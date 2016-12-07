<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTodaysDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todays_deals', function (Blueprint $table) {
            $table->integer('deal_id');
            $table->string('deal_name');
            $table->text('deal_details');
            $table->string('deal_img');
            $table->text('deal_link');
            $table->string('deal_store');
            $table->timestamp('deal_expiry');
            $table->float('deal_old_price')->nullable();
            $table->float('deal_new_price')->nullable();
            $table->float('deal_cashback_amount')->nullable();
            $table->float('deal_cashback')->nullable();
            $table->float('deal_discount')->nullable();
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
        Schema::dropIfExists('todays_deals');
    }
}
