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
        Schema::create('delivery_pincodes', function (Blueprint $table) {
            $table->id();
            $table->string('pincode')->unique();    
            $table->string('hub_code')->nullable();
            $table->string('city')->nullable();
            $table->string('fm')->nullable();
            $table->string('lm')->nullable();
            $table->string('cod')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('state')->nullable();
            $table->string('update_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_pincodes');
    }
};
