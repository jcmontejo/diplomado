<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionSeminarioGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripcion_seminario_grupos', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('descuento',);
            $table->decimal('costo_final',);
            $table->decimal('primer_pago',);
            $table->integer('numero_de_pagos');
            $table->decimal('monto_de_pagos');
            $table->integer('metodo_de_pago');
            $table->text('comentarios')->nullable();
            $table->integer('id_vendedor');
            $table->boolean('activo')->default(true);

            $table->unsignedInteger('seminario_id')->unsigned();
            $table->foreign('seminario_id')
            ->references('id')->on('seminarios')
            ->onDelete('cascade');
            $table->unsignedInteger('grupo_id')->unsigned();
            $table->foreign('grupo_id')
            ->references('id')->on('grupo_seminarios')
            ->onDelete('cascade');
            $table->unsignedInteger('student_id')->unsigned();
            $table->foreign('student_id')
            ->references('id')->on('students')
            ->onDelete('cascade');
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
        Schema::dropIfExists('inscripcion_seminario_grupos');
    }
}
