<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

            public function up()
            {
                Schema::create('invoices', function (Blueprint $table) {
                    $table->id();
                    $table->string('full_name');
                    $table->string('email')->nullable();
                    $table->string('phone_number')->nullable();
                    $table->date('start_date');
                    $table->date('expiry_date');
                    $table->string('gender');
                    $table->decimal('amount', 10, 2);
                    $table->decimal('paid_amount', 10, 2);
                    $table->string('payment_plan');
                    $table->string('assigned_trainer')->nullable();
                    $table->timestamps();
                });
            }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
