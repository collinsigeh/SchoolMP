<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('school_id');
            $table->string('number', 25);
            $table->string('name');
            $table->integer('product_id');
            $table->integer('package_id');
            $table->enum('type', ['Purchase', 'Upgrade']);
            $table->enum('payment', ['Prepaid', 'Post-paid', 'Trial']);
            $table->enum('price_type', ['Per-student', 'Per-package']);
            $table->decimal('price', 10, 2);
            $table->string('currency_symbol', 25);
            $table->decimal('total_price', 10, 2);
            $table->decimal('discount', 10, 2);
            $table->decimal('final_price', 10, 2);
            $table->decimal('school_asking_price', 10, 2);
            $table->string('term_limit', 25);
            $table->string('day_limit', 25);
            $table->string('student_limit', 25);
            $table->string('expiry',15);
            $table->enum('status', ['Pending', 'Paid', 'Completed']);
            $table->integer('subscription_id');
            $table->string('subscription_due_date', 15)->nullable();
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
        Schema::dropIfExists('orders');
    }
}
