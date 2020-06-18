<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasssubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classsubjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('term_id');
            $table->integer('arm_id');
            $table->integer('subject_id');
            $table->enum('type',  ['Compulsory', 'Elective']);
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
        Schema::dropIfExists('classsubjects');
    }
}
