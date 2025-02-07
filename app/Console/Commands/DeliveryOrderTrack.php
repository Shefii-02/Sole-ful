<?php

namespace App\Console\Commands;

use App\Models\DeliveryPartnerResponse;
use App\Models\Order;
use App\Services\DeliveryPartnerApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeliveryOrderTrack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:delivery-order-track';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Track order';

    public function __construct(private DeliveryPartnerApi $apiService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $ordersTracks = DeliveryPartnerResponse::where('dp_order_id', '!=', 'DELIVERED')->get();
        foreach ($ordersTracks ?? [] as $order) {
            try {
                $orderTrackData = $this->apiService->orderTrack($order);

                if (isset($orderTrackData['status']) && $orderTrackData['status'] == 200) {
                    Log::info("Order {$order->order_id} status updated successfully.");
                } else {
                    Log::error("Failed to status updated Order {$order->order_id}. Response: " . json_encode($orderTrackData));
                }
            } catch (\Exception $e) {
                Log::error("Error processing status updated Order {$order->order_id}: " . $e->getMessage());
            }
        }
    }
}
