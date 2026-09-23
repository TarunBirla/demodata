<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_admissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('application_no')->unique();
            $table->string('student_name');
            $table->date('dob');
            $table->string('gender');
            $table->foreignId('applying_class_id')->nullable()->constrained('school_classes')->nullOnDelete();
            $table->string('previous_school')->nullable();
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_email')->nullable();
            $table->text('address')->nullable();
            $table->string('document_path')->nullable();
            $table->string('status')->default('new'); // new, under_review, shortlisted, approved, rejected, enrolled
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_admissions');
    }
};
