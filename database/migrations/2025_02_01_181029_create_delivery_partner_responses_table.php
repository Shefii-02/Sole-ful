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
        Schema::create('delivery_partner_responses', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable(); // If needed, or you can remove it
            $table->string('order_id');
            $table->string('dp_order_id')->nullable();
            $table->string('shipper_order_id')->nullable();
            $table->string('awb_number')->nullable();
            $table->string('c_awb_number')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_partner_responses');
    }
};
