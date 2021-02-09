<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attempts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->integer('subject_id');
            $table->integer('term_id');
            $table->integer('cbt_id');
            $table->integer('enrolment_id');
            $table->integer('total_correct');// number of questions gotten correctly, zero (0) as default.
            $table->enum('status', ['NOT Completed', 'Completed']);
            $table->integer('user_id'); // for the person who supervises this cbt attempt, zero (0) as default.
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
        Schema::dropIfExists('attempts');
    }
}
