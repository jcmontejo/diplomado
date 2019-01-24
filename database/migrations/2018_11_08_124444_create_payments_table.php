<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('concept');
            $table->integer('number_payment');
            $table->date('date')->nullable();
            $table->float('amount_paid', 8, 2);
            $table->integer('student_id');
            $table->integer('generation_id');
            $table->integer('diplomat_id');
            $table->string('status')->default('PENDIENTE');
            $table->integer('income_id')->nullable();
            $table->unsignedInteger('debt_id');

            $table->foreign('debt_id')->references('id')->on('debts');
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
        Schema::dropIfExists('payments');
    }
}
