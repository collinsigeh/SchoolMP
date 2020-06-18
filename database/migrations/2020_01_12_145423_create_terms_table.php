<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->integer('subscription_id');
            $table->string('session', 10);
            $table->enum('name', ['1st Term', '2nd Term', '3rd Term', 'Summer Classes', 'Special Classes']);
            $table->integer('no_of_weeks');
            $table->string('resumption_date', 25);
            $table->string('closing_date', 25);
            $table->string('next_term_resumption_date', 25)->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('terms');
    }
}
