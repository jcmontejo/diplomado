<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStudentInscriptionsAddBajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_inscriptions', function (Blueprint $table) {
            $table->boolean('baja')->after('read')->nuallable();
            $table->date('fecha_baja')->after('baja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_inscriptions', function (Blueprint $table) {
            $table->dropColumn('baja');
            $table->dropColumn('fecha_baja');
        });
    }
}
