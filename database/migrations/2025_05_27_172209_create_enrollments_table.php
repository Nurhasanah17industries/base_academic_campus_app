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
    Schema::create('enrollments', function (Blueprint $table) {
    $table->ulid('id')->primary();
    $table->string('grade');
    $table->string('attendance');
    $table->string('status');
    $table->timestamps();
    $table->foreignUlid('student_id')->constrained('students')->cascadeOnDelete();
    $table->foreignUlid('course_id')->constrained('courses')->cascadeOnDelete();    

});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
