<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('term_id');
            $table->integer('school_id');
            $table->string('currency_symbol', 25);
            $table->decimal('amount', 10, 2);
            $table->string('description', 191);
            $table->string('receipient_name', 191);
            $table->string('receipient_phone', 25)->nullable();
            $table->integer('user_id');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
