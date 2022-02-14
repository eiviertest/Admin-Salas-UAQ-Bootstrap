<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso', function (Blueprint $table) {
            $table->id('idCur')->comment('Identificador autoincremental');
            $table->string('nomCur', 100)->comment('Nombre de curso');
            $table->date('fecInCur')->comment('Fecha inicio de curso');
            $table->date('fecFinCur')->comment('Fecha fin de curso');
            $table->string('reqCur', 100)->comment('Requisitos de curso');
            $table->integer('durCur')->comment('Duracion de curso');
            $table->boolean('estado');
            $table->integer('cupCur')->comment('Cupo de curso');
            $table->unsignedBigInteger('idSala');
            $table->foreign('idSala')->references('idSala')->on('sala');
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
        Schema::dropIfExists('curso');
    }
}
