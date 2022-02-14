<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorarioCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario_curso', function (Blueprint $table) {
            $table->id('idHor');
            $table->time('horIn')->comment('Hora de inicio');
            $table->time('horFin')->comment('Hora de inicio');
            $table->unsignedBigInteger('idCur');
            $table->foreign('idCur')->references('idCur')->on('curso');
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
        Schema::dropIfExists('horario_curso');
    }
}
