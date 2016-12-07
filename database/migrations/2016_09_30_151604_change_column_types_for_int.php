<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnTypesForInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_activities', function (Blueprint $table) {
            $table->float('estimated_cashback')->change();
        });

        Schema::table('users_account_info', function (Blueprint $table) {
            $table->float('bonus_balance')->change();
            $table->float('available_balance')->change();
            $table->float('pending_balance')->change();
        });

        Schema::table('users_bonus', function (Blueprint $table) {
            $table->float('bonus_amount')->change();
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->float('offer_cashback')->change();
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->float('store_cashback')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_activities', function (Blueprint $table) {
            $table->integer('estimated_cashback')->change();
        });

        Schema::table('users_account_info', function (Blueprint $table) {
            $table->integer('bonus_balance')->change();
            $table->integer('available_balance')->change();
            $table->integer('pending_balance')->change();
        });

        Schema::table('users_bonus', function (Blueprint $table) {
            $table->integer('bonus_amount')->change();
        });

        Schema::table('offers', function (Blueprint $table) {
            $table->integer('offer_cashback')->change();
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->integer('store_cashback')->change();
        });
    }
}
