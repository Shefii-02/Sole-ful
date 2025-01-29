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
        Schema::create('myaddresses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->text('address')->nullable();
            $table->string('locality')->nullable();
            $table->string('sub_locality')->nullable();
            $table->string('landmark')->nullable();
            $table->string('pincode')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('house_name')->nullable();
            $table->string('house_no')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->boolean('base')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('myaddresses');
    }
};
