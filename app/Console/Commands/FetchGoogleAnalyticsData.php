<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Vormkracht10\Analytics\Facades\Analytics;
use Vormkracht10\Analytics\Period;

class FetchGoogleAnalyticsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:fetch';
    protected $description = 'Fetch Google Analytics data and save to the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch and save Visitors (last 30 days)
        $this->fetchVisitors();

        // Fetch and save Top Devices (last year)
        $this->fetchTopDevices();

        // Fetch and save Top Referrers (last 14 days)
        $this->fetchTopReferrers();

        // Fetch and save Top Landing Pages (last year)
        $this->fetchTopLandingPages();

        $this->info('Google Analytics data fetched and saved successfully.');
    }

    private function fetchVisitors()
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
    }

    private function fetchTopDevices()
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
    }

    private function fetchTopReferrers()
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
    }

    private function fetchTopLandingPages()
    {
        $data = Analytics::topViewsByPageTitle(Period::years(1), limit: 5);
        DB::table('google_analytics_top_landing_pages')->truncate();

        foreach ($data ?? [] as $viewCount) {
            DB::table('google_analytics_top_landing_pages')->insert([
                'page_title' => $viewCount['pageTitle'],
                'page_url'	 => $viewCount['pagePath'],
                'view_count' => $viewCount['screenPageViews'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
