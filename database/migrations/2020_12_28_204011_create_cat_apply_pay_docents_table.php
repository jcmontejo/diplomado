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
            $table->integer('number');
            $table->date('date')->nullable();
            $table->decimal('amount_expected', 18,2)->nullable();
            $table->decimal('amount_paid_out', 18,2)->nullable();
            $table->decimal('rest', 18,2)->nullable();
            $table->integer('status')->default(1);
            
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
