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
    $table->foreignId('country_id')->constrained();
    $table->foreignId('university_id')->constrained();
    $table->foreignId('program_id')->constrained();
    $table->integer('priority'); // 1 for first choice, 2 for second, etc.
    $table->boolean('is_completed')->default(false);
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
