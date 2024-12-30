<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Vormkracht10\Analytics\Facades\Analytics;
use Vormkracht10\Analytics\Period;

class FetchAnalyticsTopLandingPages extends Command
{
    protected $signature = 'analytics:fetch-top-landing-pages';
    protected $description = 'Fetch Top Landing Pages data for the last year and save to the database';

    public function handle()
    {
        $data = Analytics::topViewsByPageTitle(Period::years(1), limit: 5);
        DB::table('google_analytics_top_landing_pages')->truncate();

        foreach ($data ?? [] as $viewCount) {
            DB::table('google_analytics_top_landing_pages')->insert([
                'page_title' => $viewCount['pageTitle'],
                'page_url'   => $viewCount['pagePath'],
                'view_count' => $viewCount['screenPageViews'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Top Landing Pages data has been successfully fetched and saved.');
    }
}
