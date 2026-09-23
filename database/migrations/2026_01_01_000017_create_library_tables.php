<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('isbn')->nullable();
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->string('category')->default('General');
            $table->integer('quantity')->default(1);
            $table->integer('available_quantity')->default(1);
            $table->string('shelf_location')->nullable();
            $table->decimal('price', 8, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('book_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('issue_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->decimal('fine_amount', 8, 2)->default(0.00);
            $table->string('status')->default('issued'); // issued, returned, overdue
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_issues');
        Schema::dropIfExists('books');
    }
};
