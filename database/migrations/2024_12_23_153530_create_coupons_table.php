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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('value', 10, 2);
            $table->string('value_type')->comment('Percentage or Fixed');
            $table->unsignedInteger('max_count')->default(0);
            $table->unsignedInteger('cur_count')->default(0);
            $table->decimal('min_sales', 10, 2)->nullable();
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('availability')->default(true);
            $table->decimal('min_sale', 10, 2)->nullable();
            $table->enum('status', ['active', 'expired', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
