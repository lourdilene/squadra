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
        Schema::create('tb_endereco', function (Blueprint $table) {
            $table->id('codigo_endereco');
            $table->string('nome_rua', 128);
            $table->string('numero', 128);
            $table->string('complemento', 128);
            $table->string('cep', 128);

            $table->unsignedBigInteger('codigo_pessoa');

            $table->foreign('codigo_pessoa')->references('codigo_pessoa')->on('tb_pessoa');

            $table->unsignedBigInteger('codigo_bairro');

            $table->foreign('codigo_bairro')->references('codigo_bairro')->on('tb_bairro');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_enderecos');
    }
};
