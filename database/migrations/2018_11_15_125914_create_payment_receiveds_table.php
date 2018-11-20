<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_receiveds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('diplomat_id');
            $table->integer('generation_id');
            $table->integer('student_id');
            $table->date('date_payment');
            $table->string('observation')->nullable();
            $table->integer('payment_method');
            $table->integer('destination_account');
            $table->integer('account_type');
            $table->decimal('amount', 8, 2);
            $table->decimal('discount', 8, 2);
            $table->decimal('total', 8, 2);
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
        Schema::dropIfExists('payment_receiveds');
    }
}
