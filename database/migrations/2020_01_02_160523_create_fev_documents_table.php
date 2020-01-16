<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFevDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('src_document');
            $table->string('status_document');
            $table->string('validity');
            $table->unsignedBigInteger('fk_users');
            $table->unsignedBigInteger('fk_documents_type');
            $table->timestamps();
            $table->foreign('fk_users')->references('id')->on('users');
            $table->foreign('fk_documents_type')->references('id')->on('documents_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
