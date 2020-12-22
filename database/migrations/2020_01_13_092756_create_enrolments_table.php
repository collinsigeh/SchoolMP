<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrolmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('subscription_id');
            $table->integer('user_id');
            $table->integer('student_id');
            $table->integer('term_id');
            $table->integer('arm_id');
            $table->integer('schoolclass_id');
            $table->integer('school_id');
            $table->enum('fee_status', ['Unpaid', 'Partly-paid', 'Completely-paid']);
            $table->integer('fee_update_by');
            $table->enum('access_exam', ['No', 'Yes']);
            $table->enum('access_ca', ['No', 'Yes']);
            $table->enum('access_assignment', ['No', 'Yes']);
            $table->enum('access_result', ['No', 'Yes']);
            $table->integer('access_update_by');
            $table->enum('status', ['Active', 'Inactive']);
            $table->integer('classteachercomment_by')->nullable();
            $table->string('classteacher_comment')->nullable();
            $table->integer('principalcomment_by')->nullable();
            $table->string('principal_comment')->nullable();
            $table->enum('result_status', ['Pending', 'Pending Aproval' , 'NOT Approved', 'Approved']);
            $table->integer('next_class')->nullable();
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
        Schema::dropIfExists('enrolments');
    }
}
