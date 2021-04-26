<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeudaSeminariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deuda_seminarios', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('monto');
            $table->boolean('activo')->default(true);
            
            $table->unsignedInteger('inscripcion_id')->unsigned();
            $table->foreign('inscripcion_id')
            ->references('id')->on('inscripcion_seminario_grupos')
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
        Schema::dropIfExists('deuda_seminarios');
    }
}
