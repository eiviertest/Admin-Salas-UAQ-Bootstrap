<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursoPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_persona', function (Blueprint $table) {
            $table->primary(['idCur', 'idPer']);
            $table->unsignedBigInteger('idCur');
            $table->unsignedBigInteger('idPer');
            $table->string('estatus', 30)->default('En proceso');
            $table->foreign('idCur')->references('idCur')->on('curso');
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
        Schema::dropIfExists('curso_persona');
    }
}
