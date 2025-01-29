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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->foreignId('basket_id')->nullable()->constrained('baskets')->onUpdate('cascade')->onDelete('set null');
            $table->integer('order_id')->nullable();
            $table->string('transaction_id', 250)->nullable();
            $table->string('reference_id', 250)->nullable();
            $table->enum('payment_status', ['PENDING', 'SUCCESS', 'FAILED'])->default('PENDING')->nullable();
            $table->dateTime('processing_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->longText('response_msg')->nullable();
            $table->string('merchantOrderId')->nullable();
            $table->string('checksum')->nullable();
            $table->string('payment_method', 50)->nullable(); 
            $table->string('utr')->nullable()->comment('upi');
            $table->string('card_type', 50)->nullable()->comment('card');
            $table->string('arn')->nullable()->comment('card');
            $table->string('pg_authorization_code')->nullable()->comment('card');
            $table->string('pg_transaction_id')->nullable()->comment('netbankig,card');
            $table->string('bank_transaction_id')->nullable()->comment('netbankig,card');
            $table->string('bank_id')->nullable()->comment('netbankig,card');
            $table->string('pg_service_transaction_id')->nullable()->comment('netbankig');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
