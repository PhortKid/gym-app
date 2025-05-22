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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->nullalbe();
            $table->enum('payment_method', ['cash', 'bank','mobile']);
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->foreignId('category_id')->constrained('expense_categories')->onDelete('cascade');
            $table->string('status', 191)->nullable();
            $table->string('payed_to');
            $table->foreignId('income_id')->nullable()->constrained('income_category')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
