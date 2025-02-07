<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AccountActivityLog;
use App\Models\DeliveryPartnerResponse;
use Illuminate\Http\Request;
use App\Services\DeliveryPartnerApi;
use Exception;
use Illuminate\Support\Facades\Log;

class WebhookResponse extends Controller
{

    public function __construct(private DeliveryPartnerApi $apiService)
    {
        parent::__construct();
    }

    public function resposeDataCal(Request $request)
    {
        try {
            $order = DeliveryPartnerResponse::where('invoice_id', $request->data['orderId'])->first();
    
            if (!$order) {
                return response()->json(['status' => 404, 'message' => 'Order not found']);
            }
    
            $orderTrackData = $this->apiService->orderTrack($order);
    
            return response()->json(['status' => 200, 'data' => $orderTrackData]);
        } catch (Exception $e) {
            Log::error('Error processing order status: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Internal Server Error']);
        }
    }
    

}