<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenerationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('generations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_diplomat');
            $table->integer('number_generation');
            $table->integer('number_students')->nullable();
            $table->integer('cost');
            $table->date('start_date');
            $table->string('commision');
            $table->string('full_price');
            $table->boolean('status');
            $table->string('docent');
            $table->integer('docent_id');
            $table->unsignedInteger('diplomat_id');

            $table->foreign('diplomat_id')->references('id')->on('diplomats');
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
        Schema::dropIfExists('generations');
    }
}
