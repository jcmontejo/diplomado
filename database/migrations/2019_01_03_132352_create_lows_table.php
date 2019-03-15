<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('reason');
            $table->text('comments')->nullable();
            
            $table->unsignedInteger('studentinscriptions_id');

            $table->foreign('studentinscriptions_id')
                ->references('id')
                ->on('student_inscriptions')
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
        Schema::dropIfExists('lows');
    }
}
