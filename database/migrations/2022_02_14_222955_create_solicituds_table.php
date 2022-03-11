<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id('idSol');
            $table->string('rutaSol')->nullable();
            $table->string('uuid');
            $table->time('horaIni')->comment('Hora de inicio');
            $table->time('horaFin')->comment('Hora de fin');
            $table->date('fecha')->comment('Fecha de solicitud');
            $table->unsignedBigInteger('idSal');
            $table->unsignedBigInteger('idEst');
            $table->unsignedBigInteger('idPer');
            $table->foreign('idSal')->references('idSala')->on('sala');
            $table->foreign('idEst')->references('idEst')->on('estatus');
            $table->foreign('idPer')->references('idPer')->on('persona');
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
        Schema::dropIfExists('solicitud');
    }
}
