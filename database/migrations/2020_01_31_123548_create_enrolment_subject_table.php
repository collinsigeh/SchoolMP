<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrolmentSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolment_subject', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('enrolment_id')->unsigned()->foreign('enrolment_id')->references('id')->on('enrolments');
            $table->integer('subject_id')->unsigned()->foreign('subject_id')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrolment_subject');
    }
}
