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
Schema::create('course_lecturers', function (Blueprint $table) {
    $table->ulid('id')->primary();
    $table->string('role');
    $table->timestamps();

    $table->foreignUlid('course_id')->constrained('courses')->cascadeOnDelete();
     $table->foreignUlid('lecturer_id')->constrained('lecturers')->cascadeOnDelete();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lecturers');
    }
};
