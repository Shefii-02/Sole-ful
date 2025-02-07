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
    protected $trackOrder;

    public function __construct()
    {
        $this->baseUrl = env('DELIVERY_PARTNER_URL');
        $this->clientId = env('DELIVERY_PARTNER_CLIENT_ID');
        $this->clientSecret = env('DELIVERY_PARTNER_CLIENT_SECRET');

        $this->authUrl    = env('DELIVERY_PARTNER_URL') . '/auth/login';
        $this->refreshUrl = env('DELIVERY_PARTNER_URL') . '/auth/refresh-token';
        $this->pushOrder  = env('DELIVERY_PARTNER_URL') . '/fulfillment/public/seller/order/ecomm/push-order';
        $this->labelOrder  = env('DELIVERY_PARTNER_URL') . '/fulfillment/public/seller/order/download/label-invoice';
        $this->trackOrder  = env('DELIVERY_PARTNER_URL') . '/fulfillment/public/seller/order/order-tracking/';
    }


    // Get Access Token
    public function getAccessToken()
    {
        $tokenData = DB::table('api_tokens')->where('type', 'Delivery Partner')->latest()->first();

        if ($tokenData && Carbon::parse($tokenData->refresh_expired_at)->gt(now()) && Carbon::parse($tokenData->token_expired_at)->gt(now())) {
            return $tokenData->access_token;
        }

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


    public function pushOrder($orderData, $order)
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
        $response = Http::get($this->labelOrder, [
            "awbNumber" => $order->awb_number,
            "cAwbNumber" => $order->c_awb_number,
        ]);

        $responseData = $response->json();

        if ($responseData['status'] == 200) {
            $data = $responseData['data'][0] ?? [];

            if ($data['invoiceUrl'] == '' || $data['shippingLabelUrl'] == '') {
                $status = 0;
            } else {
                $status = 1;
            }

            DeliveryPartnerResponse::updateOrCreate(
                ['order_id' => $order->order_id], // Condition to find an existing record
                [
                    'invoice_url'       => $data['invoiceUrl'] ?? null,
                    'shipping_label_url' => $data['shippingLabelUrl'] ?? null,
                    'org_order_no'      => $data['originalOrderNumber'] ?? null,
                    'org_order_id'      => $data['originalOrderId'] ?? null,
                    'status'            => $status,
                ]
            );
        }

        return $responseData;
    }

    public function orderTrack($order)
    {
        $accessToken = $this->getAccessToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type'  => 'application/json',
        ])->get($this->trackOrder . $order->awb_number);

        $responseData = $response->json();

        if ($responseData['status'] == 200) {
            $data = $responseData['data'][0] ?? [];

            if ($data['paymentStatus'] == 'NEW' || $data['paymentStatus'] == 'IN_PROCESS') {
                $status = 'IN_PROCESS';
            } else {
                $status = $data['paymentStatus'];
            }

            DeliveryPartnerResponse::updateOrCreate(
                ['order_id' => $order->order_id], // Condition to find an existing record
                [
                    'dp_order_id'      => $status ?? null,
                    'order_status'      => $data['orderStateInfo'] ?? null,
                ]
            );
        }
        return $responseData;
    }
}
