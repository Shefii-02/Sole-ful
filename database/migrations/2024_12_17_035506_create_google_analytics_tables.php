<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Table for Visitors (last 30 days)
        Schema::create('google_analytics_visitors', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_users');
            $table->timestamps();
        });

        // Table for Top Devices (last year)
        Schema::create('google_analytics_top_devices', function (Blueprint $table) {
            $table->id();
            $table->string('device_category');
            $table->integer('user_count');
            $table->timestamps();
        });

        // Table for Top Referrers (last 14 days)
        Schema::create('google_analytics_top_referrers', function (Blueprint $table) {
            $table->id();
            $table->string('referrer_url');
            $table->integer('user_count');
            $table->timestamps();
        });

        // Table for Top Landing Pages (last year)
        Schema::create('google_analytics_top_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_title');
            $table->string('page_url');
            $table->integer('view_count');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('google_analytics_visitors');
        Schema::dropIfExists('google_analytics_top_devices');
        Schema::dropIfExists('google_analytics_top_referrers');
        Schema::dropIfExists('google_analytics_top_landing_pages');
    }
};
