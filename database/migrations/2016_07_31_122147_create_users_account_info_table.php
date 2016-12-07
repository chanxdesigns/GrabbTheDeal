<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersAccountInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_account_info', function (Blueprint $table) {
            $table->uuid('user_id');
			$table->integer('bonus_balance')->nullable();
			$table->integer('total_referred')->nullable();
			$table->integer('available_balance')->nullable();
			$table->integer('pending_balance')->nullable();
			$table->string('referral_code');
			$table->string('withdrawal_channel')->nullable();
			$table->string('bank_account_name')->nullable();
			$table->string('bank_account_number')->nullable();
			$table->string('bank_name')->nullable();
			$table->string('bank_ifsc_code')->nullable();
			$table->string('bank_address')->nullable();
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
        Schema::dropIfExists('users_account_info');
    }
}
