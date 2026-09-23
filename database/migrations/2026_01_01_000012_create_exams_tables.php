<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnDelete();
            $table->string('name'); // Mid-Term Exam, Final Exam, etc.
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_published')->default(false);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('exam_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('school_classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->date('exam_date')->nullable();
            $table->decimal('max_marks', 5, 2)->default(100.00);
            $table->decimal('pass_marks', 5, 2)->default(35.00);
            $table->timestamps();
        });

        Schema::create('mark_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_subject_id')->constrained('exam_subjects')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->decimal('marks_obtained', 5, 2)->default(0.00);
            $table->string('grade')->nullable();
            $table->string('result_status')->default('pass'); // pass, fail, absent
            $table->string('remarks')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            $table->unique(['exam_subject_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mark_entries');
        Schema::dropIfExists('exam_subjects');
        Schema::dropIfExists('exams');
    }
};
