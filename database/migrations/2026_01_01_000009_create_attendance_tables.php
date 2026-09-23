<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('section_id')->constrained('sections')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->date('date');
            $table->string('status')->default('present'); // present, absent, late, leave
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->unique(['school_id', 'student_id', 'date'], 'idx_student_daily_attendance');
        });

        Schema::create('staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('date');
            $table->string('status')->default('present'); // present, absent, late, leave
            $table->string('remarks')->nullable();
            $table->timestamps();

            $table->unique(['school_id', 'user_id', 'date'], 'idx_staff_daily_attendance');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_attendances');
        Schema::dropIfExists('student_attendances');
    }
};
