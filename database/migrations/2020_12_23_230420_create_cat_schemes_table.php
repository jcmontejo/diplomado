<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatSchemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_schemes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_scheme');
            $table->decimal('cost_student')->nullable();
            $table->integer('students')->nullable();
            $table->decimal('total_payment_students', 18,2)->nullable();
            $table->decimal('cost_week')->nullable();
            $table->integer('weeks')->nullable();
            $table->decimal('total_payment_weeks', 18,2)->nullable();
            $table->decimal('total_pay')->nullable();
            $table->decimal('total_rest')->nullable();

            $table->unsignedInteger('generation_id')->unsigned();
            $table->foreign('generation_id')
            ->references('id')->on('generations')
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
        Schema::dropIfExists('cat_schemes');
    }
}
