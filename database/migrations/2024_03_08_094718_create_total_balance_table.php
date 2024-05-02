<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('total_balance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('first_balance_id')->nullable();
            $table->foreign('first_balance_id')->references('id')->on('first_balance')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('income_id')->nullable();
            $table->foreign('income_id')->references('id')->on('income')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('outcome_id')->nullable();
            $table->foreign('outcome_id')->references('id')->on('outcome')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transaction')->onUpdate('cascade')->onDelete('cascade');
            $table->date('total_balance_date');
            $table->integer('total_balance_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_balance');
    }
};
