<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_bairro', function (Blueprint $table) {
            $table->id('codigo_bairro');
            $table->string('nome', 128);
            $table->integer('status');

            $table->unsignedBigInteger('codigo_municipio');

            $table->foreign('codigo_municipio')->references('codigo_municipio')->on('tb_municipio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bairro');
    }
};
