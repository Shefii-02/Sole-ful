<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->longText('access_token')->nullable();
            $table->timestamp('token_expired_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->longText('refresh_token')->nullable();
            $table->timestamp('refresh_expired_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
    }
};
