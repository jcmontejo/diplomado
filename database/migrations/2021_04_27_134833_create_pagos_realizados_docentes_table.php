<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosRealizadosDocentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_realizados_docentes', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monto_pagado');
            $table->date('fecha_pago');
            $table->integer('docente_id');
            $table->integer('diplomado_id');
            $table->integer('generacion_id');
            $table->integer('pago_docentes_id');
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
        Schema::dropIfExists('pagos_realizados_docentes');
    }
}
