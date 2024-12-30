<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Vormkracht10\Analytics\Facades\Analytics;
use Vormkracht10\Analytics\Period;

class FetchAnalyticsTopReferrers extends Command
{
    protected $signature = 'analytics:fetch-top-referrers';
    protected $description = 'Fetch Top Referrers data for the last 14 days and save to the database';

    public function handle()
    {
        $data = Analytics::getTopReferrers(Period::days(14), limit: 5);
        DB::table('google_analytics_top_referrers')->truncate();

        foreach ($data ?? [] as $referrer) {
            DB::table('google_analytics_top_referrers')->insert([
                'referrer_url' => $referrer['sessionSource'],
                'user_count' => $referrer['sessions'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Top Referrers data has been successfully fetched and saved.');
    }
}
