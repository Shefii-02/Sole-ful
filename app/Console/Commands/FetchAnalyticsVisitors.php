<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Vormkracht10\Analytics\Facades\Analytics;
use Vormkracht10\Analytics\Period;

class FetchAnalyticsVisitors extends Command
{
    protected $signature = 'analytics:fetch-visitors';
    protected $description = 'Fetch Visitors data for the last 30 days and save to the database';

    public function handle()
    {
        $data = Analytics::totalUsersByDate(Period::days(30));
        DB::table('google_analytics_visitors')->truncate();

        foreach ($data ?? [] as $totalUsers) {
            $formattedDate = \DateTime::createFromFormat('Ymd', $totalUsers['date'])->format('Y-m-d');

            DB::table('google_analytics_visitors')->insert([
                'date' => $formattedDate,
                'total_users' => $totalUsers['totalUsers'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Visitors data has been successfully fetched and saved.');
    }
}
