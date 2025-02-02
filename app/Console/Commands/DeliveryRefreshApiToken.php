<?php

namespace App\Console\Commands;

use App\Services\DeliveryPartnerApi;
use Illuminate\Console\Command;

class DeliveryRefreshApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:delivery-refresh-api-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(private DeliveryPartnerApi $apiService)
    {
        parent::__construct();
    }
    

    public function handle()
    {
        $token = $this->apiService->refreshOrLoginToken();

        if ($token) {
            $this->info("API Token refreshed successfully.");
        } else {
            $this->error("Failed to refresh API Token.");
        }
    }
}
