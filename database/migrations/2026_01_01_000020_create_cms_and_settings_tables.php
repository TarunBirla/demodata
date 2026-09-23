<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('key');
            $table->text('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();

            $table->unique(['school_id', 'key']);
        });

        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();
        });

        Schema::create('cms_testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('photo')->nullable();
            $table->text('content');
            $table->boolean('is_featured')->default(true);
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('cms_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('title');
            $table->string('image_path');
            $table->string('category')->default('Campus');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('cms_news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->text('summary')->nullable();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->date('published_at')->nullable();
            $table->string('status')->default('published');
            $table->timestamps();
        });

        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('type')->default('contact'); // contact, admission
            $table->string('name')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('student_name')->nullable();
            $table->string('grade_seeking')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // pending, new, read, archived
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
        Schema::dropIfExists('cms_news');
        Schema::dropIfExists('cms_galleries');
        Schema::dropIfExists('cms_testimonials');
        Schema::dropIfExists('cms_pages');
        Schema::dropIfExists('school_settings');
    }
};
