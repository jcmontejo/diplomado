<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('enrollment');
            $table->string('curp')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('mother_last_name', 50)->nullable();
            $table->string('facebook');
            $table->text('interested');
            $table->date('birthdate')->nullable();
            $table->char('sex',2)->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('state',250)->nullable();
            $table->string('city',250)->nullable();
            $table->text('address')->nullable();
            $table->string('email')->nullable();
            $table->string('profession')->nullable();
            $table->boolean('documents')->nullable();
            $table->string('status');
            $table->string('color');
            $table->integer('keep_going')->default('1');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('students');
    }
}
