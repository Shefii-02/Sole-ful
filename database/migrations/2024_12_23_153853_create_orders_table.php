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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('invoice_id')->unique();
            $table->foreignId('basket_id')->nullable()->constrained('baskets')->onUpdate('cascade')->onDelete('set null');
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('shipping_charge', 10, 2)->nullable();
            $table->decimal('grandtotal', 10, 2)->nullable();
            $table->ipAddress('ipaddress')->nullable();
            $table->string('coupon')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('billed_at')->nullable();
            $table->enum('status', ['PENDING', 'SUCCESS', 'FAILED'])->default('PENDING')->nullable();
            $table->decimal('paid', 10, 2)->nullable();
            $table->enum('order_type', ['online', 'offline', 'pickup'])->default('online')->nullable();
            $table->enum('order_source', ['web', 'mobile', 'in_store'])->default('web')->nullable();
            $table->dateTime('delivery_at')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->enum('refund_status', ['pending', 'completed', 'failed'])->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
