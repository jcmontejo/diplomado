<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentInscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_inscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->integer('diplomat_id');
            $table->integer('generation_id');
            $table->string('discount');
            $table->string('final_cost');
            $table->integer('first_payment');
            $table->integer('number_of_payments');
            $table->string('comments')->nullable();
            $table->string('status')->default('Alta');
            $table->string('amount_of_payments');
            $table->string('periodicity');
            $table->string('type_of_inscription');
            $table->integer('read')->default(0);
            $table->foreign('student_id')->references('id')->on('students');

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
        Schema::dropIfExists('student_inscriptions');
    }
}
