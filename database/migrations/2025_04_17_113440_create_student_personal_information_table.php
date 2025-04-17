<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('student_personal_information', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('student_name');
    $table->foreignId('gender_id')->constrained();
    $table->date('date_of_birth');
    $table->string('phone_number');
    $table->string('email');
    $table->foreignId('marital_status_id')->constrained('marital_statuses');
    $table->string('father_name');
    $table->string('mother_name');
    $table->string('passport_number')->nullable();
    $table->date('passport_issued_date')->nullable();
    $table->date('passport_expiry_date')->nullable();
    $table->text('postal_address');
    $table->boolean('is_completed')->default(false);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_personal_information');
    }
};
