<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoDocentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_docentes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_pago');
            $table->decimal('pago_por_estudiante')->nullable();
            $table->integer('total_estudiantes')->nullable();
            $table->decimal('pago_por_semana')->nullable();
            $table->integer('total_semanas')->nullable();
            $table->decimal('total_a_pagar')->nullable();
            $table->boolean('activo')->default(true);

            $table->unsignedInteger('generacion_id')->unsigned();
            $table->foreign('generacion_id')
            ->references('id')->on('generations')
            ->onDelete('cascade');

            $table->unsignedInteger('docente_id')->unsigned();
            $table->foreign('docente_id')
            ->references('id')->on('teachers')
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
        Schema::dropIfExists('pago_docentes');
    }
}
