<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResulttemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resulttemplates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->enum('ca_display', ['Summary', 'Breakdown']);
            $table->integer('subject_1st_test_max_score');
            $table->integer('subject_2nd_test_max_score');
            $table->integer('subject_3rd_test_max_score');
            $table->integer('subject_assignment_score');
            $table->integer('subject_exam_score');
            $table->string('grade_95_to_100', 25);
            $table->string('symbol_95_to_100', 5);
            $table->string('grade_90_to_94', 25);
            $table->string('symbol_90_to_94', 5);
            $table->string('grade_85_to_89', 25);
            $table->string('symbol_85_to_89', 5);
            $table->string('grade_80_to_84', 25);
            $table->string('symbol_80_to_84', 5);
            $table->string('grade_75_to_79', 25);
            $table->string('symbol_75_to_79', 5);
            $table->string('grade_70_to_74', 25);
            $table->string('symbol_70_to_74', 5);
            $table->string('grade_65_to_69', 25);
            $table->string('symbol_65_to_69', 5);
            $table->string('grade_60_to_64', 25);
            $table->string('symbol_60_to_64', 5);
            $table->string('grade_55_to_59', 25);
            $table->string('symbol_55_to_59', 5);
            $table->string('grade_50_to_54', 25);
            $table->string('symbol_50_to_54', 5);
            $table->string('grade_45_to_49', 25);
            $table->string('symbol_45_to_49', 5);
            $table->string('grade_40_to_44', 25);
            $table->string('symbol_40_to_44', 5);
            $table->string('grade_35_to_39', 25);
            $table->string('symbol_35_to_39', 5);
            $table->string('grade_30_to_34', 25);
            $table->string('symbol_30_to_34', 5);
            $table->string('grade_25_to_29', 25);
            $table->string('symbol_25_to_29', 5);
            $table->string('grade_20_to_24', 25);
            $table->string('symbol_20_to_24', 5);
            $table->string('grade_15_to_19', 25);
            $table->string('symbol_15_to_19', 5);
            $table->string('grade_10_to_14', 25);
            $table->string('symbol_10_to_14', 5);
            $table->string('grade_5_to_9', 25);
            $table->string('symbol_5_to_9', 5);
            $table->string('grade_0_to_4', 25);
            $table->string('symbol_0_to_4', 5);
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
        Schema::dropIfExists('resulttemplates');
    }
}
