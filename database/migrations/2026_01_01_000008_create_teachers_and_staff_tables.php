<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('employee_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('photo')->nullable();
            $table->text('address')->nullable();
            $table->string('qualification')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('designation')->default('Senior Teacher');
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('employee_id');
            $table->string('name');
            $table->string('department')->default('Administration');
            $table->string('designation')->default('Staff');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('basic_salary', 10, 2)->default(0.00);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
        Schema::dropIfExists('teachers');
    }
};
