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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('basket_id')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variation_id')->nullable();
            $table->unsignedBigInteger('parent')->nullable();
            $table->string('product_sku')->nullable();
            $table->string('product_name')->nullable();
            $table->string('variation')->nullable();
            $table->integer('prev_quantity')->default(0);
            $table->integer('quantity')->default(1);
            $table->decimal('price_amount', 10, 2)->nullable();
            $table->integer('box_quantity')->default(1);
            $table->decimal('item_price', 10, 2)->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->boolean('has_special_price')->default(false);
            $table->date('special_price_from')->nullable();
            $table->date('special_price_to')->nullable();
            $table->decimal('actual_price', 10, 2)->nullable();
            $table->unsignedBigInteger('price_id')->nullable();
            $table->string('picture')->nullable();
            $table->text('recipe')->nullable();
            $table->text('card_message')->nullable();
            $table->boolean('is_special_note')->default(false);
            $table->text('special_note')->nullable();
            $table->text('special_instructions')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('occasion_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->text('note')->nullable();
            $table->boolean('send_gift')->default(false);
            // Indexes
            $table->index(['basket_id', 'product_id', 'product_variation_id']);
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->foreignId('product_variant_id')->constrained('product_variants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
