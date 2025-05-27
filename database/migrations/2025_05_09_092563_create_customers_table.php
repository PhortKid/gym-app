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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->String('phone_number');
            $table->String('email')->nullable;
            $table->string('gender')->nullable();

            $table->string('card_number')->nullable();
            $table->string('body_weight')->nullable();
            $table->string('body_height')->nullable();
            $table->string('bmi')->nullable();
            $table->string('membership_category')->nullable();
            $table->string('programs')->nullable();
            $table->string('exercise_intentions')->nullable();
            $table->string('insurance_category')->nullable();

            $table->string('nationality')->nullable();
            $table->text('address')->nullable();
            $table->string('next_of_kin_name')->nullable();
            $table->string('next_of_kin_relation')->nullable();
            $table->string('next_of_kin_phone')->nullable();
          //  $table->foreignId('membership_type_id')->constrained('membership_plans');
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->enum('payment_plan', ['Daily', 'Monthly', 'Quarterly', 'Annually'])->nullable();
            $table->enum('payment_status', ['Full Paid', 'Partial', 'Not Paid'])->default('Not Paid');
            $table->text('health_notes')->nullable();
            $table->string('preferred_workout_time')->nullable();
            $table->string('profile_photo')->nullable();
            $table->foreignId('assigned_trainer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('payed_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
