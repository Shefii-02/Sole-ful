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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onUpdate('cascade')->onDelete('cascade'); // Foreign key to orders
            $table->string('payment_method', 50)->nullable();
            $table->string('reference_num', 100)->nullable();
            $table->string('transaction_id', 100)->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->nullable();
            $table->decimal('paid_cash', 10, 2)->nullable();
            $table->decimal('paid_card', 10, 2)->nullable();
            $table->string('card_type', 50)->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
