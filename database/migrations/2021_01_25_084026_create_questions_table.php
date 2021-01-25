<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->integer('subject_id');
            $table->integer('term_id');
            $table->integer('cbt_id');
            $table->integer('prev_question');
            $table->integer('next_question');
            $table->text('question');
            $table->string('question_photo')->nullable();
            $table->text('option_a');
            $table->string('option_a_photo')->nullable();
            $table->text('option_b');
            $table->string('option_b_photo')->nullable();
            $table->text('option_c')->nullable();
            $table->string('option_c_photo')->nullable();
            $table->text('option_d')->nullable();
            $table->string('option_d_photo')->nullable();
            $table->text('option_e')->nullable();
            $table->string('option_e_photo')->nullable();
            $table->enum('correct_option', ['A', 'B', 'C', 'D', 'E']);
            $table->integer('user_id');
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
        Schema::dropIfExists('questions');
    }
}
