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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('variation');
            $table->string('variation_name')->nullable();
            $table->string('slug')->nullable();
            $table->string('color_code', 10);
            $table->string('size_code', 10);
            $table->string('sku')->unique();
            $table->decimal('price', 10, 2);
            $table->integer('in_stock')->default(0)->nullable();
            $table->decimal('special_price', 10, 2)->nullable();
            $table->boolean('stock_status')->default(0)->nullable(); 
            $table->string('upper_material')->nullable();
            $table->integer('box_quantity')->default(1)->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->decimal('weight_type',10,2)->nullable();
            $table->decimal('org_price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
