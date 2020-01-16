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
            $table->unsignedBigInteger('fk_municipalities');
            $table->string('clave', 4);
            $table->string('name');
            $table->string('latitud');
            $table->string('longitud');
            $table->string('altitud');
            $table->string('carta');
            $table->string('ambito');
            $table->bigInteger('poblacion');
            $table->bigInteger('masculino');
            $table->bigInteger('femenino');
            $table->bigInteger('viviendas');
            $table->string('lat');
            $table->string('lng');
            $table->integer('activo');
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
