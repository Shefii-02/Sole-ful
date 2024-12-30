<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Vormkracht10\Analytics\Facades\Analytics;
use Vormkracht10\Analytics\Period;

class FetchAnalyticsTopDevices extends Command
{
    protected $signature = 'analytics:fetch-top-devices';
    protected $description = 'Fetch Top Devices data for the last year and save to the database';

    public function handle()
    {
        $data = Analytics::topUsersByDeviceCategory(Period::years(1));
        DB::table('google_analytics_top_devices')->truncate();

        foreach ($data ?? [] as $userCount) {
            DB::table('google_analytics_top_devices')->insert([
                'device_category' => $userCount['deviceCategory'],
                'user_count' => $userCount['totalUsers'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Top Devices data has been successfully fetched and saved.');
    }
}
