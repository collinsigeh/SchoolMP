<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionattemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionattempts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->integer('term_id');
            $table->integer('cbt_id');
            $table->integer('enrolment_id');
            $table->integer('attempt_id');
            $table->integer('question_id');
            $table->enum('option_selected', ['A', 'B', 'C', 'D', 'E']);
            $table->enum('option_status', ['Right', 'Wrong']);
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
        Schema::dropIfExists('questionattempts');
    }
}
