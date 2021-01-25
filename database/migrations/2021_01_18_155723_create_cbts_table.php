<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cbts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->integer('subject_id');
            $table->integer('term_id');
            $table->enum('type', ['Practice Quiz', '1st Test', '2nd Test', '3rd Test', 'Exam']);
            $table->string('name');
            $table->integer('no_questions'); //min is one (1) max is one hundred (100)
            $table->integer('duration');//in minutes
            $table->enum('termly_score', ['No', 'Yes']); // whether to use as the termly score or not
            $table->integer('no_attempts'); // zero (0) for infinit attempts
            $table->string('supervisor_pass')->nullable();//empty or length of zero (0) if supervisor is not required.
            $table->integer('user_id');
            $table->enum('status', ['Pending Approval', 'Approved', 'Rejected']);
            $table->integer('approved_by');
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
        Schema::dropIfExists('cbts');
    }
}
