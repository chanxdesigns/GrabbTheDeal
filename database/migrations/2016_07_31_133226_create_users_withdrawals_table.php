<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_withdrawals', function (Blueprint $table) {
           $table->integer('id');
			$table->uuid('user_id');
			$table->string('withdrawal_channel');
			$table->integer('amount');
			$table->string('bank_reference_number')->nullable();
			$table->string('status');
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
        Schema::dropIfExists('users_withdrawals');
    }
}
