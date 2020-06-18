<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('school_id');
            $table->string('designation', 75);
            $table->string('phone', 25);
            $table->string('address')->nullable();
            $table->string('qualification', 75)->nullable();
            $table->string('employee_number', 75);
            $table->string('employee_since', 25)->nullable();
            $table->enum('status', ['Active', 'Inactive']);
            $table->enum('manage_staff_account', ['No', 'Yes']);
            $table->enum('manage_students_account', ['No', 'Yes']);
            $table->enum('manage_students_promotion', ['No', 'Yes']);
            $table->enum('manage_students_privileges', ['No', 'Yes']);
            $table->enum('manage_guardians', ['No', 'Yes']);
            $table->enum('manage_session_terms', ['No', 'Yes']);
            $table->enum('manage_class_arms', ['No', 'Yes']);
            $table->enum('manage_subjects', ['No', 'Yes']);
            $table->enum('manage_requests', ['No', 'Yes']);
            $table->enum('manage_finance_report', ['No', 'Yes']);
            $table->enum('manage_other_reports', ['No', 'Yes']);
            $table->enum('manage_subscriptions', ['No', 'Yes']);
            $table->enum('manage_fees_products', ['No', 'Yes']);
            $table->enum('manage_received_payments', ['No', 'Yes']);
            $table->enum('manage_calendars', ['No', 'Yes']);
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
        Schema::dropIfExists('staff');
    }
}
