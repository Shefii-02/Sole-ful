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
            $table->string('invoice_id')->unique();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('basket_id')->nullable()->constrained('baskets')->onUpdate('cascade')->onDelete('set null');
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('shipping_charge', 10, 2)->nullable();
            $table->decimal('grandtotal', 10, 2)->nullable();
            $table->ipAddress('ipaddress')->nullable();
            $table->string('coupon')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->string('discount_type', 50)->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->text('remarks')->nullable();
            $table->dateTime('billed_at')->nullable();
            $table->enum('status', ['pending', 'completed', 'canceled'])->default('pending');
            $table->decimal('tip', 10, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->decimal('paid', 10, 2)->nullable();
            $table->enum('order_type', ['online', 'offline', 'pickup'])->nullable();
            $table->enum('order_source', ['web', 'mobile', 'in_store'])->nullable();
            $table->dateTime('delivery_at')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->enum('refund_status', ['pending', 'completed', 'failed'])->nullable();
            $table->dateTime('refunded_at')->nullable();
            $table->string('delivery_partner', 100)->nullable();
            $table->unsignedBigInteger('delivery_partner_id')->nullable();
            $table->boolean('store_email_delivery')->default(false);
            $table->boolean('customer_email_delivery')->default(false);
            $table->dateTime('picked_at')->nullable();
            $table->unsignedBigInteger('picked_by')->nullable();
            $table->unsignedBigInteger('picker_id')->nullable();
            $table->text('pickup_notes')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->unsignedBigInteger('shipped_by')->nullable();
            $table->unsignedBigInteger('shipper_id')->nullable();
            $table->dateTime('shipped_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->unsignedBigInteger('delivery_date')->nullable();
            $table->string('payment_terms', 100)->nullable();

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
