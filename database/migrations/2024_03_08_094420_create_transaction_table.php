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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('income_id');
            $table->foreign('income_id')->references('id')->on('income');
            $table->unsignedBigInteger('outcome_id');
            $table->foreign('outcome_id')->references('id')->on('outcome');
            $table->date('transaction_date');
            $table->integer('transaction_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
