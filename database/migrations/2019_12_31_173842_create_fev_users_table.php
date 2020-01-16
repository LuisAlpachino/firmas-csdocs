<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFevUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name');
            $table->string('last_name');
            $table->string('second_last_name');
            $table->string('rfc');
            $table->String('curp');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('user_type');
            $table->integer('genders');
            $table->string('keycer');
            $table->string('keyprivate');
            $table->string('keypublic');
            $table->rememberToken();
            $table->String('api_token', 60)->unique();
            $table->unsignedBigInteger('telephone');
            $table->unsignedBigInteger('fk_localities');
            $table->unsignedBigInteger('fk_user_status');
            $table->timestamps();
            $table->foreign('fk_localities')->references('id')->on('localities');
            $table->foreign('fk_user_status')->references('id')->on('user_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
