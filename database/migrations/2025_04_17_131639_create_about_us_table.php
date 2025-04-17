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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student_personal_information')->onDelete('cascade');
            $table->string('name_of_referal')->nullable();
            $table->string('where_did_you_hear_about_us')->nullable();
            $table->string('parent_guardian')->nullable();
            $table->string('government')->nullable();
            $table->string('ngo')->nullable();
            $table->string('self')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
