<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('school_id');
            $table->string('registration_number', 75);
            $table->string('hobbies');
            $table->enum('ailment', ['No', 'Yes']);
            $table->enum('disability', ['No', 'Yes']);
            $table->enum('medication', ['No', 'Yes']);
            $table->string('health_detail')->nullable();
            $table->string('date_of_birth', 25);
            $table->string('phone', 25)->nullable();
            $table->string('nationality', 75);
            $table->string('state_of_origin', 75)->nullable();
            $table->string('lga_of_origin', 75)->nullable();
            $table->enum('religion', ['Christianity', 'Islam', 'Judaism', 'Other religion']);
            $table->string('last_school_attended', 100)->nullable();
            $table->string('last_class_passed', 25)->nullable();
            $table->integer('schoolclass_id');
            $table->enum('status', ['Active', 'Inactive']);
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
        Schema::dropIfExists('students');
    }
}
