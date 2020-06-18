<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->integer('term_id');
            $table->integer('enrolment_id');
            $table->integer('classsubject_id');
            $table->integer('resulttemplate_id');
            $table->integer('subject_1st_test_score');
            $table->enum('first_score_by', ['No one', 'Teacher', 'System']);
            $table->integer('subject_2nd_test_score');
            $table->enum('second_score_by', ['No one', 'Teacher', 'System']);
            $table->integer('subject_3rd_test_score');
            $table->enum('third_score_by', ['No one', 'Teacher', 'System']);
            $table->integer('subject_exam_score');
            $table->enum('assignment_score_by', ['No one', 'Teacher', 'System']);
            $table->integer('assignment_exam_score');
            $table->enum('exam_score_by', ['No one', 'Teacher', 'System']);
            $table->integer('classteachercomment_by');
            $table->string('classteacher_comment');
            $table->integer('principalcomment_by');
            $table->string('principal_comment');
            $table->enum('status', ['Pending', 'Pending Aproval' , 'NOT Approved', 'Approved']);
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
        Schema::dropIfExists('results');
    }
}
