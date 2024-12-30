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

        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->string('session');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('email')->nullable();
            $table->string('coupon')->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_mode')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->boolean('send_gift')->default(false);
            $table->string('page')->nullable();
            $table->string('order_type')->nullable();
            $table->string('shipping_location')->nullable();
            $table->unsignedBigInteger('pickup_id')->nullable();
            $table->date('serve_date')->nullable();
            $table->time('serve_time')->nullable();
            $table->unsignedBigInteger('affiliate_id')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('open')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baskets');
    }
};
