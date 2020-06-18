<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->integer('order_id')->nullable();//which order is connected to the payment, zero (0) for payments without order ties
            $table->string('currency_symbol', 25);
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['Offline', 'Online']);
            $table->string('special_note')->nullable();
            $table->enum('status', ['Pending', 'Denied', 'Confirmed']);
            $table->integer('user_id'); //confirmed by zero (0) is for system
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
