<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPartnerResponse;
use Illuminate\Http\Request;
use App\Services\DeliveryPartnerApi;
use Exception;
use Illuminate\Support\Facades\Log;

class WebhookResponse extends Controller
{
    protected DeliveryPartnerApi $apiService;

    public function __construct(DeliveryPartnerApi $apiService)
    {
        $this->apiService = $apiService;
    }

    public function resposeDataCall(Request $request)
    {
        if ($request->header('signature') == env('DELIVERY_WEBHOOK_KEY')) {
            try {
                // Validate incoming request
                if (!isset($request->data['orderId'])) {
                    return response()->json(['status' => 400, 'message' => 'Missing orderId']);
                }

                // Fetch order from the database
                $order = DeliveryPartnerResponse::where('invoice_id', $request->data['orderId'])->first();

                if (!$order) {
                    return response()->json(['status' => 404, 'message' => 'Order not found']);
                }

                // Process order tracking
                $orderTrackData = $this->apiService->orderTrack($order);

                return response()->json(['status' => 200, 'data' => $orderTrackData]);
            } catch (Exception $e) {
                Log::error('Error processing order status: ' . $e->getMessage());
                return response()->json(['status' => 500, 'message' => 'Internal Server Error']);
            }
        } else {
            return response()->json(['status' => 500, 'message' => 'API KEY Doesn`t matched']);
        }
    }
}
