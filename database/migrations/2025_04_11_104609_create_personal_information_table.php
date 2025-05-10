<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personal_informations', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('maritalstatus_id')->nullable();
            $table->string('student_name');
            $table->date('date_of_birth');
            $table->string('phone_number');
            $table->string('email');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('passport_number')->nullable();
            $table->date('passport_issue_date')->nullable();
            $table->string('postal_address')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('maritalstatus_id')->references('id')->on('marital_statuses');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('personal_informations');
    }
};
