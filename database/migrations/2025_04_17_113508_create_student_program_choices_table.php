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
       Schema::create('student_program_choices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('student_personal_information')->onDelete('cascade');
    $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
    $table->foreignId('university_id')->constrained('universities')->onDelete('cascade');
    $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
    $table->string('first_choice');
    $table->string('second_choice');
    $table->string('third_choice');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_program_choices');
    }
};
