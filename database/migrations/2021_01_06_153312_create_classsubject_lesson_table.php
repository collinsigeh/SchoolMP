<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasssubjectLessonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classsubject_lesson', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('classsubject_id')->unsigned()->foreign('classsubject_id')->references('id')->on('classubjects');
            $table->integer('lesson_id')->unsigned()->foreign('lesson_id')->references('id')->on('lessons');
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
        Schema::dropIfExists('classsubject_lesson');
    }
}
