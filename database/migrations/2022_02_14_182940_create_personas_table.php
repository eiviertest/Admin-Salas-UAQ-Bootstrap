<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id('idPer');
            $table->string('nomPer', 50);
            $table->string('apePatPer', 30);
            $table->string('apeMatPer', 30);
            $table->bigInteger('telPer');
            $table->foreignId('idUsr');
            $table->foreignId('idArea');
            $table->foreign('idUsr')->references('id')->on('users');
            $table->foreign('idArea')->references('idArea')->on('area');
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
        Schema::dropIfExists('persona');
    }
}
