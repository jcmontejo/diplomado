<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('key_bank')->after('joining_date');
            $table->string('number_target_bank')->after('key_bank');
            $table->string('name_bank')->after('number_target_bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn('key_bank');
            $table->dropColumn('number_target_bank');
            $table->dropColumn('name_bank');
        });
    }
}
