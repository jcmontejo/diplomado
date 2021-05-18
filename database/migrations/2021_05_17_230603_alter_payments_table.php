<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('convenio')->after('status')->nullable();
            $table->date('fecha_pago_convenio')->after('convenio')->nullable();
            $table->decimal('monto_convenio')->after('fecha_pago_convenio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('convenio');
            $table->dropColumn('fecha_pago_convenio');
            $table->dropColumn('monto_convenio');
        });
    }
}
