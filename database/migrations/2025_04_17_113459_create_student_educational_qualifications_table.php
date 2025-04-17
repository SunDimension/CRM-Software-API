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
      Schema::create('student_educational_qualifications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('student_personal_information')->onDelete('cascade');
    $table->string('qualification_name');
    $table->foreignId('country_id')->constrained();
    $table->string('qualification_obtained');
    $table->string('grade');
    $table->string('institution_name');
    $table->foreignId('year_started_id')->constrained('years');
    $table->integer('qualification_order'); // 1 for first, 2 for second, etc.
    $table->boolean('is_completed')->default(false);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_educational_qualifications');
    }
};
