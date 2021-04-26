<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoRecibidoSeminariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_recibido_seminarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero_de_pago');
            $table->date('fecha_pago');
            $table->decimal('monto_recibido');
            $table->integer('metodo_de_pago');
            $table->integer('cuenta_destino');

            $table->unsignedInteger('inscripcion_id')->unsigned();
            $table->foreign('inscripcion_id')
            ->references('id')->on('inscripcion_seminario_grupos')
            ->onDelete('cascade');

            $table->unsignedInteger('deuda_id')->unsigned();
            $table->foreign('deuda_id')
            ->references('id')->on('deuda_seminarios')
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
        Schema::dropIfExists('pago_recibido_seminarios');
    }
}
