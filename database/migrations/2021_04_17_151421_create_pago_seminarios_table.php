<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoSeminariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_seminarios', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monto');
            $table->date('fecha_de_pago');
            $table->integer('numero_de_pago');
            $table->boolean('activo')->default(true);

            $table->unsignedInteger('deuda_id')->unsigned();
            $table->foreign('deuda_id')
            ->references('id')->on('deuda_seminarios')
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
        Schema::dropIfExists('pago_seminarios');
    }
}
