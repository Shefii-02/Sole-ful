<?php

namespace App\Services;

use App\Models\DeliveryPartnerResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeliveryPartnerApi
{
    private $baseUrl;
    private $clientId;
    private $clientSecret;
    protected $authUrl;
    protected $refreshUrl;
    protected $pushOrder;
    protected $labelOrder;

    public function __construct()
    {
        $this->baseUrl = env('DELIVERY_PARTNER_URL');
        $this->clientId = env('DELIVERY_PARTNER_CLIENT_ID');
        $this->clientSecret = env('DELIVERY_PARTNER_CLIENT_SECRET');

        $this->authUrl    = env('DELIVERY_PARTNER_URL') . '/auth/login';
        $this->refreshUrl = env('DELIVERY_PARTNER_URL') . '/auth/refresh-token';
        $this->pushOrder  = env('DELIVERY_PARTNER_URL') . '/fulfillment/public/seller/order/ecomm/push-order';
        $this->labelOrder  = env('DELIVERY_PARTNER_URL') . '/fulfillment/public/seller/order/download/label-invoice';
    }


    // Get Access Token
    public function getAccessToken()
    {
        $tokenData = DB::table('api_tokens')->where('type', 'Delivery Partner')->latest()->first();

        if ($tokenData && Carbon::parse($tokenData->refresh_expired_at)->gt(now()) && Carbon::parse($tokenData->token_expired_at)->gt(now())) {
            return $tokenData->access_token;
            Log::info('1');
        }
        Log::info('2');
        return $this->refreshOrLoginToken();
    }

    // Authenticate User and Get Token
    public function authenticateUser()
    {
        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
        ])->post($this->authUrl, [
            "email" =>  $this->clientId,
            "password" => $this->clientSecret,
            "vendorType" => "SELLER"
        ]);
        Log::info('3');
        return $response->json()['data'] ?? null;
    }

    // Refresh Token
    public function refreshToken($refreshToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $refreshToken,
            'Content-Type'  => 'application/json',
        ])->post($this->refreshUrl);

        return $response->json()['data'] ?? null;
    }


    // Refresh or Login Token
    public function refreshOrLoginToken()
    {
        $tokenData = DB::table('api_tokens')->where('type', 'Delivery Partner')->latest()->first();

        if ($tokenData && Carbon::parse($tokenData->token_expired_at)->gt(now())) {
            // Refresh Token is still valid
            $response = $this->refreshToken($tokenData->refresh_token);
            Log::info($response);
        } else {
            // Refresh Token Expired → Call Auth API
            $response = $this->authenticateUser();
            Log::info($response);
        }

        if ($response && isset($response['accessToken'])) {
            $this->storeToken(
                $response['accessToken'],
                now()->addDay(),  // 1-day validity for access token
                $response['refreshToken'],
                now()->addDays(28) // 30-day validity for refresh token
            );

            return $response['accessToken'];
        }

        return null;
    }

    // Store Token in Database
    public function storeToken($accessToken, $tokenExpiry, $refreshToken, $refreshExpiry)
    {
        DB::table('api_tokens')->where('type', 'Delivery Partner')->delete();

        DB::table('api_tokens')->insert([
            'type'         => 'Delivery Partner',
            'access_token' => $accessToken,
            'token_expired_at' => $tokenExpiry,
            'refresh_token' => $refreshToken,
            'refresh_expired_at' => $refreshExpiry,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }


    public function pushOrder($orderData,$order)
    {
        $accessToken = $this->getAccessToken();
        $response    = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->post($this->pushOrder, $orderData);

        $responseData = $response->json();

        if ($responseData['status'] == 200) {
           
            $resp = new DeliveryPartnerResponse();
            $resp->invoice_id       = $order->invoice_id;
            $resp->order_id         = $order->id ?? null;
            $resp->dp_order_id      =  null;
            $resp->shipper_order_id = $responseData['data']['shipperOrderId'] ?? null;
            $resp->awb_number       = $responseData['data']['awbNumber'] ?? null;
            $resp->c_awb_number     = $responseData['data']['cAwbNumber'] ?? null;
            $resp->status           = 0;
            $resp->save();
        }
        return $responseData;
    }

    public function labelAndInvoiceStore($order)
    {
        $accessToken = $this->getAccessToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->get($this->labelOrder, [
            "awbNumber" => $order->invoice_id,
            "cAwbNumber" => $order->invoice_id,
        ]);

        $responseData = $response->json();
        if ($responseData['status'] == 200) {
            $resp = DeliveryPartnerResponse::where('order_id', $order->order_id)->frist();

            $resp->invoice_url = $responseData['data']['invoiceUrl'] ?? null;
            $resp->shipping_label_url = $responseData['data']['shippingLabelUrl'] ?? null;
            $resp->org_order_no = $responseData['data']['originalOrderNumber'] ?? null;
            $resp->org_order_id = $responseData['data']['originalOrderId'] ?? null;
            $resp->order_status = null;
            $resp->status = 1;
            $resp->save();
        }

        return $responseData;
    }
}
