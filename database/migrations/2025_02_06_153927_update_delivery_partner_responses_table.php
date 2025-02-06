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
        //
        Schema::table('delivery_partner_responses', function (Blueprint $table) {
            $table->longText('invoice_url')->nullable();
            $table->longText('shipping_label_url')->nullable();
            $table->string('org_order_no')->nullable();
            $table->string('org_order_id')->nullable();
            $table->string('order_status')->nullable();
            $table->integer('status')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
