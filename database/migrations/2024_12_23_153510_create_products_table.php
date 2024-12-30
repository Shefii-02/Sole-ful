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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->string('product_no', 10);
            $table->string('product_name');
            $table->string('slug');
            $table->string('availability');
            $table->integer('shipping_id')->nullable();
            $table->decimal('tax', 10, 2)->default(0)->nullable();
            $table->text('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_alt_text')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('art_code', 10)->unique();
            $table->text('description')->nullable();
            $table->integer('display_order')->default(0)->nullable();
            $table->boolean('has_special_price')->default(0)->nullable();
            $table->dateTime('special_price_from')->nullable();
            $table->dateTime('special_price_to')->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->string('shoe_type')->nullable();
            $table->string('gender')->nullable();
            $table->string('brand')->nullable();
            $table->string('occasion')->nullable();
            $table->string('marketed_by')->nullable();
            $table->string('manufactured_by')->nullable();
            $table->string('country_of_origin')->nullable();
            $table->text('care_instruction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
