<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFevLocalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localities', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name',90);
            $table->char('zip_code', 5)->nullable();
            $table->string('tipo_asentamiento', 50);
            $table->string('city',50)->nullable();
            $table->string('zona',50)->nullable();
            $table->string('clave_ciudad',5)->nullable();
            $table->unsignedBigInteger('fk_municipalities');
            //$table->integer('zip_code');

            $table->timestamps();
            $table->foreign('fk_municipalities')->references('id')->on('municipalities');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localities');
    }
}
