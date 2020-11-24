<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentvouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymentvouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pin');
            $table->integer('expiration_at')->nullable();
            $table->integer('package_id');
            $table->enum('status', ['Available', 'Used']);
            $table->enum('assigned_to', ['All', 'Order', 'Student']);
            $table->integer('id_assigned_to')->nullable();
            $table->integer('order_id')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('paymentvouchers');
    }
}
