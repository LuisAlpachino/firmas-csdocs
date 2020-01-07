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
            $table->char('curp');
            $table->integer('user_type');
            $table->integer('genders');
            $table->integer('telephone');
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
