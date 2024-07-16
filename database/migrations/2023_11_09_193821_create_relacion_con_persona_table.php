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
        Schema::create('relacion_con_persona', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('persona_id')->nullable();

            $table->foreign('persona_id')
            ->references('id')
            ->on('personas');

            $table->unsignedBigInteger('relacion_personal_id')->nullable();

            $table->foreign('relacion_personal_id')
            ->references('id')
            ->on('relacion_personals');

            $table->unsignedBigInteger('con_persona_id')->nullable();

            $table->foreign('con_persona_id')
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
        Schema::dropIfExists('relacion_con_persona');
    }
};
