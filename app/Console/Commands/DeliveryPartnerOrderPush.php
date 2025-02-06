<?php

namespace App\Console\Commands;

use App\Models\DeliveryPartnerResponse;
use App\Models\Order;
use App\Services\DeliveryPartnerApi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeliveryPartnerOrderPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:delivery-partner-order-push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Push pending orders to the delivery partner API';

    public function __construct(private DeliveryPartnerApi $apiService)
    {
        parent::__construct();
    }

    public function handle()
    {
        $orders = Order::whereDoesntHave('DeliveryPartnerResponse')->get();

        // if ($orders->isEmpty() ) {
        //     $this->info("No pending orders to push.");
        //     return;
        // }
       

        foreach ($orders ?? [] as $orderData) {
            try {
                $orderPayload = $this->orderPushDataFormat($orderData);
                $response = $this->apiService->pushOrder($orderPayload,$orderData);

                if (isset($response['status']) && $response['status'] == 200) {
                    Log::info("Order {$orderData->id} pushed successfully.");
                } else {
                    Log::error("Failed to push Order {$orderData->id}. Response: " . json_encode($response));
                }
            } catch (\Exception $e) {
                Log::error("Error processing Order {$orderData->id}: " . $e->getMessage());
            }
        }

        $ordersLabels = DeliveryPartnerResponse::where('status',0)->get();
        Log::info($ordersLabels);
        foreach ($ordersLabels ?? [] as $order) {
            try {
                $orderLabelData = $this->apiService->labelAndInvoiceStore($order);
                

                if (isset($orderLabelData['status']) && $orderLabelData['status'] == 200) {
                    Log::info("Order {$order->order_id} label updated successfully.");
                } else {
                    Log::error("Failed to label updated Order {$order->order_id}. Response: " . json_encode($orderLabelData));
                }
            } catch (\Exception $e) {
                Log::error("Error processing label updated Order {$order->order_id}: " . $e->getMessage());
            }
        }


    }    

    private function orderPushDataFormat($order)
    {
        return [
            "orderId" => $order->invoice_id.'9',
            "orderSubtype" => "FORWARD",
            "readyToPick" => false,
            "orderCreatedAt" => $order->billed_at,
            "currency" => "INR",
            "amount" => intval($order->grandtotal),
            "weight" => 300*$order->basket->items->count(),
            "lineItems" => $this->formatLineItems($order),
            "paymentType" => "ONLINE",
            "paymentStatus" => "SUCCESS",
            "subTotal" => $order->subtotal,
            "remarks" => $order->remarks,
            "shippingAddress" => $this->formatAddress($order->deliveryAddress, $order),
            "billingAddress" => $this->formatAddress($order->billingAddress, $order),
            "pickupAddress" => $this->formatAddress($order->deliveryAddress, $order),
            "returnAddress" => [
                "name" => "SOLEFUL",
                "email" => "relationship@soleful.in",
                "phone" => "7996666225",
                "address1" => "#5, 1st floor, Geddalahalli, Hennur Bagalur Main Road",
                "address2" => "",
                "city" => "Bangalore",
                "state" => "Karnataka",
                "country" => "India",
                "zip" => "560077",
                "latitude" => "",
                "longitude" => ""
            ],
            "gst" => 13,
            "deliveryPromise" => "AIR",
            "discountUnit" => "RUPEES",
            "discount" => intval($order->discount),
            "length" => 100,
            "height" => 100,
            "width" => 100
        ];
    }

    private function formatLineItems($order)
    {
        return $order->basket->items->map(function ($item) {
            return [
                "name" => $item->variation,
                "price" => intval($item->price_amount * $item->quantity),
                "weight" => 300,
                "quantity" => $item->quantity,
                "sku" => $item->product_sku,
                "unitPrice" => intval($item->price_amount)
            ];
        })->toArray();
    }

    private function formatAddress($address, $order)
    {
        return [
            "name" => $address->name,
            "email" => $address->email,
            "phone" => strval($address->mobile),
            "address1" => $address->address . ', Building No/Name: ' . $address->house_name,
            "address2" => "Landmark: " . $address->landmark,
            "city" => $address->locality,
            "state" => $address->state,
            "country" => "India",
            "zip" => $address->pincode,
            "latitude" => $order->lat,
            "longitude" => $order->long,
        ];
    }
}
