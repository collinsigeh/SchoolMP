<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItempaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itempayments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('enrolment_id')->nullable();// which enrolment (student) is connected to the payment, zero (0) for payments without enrolment ties
            $table->integer('item_id')->nullable();// which item/fee is connected to the payment, zero (0) for payments without item/fee ties
            $table->integer('term_id');
            $table->integer('school_id');
            $table->string('currency_symbol', 25);
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['Offline (Cash)', 'Offline (Bank deposit)', 'Online']);
            $table->string('special_note')->nullable();
            $table->enum('status', ['Pending', 'Declined', 'Confirmed']);
            $table->integer('user_id'); //confirmed/entered by zero (0) is for system
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
        Schema::dropIfExists('itempayments');
    }
}
