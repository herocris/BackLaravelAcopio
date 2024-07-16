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
        Schema::create('relaciones_interpersonales', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('relacionpersonal_id')->nullable();

            $table->foreign('relacionpersonal_id')
            ->references('id')
            ->on('relaciones_personales');

            $table->unsignedBigInteger('persona_id')->nullable();

            $table->foreign('persona_id')
            ->references('id')
            ->on('personas');

            $table->unsignedBigInteger('relacionpersona_id')->nullable();

            $table->foreign('relacionpersona_id')
            ->references('id')
            ->on('personas');

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
        Schema::dropIfExists('relaciones_interpersonales');
    }
};
