<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('registration_number');
            $table->string('vehicle_type')->default('Bus');
            $table->integer('capacity')->default(40);
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('route_name');
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->decimal('fee', 8, 2)->default(0.00);
            $table->time('pickup_time')->nullable();
            $table->time('drop_time')->nullable();
            $table->text('stops')->nullable();
            $table->timestamps();
        });

        Schema::create('transport_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('route_id')->constrained('routes')->cascadeOnDelete();
            $table->string('pickup_stop')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transport_assignments');
        Schema::dropIfExists('routes');
        Schema::dropIfExists('vehicles');
    }
};
