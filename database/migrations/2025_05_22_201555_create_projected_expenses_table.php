<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectedExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('projected_expenses', function (Blueprint $table) {
            $table->id();
            $table->decimal('daily', 15, 2)->nullable();
            $table->decimal('monthly', 15, 2)->nullable();
            $table->decimal('annual', 15, 2)->nullable();
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projected_expenses');
    }
}
