<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->decimal('amount', 18,2);
            $table->string('concept');
            
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');

            $table->unsignedInteger('cat_reference')->unsigned();
            $table->foreign('cat_reference')
            ->references('id')->on('cat_references')
            ->onDelete('cascade');

            $table->unsignedInteger('cat_clasification')->unsigned();
            $table->foreign('cat_clasification')
            ->references('id')->on('cat_clasifications')
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
        Schema::dropIfExists('cat_expenses');
    }
}
