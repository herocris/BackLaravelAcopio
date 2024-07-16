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
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuariocreador_id')->nullable();

            $table->foreign('usuariocreador_id')
            ->references('id')
            ->on('users');

            $table->string('titulo');
            $table->unsignedBigInteger('producto_id')->nullable();

            $table->foreign('producto_id')
            ->references('id')
            ->on('productos');

            $table->datetime('fechainicioevento');
            $table->datetime('fechafinalevento');
            $table->unsignedBigInteger('municipio_id')->nullable();

            $table->foreign('municipio_id')
            ->references('id')
            ->on('municipios');

            $table->string('situacionactual');
            $table->unsignedBigInteger('usuarioeditor_id')->nullable();

            $table->foreign('usuarioeditor_id')
            ->references('id')
            ->on('users');

            $table->string('palabraclave');

            $table->unsignedBigInteger('agente_id')->nullable();

            $table->foreign('agente_id')
            ->references('id')
            ->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informes');
    }
};
