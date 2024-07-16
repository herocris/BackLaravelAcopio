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
        Schema::create('bien_informe', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bien_id')->nullable();

            $table->foreign('bien_id')
            ->references('id')
            ->on('biens');

            $table->unsignedBigInteger('informe_id')->nullable();

            $table->foreign('informe_id')
            ->references('id')
            ->on('informes');

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
        Schema::dropIfExists('bien_informe');
    }
};
