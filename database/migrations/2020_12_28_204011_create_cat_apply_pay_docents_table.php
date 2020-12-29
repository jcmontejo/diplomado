<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatApplyPayDocentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_apply_pay_docents', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->decimal('amount', 18,2);
            
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
        Schema::dropIfExists('cat_apply_pay_docents');
    }
}
