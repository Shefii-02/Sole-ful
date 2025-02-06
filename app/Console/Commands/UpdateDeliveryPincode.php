<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\DeliveryPincode;

class UpdateDeliveryPincode extends Command
{
    protected $signature = 'update:deliveryPincode';
    protected $description = 'Update delivery pincode details from API';

    public function handle()
    {
        $pincodes = DeliveryPincode::where('update_status', 0)->get();

        if ($pincodes->isEmpty()) {
            $this->info("No pincodes need updating.");
            return;
        }

        foreach ($pincodes as $pincode) {
            $this->info("Fetching data for pincode: " . $pincode->pincode);

            // Call the API
            $response = Http::get("http://www.postalpincode.in/api/pincode/{$pincode->pincode}");

            if (!$response->successful()) {
                $this->error("Failed to fetch data for pincode: " . $pincode->pincode);
                continue;
            }

            $data = $response->json();

            // Validate API response
            if ($data['Status'] !== 'Success' || empty($data['PostOffice'])) {
                $this->error("Invalid response for pincode: " . $pincode->pincode);
                continue;
            }

            // Get first post office record
            $postOffice = $data['PostOffice'][0];

            // Update record
            $pincode->update([
                'city' => $postOffice['Taluk'] ?? $pincode->city,
                'state' => $postOffice['State'] ?? $pincode->state,
                'update_status' => 1
            ]);
        }

       

        $this->info("Delivery pincodes updated successfully.");
    }
}
