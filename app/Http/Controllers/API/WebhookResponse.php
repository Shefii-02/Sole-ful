<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeliveryPartnerResponse;
use Illuminate\Http\Request;
use App\Services\DeliveryPartnerApi;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;

class WebhookResponse extends Controller
{
    protected DeliveryPartnerApi $apiService;

    public function __construct(DeliveryPartnerApi $apiService)
    {
        $this->apiService = $apiService;
    }

    public function resposeDataCal(Request $request)
    {
        Log::info('Received Webhook Headers:', $request->headers->all());
        Log::info('Received Webhook Payload:', $request->all());

        try {
            // Validate request
            if (!isset($request->data['orderId'])) {
                return response()->json(['status' => 400, 'message' => 'Invalid request: Missing orderId'], 400);
            }

            // Fetch the order
            $order = DeliveryPartnerResponse::where('invoice_id', $request->data['orderId'])->firstOrFail();

            // Call external tracking API
            $orderTrackData = $this->apiService->orderTrack($order);

            return response()->json([
                'status' => 200,
                'message' => 'Order status updated successfully',
                'data' => $orderTrackData ?? null
            ]);
        } catch (QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Database error'], 500);
        } catch (Throwable $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return response()->json(['status' => 500, 'message' => 'Something went wrong'], 500);
        }
    }
}
