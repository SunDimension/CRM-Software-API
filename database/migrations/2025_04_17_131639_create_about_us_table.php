<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student_personal_information')->onDelete('cascade'); 
                $table->string('referred_by')->nullable();
                $table->string('social_media_id')->constrained('social_media')->onDelete('cascade');
                $table->string('sponsor_parent_guardian')->nullable();
                $table->string('sponsor_government')->nullable();
                $table->string('sponsor_ngo')->nullable();
                $table->string('sponsor_self')->nullable();
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
