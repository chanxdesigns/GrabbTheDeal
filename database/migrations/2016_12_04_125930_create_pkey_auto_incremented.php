<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePkeyAutoIncremented extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->primary('id');
            $table->increments('id')->change();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->primary('category_id');
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->primary('offer_id');
        });
        Schema::table('parent_categories', function (Blueprint $table) {
            $table->primary('category_id');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->primary('slider_id');
            $table->increments('slider_id')->change();
        });
        Schema::table('store_offers', function (Blueprint $table) {
            $table->primary('offer_id');
        });
        Schema::table('stores', function (Blueprint $table) {
            $table->primary('store_id');
        });
        Schema::table('todays_deals', function (Blueprint $table) {
            $table->primary('deal_id');
            $table->increments('deal_id')->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->primary('user_id');
        });
        Schema::table('users_account_info', function (Blueprint $table) {
            $table->primary('user_id');
        });
        Schema::table('users_activities', function (Blueprint $table) {
            $table->primary('id');
            $table->increments('id')->change();
        });
        Schema::table('users_bonus', function (Blueprint $table) {
            $table->primary('id');
            $table->increments('id')->change();
        });
        Schema::table('users_referrals', function (Blueprint $table) {
            $table->primary('id');
            $table->increments('id')->change();
        });
        Schema::table('users_withdrawals', function (Blueprint $table) {
            $table->primary('id');
            $table->increments('id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->increments('id')->change();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->dropPrimary('category_id');
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->dropPrimary('offer_id');
        });
        Schema::table('parent_categories', function (Blueprint $table) {
            $table->dropPrimary('category_id');
        });
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropPrimary('slider_id');
            $table->increments('slider_id')->change();
        });
        Schema::table('store_offers', function (Blueprint $table) {
            $table->dropPrimary('offer_id');
        });
        Schema::table('stores', function (Blueprint $table) {
            $table->dropPrimary('store_id');
        });
        Schema::table('todays_deals', function (Blueprint $table) {
            $table->dropPrimary('deal_id');
            $table->integer('deal_id')->change();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropPrimary('user_id');
        });
        Schema::table('users_account_info', function (Blueprint $table) {
            $table->dropPrimary('user_id');
        });
        Schema::table('users_activities', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->integer('id')->change();
        });
        Schema::table('users_bonus', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->integer('id')->change();
        });
        Schema::table('users_referrals', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->integer('id')->change();
        });
        Schema::table('users_withdrawals', function (Blueprint $table) {
            $table->dropPrimary('id');
            $table->integer('id')->change();
        });
    }
}
