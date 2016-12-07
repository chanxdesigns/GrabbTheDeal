<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_bonus', function (Blueprint $table) {
            $table->integer('id');
            $table->uuid('user_id');
            $table->integer('bonus_amount');
            $table->string('bonus_type');
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
        Schema::dropIfExists('users_bonus');
    }
}
