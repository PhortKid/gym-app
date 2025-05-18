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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->date('scheduled_date');
            $table->time('scheduled_time');
            $table->integer('duration_minutes');
            $table->integer('max_capacity');
            $table->integer('current_enrollments')->default(0);
            $table->string('venue')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
