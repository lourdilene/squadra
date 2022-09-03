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
        Schema::create('tb_pessoa', function (Blueprint $table) {
            $table->id('codigo_pessoa');
            $table->string('nome', 128);
            $table->string('sobrenome', 128);
            $table->integer('idade');
            $table->string('login', 128);
            $table->string('senha', 128);
            $table->integer('status');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_pessoa');
    }
};
