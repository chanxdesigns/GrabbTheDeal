<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFkeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('parent')->references('category_id')->on('parent_categories')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('category_offers', function (Blueprint $table) {
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('offer_id')->references('offer_id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('offer_validity')->references('offer_validity')->on('offers')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('category_stores', function (Blueprint $table) {
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('store_id')->references('store_id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('parent_category_offers', function (Blueprint $table) {
            $table->foreign('category_id')->references('category_id')->on('parent_categories')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->foreign('slider_store')->references('store_id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('store_offers', function (Blueprint $table) {
            $table->foreign('store_id')->references('store_id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('offer_id')->references('offer_id')->on('offers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('offer_validity')->references('offer_validity')->on('offers')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('todays_deals', function (Blueprint $table) {
            $table->foreign('deal_store')->references('store_id')->on('stores')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('users_account_info', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('users_activities', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('users_bonus', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('users_referrals', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('users_withdrawals', function (Blueprint $table) {
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('parent');
        });

        Schema::table('category_offers', function (Blueprint $table) {
            $table->dropForeign('category_id');
            $table->dropForeign('offer_id');
            $table->dropForeign('offer_validity');
        });

        Schema::table('category_stores', function (Blueprint $table) {
            $table->dropForeign('category_id');
            $table->dropForeign('store_id');
        });

        Schema::table('parent_category_offers', function (Blueprint $table) {
            $table->dropForeign('category_id');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropForeign('slider_store');
        });

        Schema::table('store_offers', function (Blueprint $table) {
            $table->dropForeign('store_id');
            $table->dropForeign('offer_id');
            $table->dropForeign('offer_validity');
        });

        Schema::table('todays_deals', function (Blueprint $table) {
            $table->dropForeign('deal_store');
        });

        Schema::table('users_account_info', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });

        Schema::table('users_activities', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });

        Schema::table('users_bonus', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });

        Schema::table('users_referrals', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });

        Schema::table('users_withdrawals', function (Blueprint $table) {
            $table->dropForeign('user_id');
        });
    }
}
