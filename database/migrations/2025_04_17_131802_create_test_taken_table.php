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
        Schema::create('test_taken', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student_personal_information')->onDelete('cascade');
            $table->string('ielts_score')->nullable();
            $table->string('expiry_date')->nullable();
             $table->string('gre_score')->nullable();
            $table->string('g_expiry_date')->nullable();
             $table->string('gmat_score')->nullable();
            $table->string('gm_expiry_date')->nullable();
             $table->string('sat_score')->nullable();
            $table->string('sat_expiry_date')->nullable();
            $table->string('work_experience')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_taken');
    }
};
