<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFevDataHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fk_users');
            $table->string('History_action');
            $table->dateTime('date_history');
            $table->string('situation');
            $table->timestamps();
            $table->foreign('fk_users')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_history');
    }
}
