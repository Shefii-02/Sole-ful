<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutFormRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Basket;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Myaddress;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\Payment;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Dipesh79\LaravelPhonePe\LaravelPhonePe;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\NullableType;

class OrderController extends Controller
{
    use \App\Emails;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders = Order::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function confirmed()
    {
        $orders = Order::where('status', 'confirmed')->whereNull('delivery_status')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.confirmed', compact('orders'));
    }
    public function inTransit()
    {
        $excludedStatuses = ['DELIVERED', 'UNDELIVERED'];
        $orders = Order::where('status', 'confirmed')
            ->whereNotIn('delivery_status', $excludedStatuses)
            ->orderBy('created_at', 'desc')->get();
        return view('admin.orders.in-transit', compact('orders'));
    }
    public function deliveried()
    {
        $orders = Order::where('status', 'confirmed')->where('delivery_status', 'DELIVERED')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.deliveried', compact('orders'));
    }
    public function cancelled()
    {
        $orders = Order::where('status', 'cancelled')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.cancelled', compact('orders'));
    }
    public function undelivered()
    {
        $orders = Order::where('status', 'confirmed')->where('delivery_status', 'UNDELIVERED')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.undelivered', compact('orders'));
    }


    public function show($id)
    {
        $order = Order::where('invoice_id', $id)->first() ?? abort(404);
        return view('admin.orders.show', compact('order'));
    }

    public function printInvoice($invoice_id)
    {
        $order = Order::where('invoice_id', $invoice_id)->first() ?? abort(404);
        $print = true;
        return view('admin.orders.print', compact('order', 'print'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function update(Request $request, $id)
    {
        $order = Order::where('id', $id)->first() ?? abort(404);
        if ($request->status == 'confirmed') {
            $order->verified_at = date('Y-m-d H:i:s');
            $order->status = 'confirmed';
        } else if ($request->status == 'cancelled') {
            $order->verified_at = date('Y-m-d H:i:s');
            $order->status = 'cancelled';
        } elseif ($request->status == 'READY_FOR_DISPATCH') {
            $order->delivery_status = 'READY_FOR_DISPATCH';
        }

        $order->save();

        Session::flash('success_msg', "Order updated successfully");
        return redirect()->back();
    }



    ///////////////////////////////////////////////////////////////////////////////

    public function placeOrder(CheckoutFormRequest $request)
    {

        $user           = User::where('id', auth()->user()->id)->first();
        if (session()->has('session_string') && $user) {

            $session_string = session('session_string');
            $basket = Basket::whereHas('items')->where('session', $session_string)->where('status', 0)->first();
            if ($basket) {

                OrderAddress::where('basket_id', $basket->id)->where('user_id', $user->id)->delete();

                $calculations  = $this->GrandTotalCalculation($basket);
                $calculations = json_decode($calculations);

                $grandTotal       = $calculations->grandTotal;
                $billingAddress = Myaddress::where('user_id', $user->id)->where('id', $request->billing_address)->first();
                if (!$billingAddress) {
                    $billingAddress = Myaddress::where('user_id', $user->id)->first();
                }

                $this->storeBillingAddress($billingAddress, $basket->id, 'billing');
                $this->storeDeliveryAddress($request, $basket->id, 'delivery');

                if ($request->payment_method == 'online') {
                    $result     = $this->submitPaymentForm($grandTotal, $user, $basket);
                    return redirect($result);
                } else {
                    $result     = $this->submitCodForm($grandTotal, $user, $basket);

                    return $result->render();
                }




                // if (env('APP_ENV') == 'local') {
                //     $transaction_id = $basket->id . $user->id . uniqid();
                //     $amount = $grandTotal * 100;
                //     // Store information into database

                //     $data = [
                //         'user_id'  => $user->id,
                //         'basket_id' => $basket->id,
                //         'transaction_id' => $transaction_id,
                //         'amount' => $amount,
                //         'merchantOrderId' => $basket->id . '-' . $user->id,
                //     ];

                //     Payment::where('basket_id', $basket->id)->where('user_id', $user->id)->delete();

                //     Payment::create($data);

                //     return redirect(url("/confirm?code=PAYMENT_SUCCESS&merchantId=M22ZUK6NQLM1Q&transactionId={$transaction_id}&amount={$amount}&providerReferenceId=T2501300212587508007957&merchantOrderId={$transaction_id}&param1=na&param2=na&param3=na&param4=na&param5=na&param6=na&param7=na&param8=na&param9=na&param10=na&param11=na&param12=na&param13=na&param14=na&param15=na&param16=na&param17=na&param18=na&param19=na&param20=na&checksum=991751a08c2893e455985046d17c3a586b79af7bd4686027e4c7ebf45e1d9d07###1"));
                // } else {
                //     return redirect()->to($result);
                //     // return $result;
                // }
            } else {
                dd('your basket is empty');
            }
        } else {
            dd('user access denied');
        }
    }

    public function thankyou(Request $request)
    {
        $base64Data = $request->query('order');

        if (!$base64Data) {
            abort(404);
        }


        $data = unserialize(base64_decode(request()->order));

        if (!is_array($data) && isset($data['order_id'])) {
            abort(404);
        }

        //$basket = Basket::where('session',$request->processing_id)->first() ?? abort(404);
        $order  = Order::with(['basket' => function ($q) {
            $q->with('items');
        }])->where('id', $data['order_id'])->first() ?? abort(404);
        $googlecode = $this->googleCodeThankyou($order);
        $invoice_id = $order->invoice_id;
        return view('frontend.thanks', compact('invoice_id', 'googlecode'));
    }

    function googleCodeThankyou($order)
    {
        if ($basket = $order->basket) {
            $items = [];
            foreach ($basket->items as $key => $item) {
                $items[] =  [
                    "item_id" => $item->product_sku,
                    "item_name" => $item->product_name,
                    "affiliation" => $basket ? $basket->city ?? "" : '',
                    "coupon" => "",
                    "index" => $key,
                    "item_brand" => "Soleful",
                    "item_category" => "Products",
                    "item_variant" => $item->variation,
                    "location_id" => "Toronto",
                    "price" => $item->price_amount,
                    "quantity" => $item->quantity // Corrected from $item->$key
                ];
            }

            $purchaseData = [
                "transaction_id" => $order->invoice_id,
                "value" => $order->grandtotal ?? 0,
                "tax" => $order->taxamount,
                "shipping" => $order->shipping_charge,
                "currency" => "INR",
                "coupon" => "",
                "items" => $items // Removed the wrapping array []
            ];
        } else {
            $purchaseData = '';
        }

        return $purchaseData;
    }



    function showThanks($order_id = 0)
    {

        $order = Order::find($order_id) or abort(404);
        $basket_id = $order->basket_id;

        $basket = Basket::with('items')->whereId($basket_id)->first();
        if ($basket) {
            //Google code
            $temptot = $order->grandtotal ?? 0;
            $ggtrans = 'pageTracker._addTrans(';
            $ggtrans .= '"' . $basket_id . '",';
            $ggtrans .= '"Soleful",';
            $ggtrans .= '"' . $temptot . '",';
            $ggtrans .= '"' . $basket->taxamount . '",';
            $ggtrans .= '"' . $basket->shipping_charge . '",';
            $ggtrans .= '"Toronto",';
            $ggtrans .= '"Ontario",';
            $ggtrans .= '"Canada");';

            $ggitems = '';

            foreach ($basket->items as $item) {
                $ggitems .= 'pageTracker._addItem(';
                $ggitems .= '"' . $basket_id . '",';
                $ggitems .= '"' . $item->product_sku . '",';
                $ggitems .= '"' . $item->product_name . '",';
                $ggitems .= '"' . $item->variation . '",';
                $ggitems .= '"' . number_format($item->price_amount / 100, 2) . '",1';
                $ggitems .= ');' . "\n";
            }

            $googlecode = $ggtrans . "\n\n" . $ggitems;
        } else {
            $googlecode = '';
        }
        $invoice_id = $order->invoice_id;

        return view('frontend.thanks', compact('invoice_id', 'googlecode'));
    }

    public function storeBillingAddress($data, $basket_id, $type)
    {
        $address = $data;
        try {
            $save_add              = new OrderAddress();
            $save_add->user_id     = auth()->check() ? auth()->user()->id : 0;
            $save_add->order_id    = 0;
            $save_add->name        = $address->name;
            $save_add->email       = $address->email;
            $save_add->mobile      = $address->mobile;
            $save_add->address     = $address->address;
            $save_add->locality    = $address->locality;
            $save_add->landmark    = $address->landmark;
            $save_add->pincode     = $address->pincode;
            $save_add->house_name  = $address->house_name;
            $save_add->house_no    = $address->house_no;
            $save_add->state       = $address->state;
            $save_add->country     = 'India';
            $save_add->type        = $type;
            $save_add->basket_id   = $basket_id;
            $save_add->save();

            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    public function storeDeliveryAddress(Request $request, $basket_id, $type)
    {
        $address = $request;
        try {
            $save_add              = new OrderAddress();
            $save_add->user_id     = auth()->check() ? auth()->user()->id : 0;
            $save_add->order_id    = 0;
            $save_add->name        = $address['s_name'] ?? '';
            $save_add->email       = $address['s_email'];
            $save_add->mobile      = $address['s_phone'];
            $save_add->address     = $address['s_address'];
            $save_add->locality    = $address['s_locality'];
            $save_add->landmark    = $address['s_landmark'] ?? null;
            $save_add->pincode     = $address['s_postal'];
            $save_add->house_name  = $validatedData['s_house_name'] ?? null;
            $save_add->house_no    = $request->input('s_house_no', null);
            $save_add->state       = $address['s_state'];
            $save_add->country     = 'India';
            $save_add->type        = $type;
            $save_add->basket_id   = $basket_id;
            $save_add->save();

            return 1;
        } catch (\Exception $e) {
            return 0;
        }
    }

    function invoiceNumberGenerate()
    {
        $ordercount = Order::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->count();
        return 'SFA' . date('ymd') . sprintf('%04d', $ordercount + 1);
    }
    public function CheckOutCalculation()
    {
        $session_string = session('session_string');;
        $basket = Basket::where('session', $session_string)->where('status', 0)->first() ?? abort(404);
        $calculations  = $this->GrandTotalCalculation($basket);
        return view('frontend.checkout-calculation', compact('calculations', 'basket'))->render();
    }

    function GrandTotalCalculation($basket)
    {

        $this->CartRefresh();

        $Calculation['subTotal']       = 0;
        $Calculation['Discount']       = 0;
        $Calculation['ShippingCharge'] = 0;
        $Calculation['itemTotalTax']   = 0;
        $Calculation['shippingTax']    = 0;
        $Calculation['TotalTax']       = 0;
        $Calculation['grandTotal']     = 0;
        $Calculation['DiscountCode']   = '';

        $itemttlTax = array();
        $discount      = 0;
        $subTotal2 = 0;

        $date_now       = date('Y-m-d h:i:s');
        $items = CartItem::where('basket_id', $basket->id)->get();
        $itemCount = $items->count() ?? 0;


        foreach ($items as $listing2) {
            $itemSubTtl2      = floatval($listing2->price_amount * $listing2->quantity);

            $subTotal2      = $subTotal2 + $itemSubTtl2;
        }

        $coupon_details = Coupon::where('id', $basket->coupon)->where('start_time', '<=', $date_now)->where('end_time', '>=', $date_now)->where('min_sales', '<=', $subTotal2)->first();
        if ($coupon_details && $basket->coupon != '' && $basket->coupon != NULL) {
            if ($coupon_details->value_type == 'amount') {
                $discount = floatval($coupon_details->value);
                $discount_amount = 0;
                if ($itemCount > 0) {
                    $discount_amount = floatval($discount / $itemCount);
                }
                foreach ($items as $listing) {
                    $itemSubTtl      = floatval($listing->price_amount * $listing->quantity);
                    $itemSub_total   = $itemSubTtl - $discount_amount;
                    $itemttlTax[]    = ($itemSub_total * $listing->tax_percentage) / 100;
                    $subTotal[]      = $itemSubTtl;
                }
            } else {
                $dicountPercentage = $coupon_details->value;
                $ttlDiscount = array();
                foreach ($items as $listing) {
                    $itemSubTtl = floatval($listing->price_amount * $listing->quantity);
                    $discount_amount = ($itemSubTtl * $dicountPercentage) / 100;
                    $itemSub_total   = $itemSubTtl - $discount_amount;
                    $itemttlTax[]    = ($itemSub_total * $listing->tax_percentage) / 100;
                    $ttlDiscount[]   =  $discount_amount;
                    $subTotal[]      = $itemSubTtl;
                }

                $discount = array_sum($ttlDiscount);
            }


            $Calculation['DiscountCode'] =  $coupon_details->code;
        } else {
            foreach ($items as $listing) {

                $amnt           = $listing->price_amount;
                $itemSubTtl     = floatval($amnt * $listing->quantity);
                $itemttlTax[]   = ($itemSubTtl * $listing->tax_percentage) / 100;
                $subTotal[]     = $itemSubTtl;
            }
        }

        $discount = min($discount, array_sum($subTotal));
        $Calculation['subTotal']        = array_sum($subTotal);
        $Calculation['itemTotalTax']    = array_sum($itemttlTax);
        $Calculation['Discount']        = $discount;
        $Calculation['grandTotal']      = ($Calculation['subTotal'] - $Calculation['Discount']) + $Calculation['ShippingCharge'] + $Calculation['TotalTax'];
        return json_encode($Calculation);
    }

    function CartRefresh()
    {
        if (session()->has('session_string')) {
            $session_string = session('session_string');
            $basket = Basket::where('session', $session_string)->where('status', 0)->first();
            if ($basket) {

                if (auth()->check()) {
                    $basket->user_id = auth()->user()->id;
                    $basket->save();
                }

                $items = CartItem::where('basket_id', $basket->id)->get();
                if ($items) {
                    foreach ($items as $listing) {
                        if (!$listing->product_variation || $listing->product_variation->in_stock < $listing->quantity) {
                            CartItem::where('id', $listing->id)->delete();
                        }
                    }
                }
            }
        }
    }


    public function submitPaymentForm($grandTotal = 1, User $user, $basket)
    {
        $amount         = $grandTotal;
        $user_name      =  $user->name;
        $user_mobile    =  $user->mobile;
        if ($user) {
            $merchantId = env('PHONEPE_MERCHANT_ID');
            $apiKey     = env('PHONEPE_SALT_KEY');
            $url        = env('PHONEPE_URL');

            $redirectUrl = url('confirm');
            $transaction_id = $basket->id . $user->id . uniqid();

            $transaction_data = array(
                'merchantId' => "$merchantId",
                'merchantTransactionId' => "$transaction_id",
                "merchantUserId" => $basket->id . '-' . $user->id,
                'amount' => $amount * 100,
                'redirectUrl' => "$redirectUrl",
                'redirectMode' => "POST",
                'callbackUrl' => "$redirectUrl",
                'mobileNumber' => "$user_mobile",
                "paymentInstrument" => array(
                    "type" => "PAY_PAGE",
                )
            );

            $encode = json_encode($transaction_data);
            $payloadMain = base64_encode($encode);
            $salt_index = 1; //key index 1
            $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
            $sha256 = hash("sha256", $payload);
            $final_x_header = $sha256 . '###' . $salt_index;
            $request = json_encode(array('request' => $payloadMain));

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $request,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "X-VERIFY: " . $final_x_header,
                    "accept: application/json"
                ],
            ]);


            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $res = json_decode($response);

                // Store information into database

                $data = [
                    'user_id'  => $user->id,
                    'basket_id' => $basket->id,
                    'transaction_id' => $transaction_id,
                    'amount' => $amount,
                    'response_msg' => $response,
                    'merchantOrderId' => $basket->id . '-' . $user->id,
                ];

                Payment::where('basket_id', $basket->id)->where('user_id', $user->id)->delete();

                Payment::create($data);
                // end database insert

                if (isset($res->code) && ($res->code == 'PAYMENT_INITIATED')) {
                    $payUrl = $res->data->instrumentResponse->redirectInfo->url;
                    return $payUrl;
                } else {
                    //HANDLE YOUR ERROR MESSAGE HERE
                    dd('ERROR : ' . $res);
                }
            }
        }
    }


    public function confirmPayment(Request $request)
    {
        Log::info('****************');
        Log::info($request->all());
        Log::info(auth()->user());
        Log::info(session()->has('session_string'));
        Log::info('----------------');

        if ($request->code == 'PAYMENT_SUCCESS') {
            $user           = User::where('id', auth()->user()->id)->first();
            if (session()->has('session_string') && $user) {
                $session_string = session('session_string');
                $basket = Basket::whereHas('items')->where('session', $session_string)->where('status', 0)->first();
                if ($basket) {
                    $calculations  = $this->GrandTotalCalculation($basket);
                    $calculations = json_decode($calculations);

                    $subTotal    = $calculations->subTotal;
                    $tax_amount  = $calculations->TotalTax;
                    $discount    = $calculations->Discount;
                    $couponCode  = $calculations->DiscountCode;
                    $ship_charge = $calculations->ShippingCharge;
                    // $ship_tax    = $calculations->shippingTax;
                    $grandTotal  = $calculations->grandTotal;


                    $transactionId = $request->transactionId;
                    $merchantId = $request->merchantId;
                    $providerReferenceId = $request->providerReferenceId;
                    $merchantOrderId = $request->merchantOrderId;
                    $checksum = $request->checksum;
                    $status = $request->code;
                    $paymentInstrumentDetails       = $this->CheckApiStatus($transactionId);

                    $payment                = Payment::where('transaction_id', $transactionId)->where('user_id', $user->id)->first();
                    if ($payment) {
                        $order              = new Order();
                        $order->user_id     = $user->id;
                        $order->invoice_id  = $this->invoiceNumberGenerate();
                        $order->basket_id   = $basket->id;
                        $order->subtotal    = $subTotal;
                        $order->discount    = $discount;
                        $order->tax         = $tax_amount;
                        $order->shipping_charge = $ship_charge;
                        $order->grandtotal  = $grandTotal;
                        $order->ipaddress   = request()->ip();
                        $order->coupon      = $couponCode;
                        $order->remarks     = '';
                        $order->billed_at   = date('Y-m-d H:i:s');
                        $order->status      = 'pending';
                        $order->paid        = 1;
                        $order->payment_method = 'online';
                        $order->save();

                        OrderAddress::where('basket_id', $basket->id)->where('user_id', $user->id)->update(['order_id' => $order->id]);
                        Basket::where('id', $basket->id)->update(['status' => 1]);

                        if (isset($paymentInstrumentDetails['data']['paymentInstrument'])) {
                            $paymentInstrument          = $paymentInstrumentDetails['data']['paymentInstrument'];

                            $payment->checksum          = $checksum;
                            $payment->reference_id      = $providerReferenceId;
                            $payment->payment_method    = isset($paymentInstrument['type']) ? $paymentInstrument['type'] : null;
                            $payment->utr               = isset($paymentInstrument['utr']) ? $paymentInstrument['utr'] : null;
                            $payment->card_type         = isset($paymentInstrument['cardType']) ? $paymentInstrument['cardType'] : null;
                            $payment->arn               = isset($paymentInstrument['arn']) ? $paymentInstrument['arn'] : null;
                            $payment->pg_authorization_code = isset($paymentInstrument['pgAuthorizationCode']) ? $paymentInstrument['pgAuthorizationCode'] : null;
                            $payment->pg_transaction_id = isset($paymentInstrument['pgTransactionId']) ? $paymentInstrument['pgTransactionId'] : null;
                            $payment->bank_transaction_id = isset($paymentInstrument['bankTransactionId']) ? $paymentInstrument['bankTransactionId'] : null;
                            $payment->bank_id           = isset($paymentInstrument['bankId']) ? $paymentInstrument['bankId'] : null;
                            $payment->pg_service_transaction_id = isset($paymentInstrument['pgServiceTransactionId']) ? $paymentInstrument['pgServiceTransactionId'] : null;
                            $payment->payment_status    = 'SUCCESS';
                            $payment->response_msg      = json_encode($paymentInstrumentDetails);
                        }

                        $payment->order_id = $order->id;
                        $payment->save();

                        $this->stockDecrease($basket->id);
                        OrderAddress::where('basket_id', $basket->id)->where('user_id', $user->id)->update(['order_id' => $order->id]);
                        Basket::where('id', $basket->id)->update(['status' => 1]);
                    } else {
                        dd('access decided,transaction_id doesn`t matched-userId : ' . auth()->user()->id);
                    }
                } else {
                    dd('access decided,basket doesn`t matched-userId : ' . auth()->user()->id);
                }
            } else {
                dd('access decided,basket expired-userId : ' . auth()->user()->id);
            }

            $invoice_id = $order->invoice_id;

            $this->sendOrderNotification($order);
            dd(123);
            return view('frontend.thanks', compact('order'));
        } else {

            //HANDLE YOUR ERROR MESSAGE HERE
            dd('Failed : ' . $request->code . ', Please Try Again Later.');
        }
    }




    public function submitCodForm($grandTotal = 1, User $user, $basket)
    {
        $amount         = $grandTotal;
        $user_name      =  $user->name;
        $user_mobile    =  $user->mobile;
        if ($user) {
            $user           = User::where('id', auth()->user()->id)->first();
            if (session()->has('session_string') && $user) {
                $session_string = session('session_string');
                $basket = Basket::whereHas('items')->where('session', $session_string)->where('status', 0)->first();
                if ($basket) {
                    $calculations  = $this->GrandTotalCalculation($basket);
                    $calculations = json_decode($calculations);

                    $subTotal    = $calculations->subTotal;
                    $tax_amount  = $calculations->TotalTax;
                    $discount    = $calculations->Discount;
                    $couponCode  = $calculations->DiscountCode;
                    $ship_charge = $calculations->ShippingCharge;
                    // $ship_tax    = $calculations->shippingTax;
                    $grandTotal  = $calculations->grandTotal;

                    $order              = new Order();
                    $order->user_id     = $user->id;
                    $order->invoice_id  = $this->invoiceNumberGenerate();
                    $order->basket_id   = $basket->id;
                    $order->subtotal    = $subTotal;
                    $order->discount    = $discount;
                    $order->tax         = $tax_amount;
                    $order->shipping_charge = $ship_charge;
                    $order->grandtotal  = $grandTotal;
                    $order->ipaddress   = request()->ip();
                    $order->coupon      = $couponCode;
                    $order->remarks     = '';
                    $order->billed_at   = date('Y-m-d H:i:s');
                    $order->status      = 'pending';
                    $order->paid        = 0;
                    $order->payment_method = 'cod';
                    $order->save();
                    OrderAddress::where('basket_id', $basket->id)->where('user_id', $user->id)->update(['order_id' => $order->id]);
                    Basket::where('id', $basket->id)->update(['status' => 1]);
                    $this->stockDecrease($basket->id);
                    OrderAddress::where('basket_id', $basket->id)->where('user_id', $user->id)->update(['order_id' => $order->id]);
                    Basket::where('id', $basket->id)->update(['status' => 1]);
                } else {
                    dd('access decided,basket doesn`t matched-userId : ' . auth()->user()->id);
                }
            } else {
                dd('access decided,basket expired-userId : ' . auth()->user()->id);
            }

            $invoice_id = $order->invoice_id;

            $this->sendOrderNotification($order);

            return view('frontend.thanks', compact('order'));
        } else {
            dd('Invalid Attempt, Please Try Again Later.');
        }
    }

    // public function confirmPayment(Request $request)
    // {
    //     Log::info('****************');
    //     Log::info($request->all());
    //     Log::info(auth()->user());
    //     Log::info(session()->has('session_string'));
    //     Log::info('----------------');

    //     if ($request->code == 'PAYMENT_SUCCESS') {

    //         $transactionId = $request->transactionId;
    //         $merchantId = $request->merchantId;
    //         $providerReferenceId = $request->providerReferenceId;
    //         $merchantOrderId = $request->merchantOrderId;
    //         $checksum = $request->checksum;
    //         $status = $request->code;
    //         $payment                = Payment::where('transaction_id', $transactionId)->first();


    //         $user           = User::where('id', $payment->user_id)->first();
    //         // session()->has('session_string') &&
    //         if ($user) {
    //             $session_string = session('session_string');
    //             $basket = Basket::whereHas('items')->where('user_id', $payment->user_id)->where('status', 0)->first();
    //             if ($basket) {
    //                 $calculations  = $this->GrandTotalCalculation($basket);
    //                 $calculations = json_decode($calculations);

    //                 $subTotal    = $calculations->subTotal;
    //                 $tax_amount  = $calculations->TotalTax;
    //                 $discount    = $calculations->Discount;
    //                 $couponCode  = $calculations->DiscountCode;
    //                 $ship_charge = $calculations->ShippingCharge;
    //                 // $ship_tax    = $calculations->shippingTax;
    //                 $grandTotal  = $calculations->grandTotal;



    //                 $paymentInstrumentDetails       = $this->CheckApiStatus($transactionId);

    //                 if ($payment) {
    //                     $order              = new Order();
    //                     $order->user_id     = $user->id;
    //                     $order->invoice_id  = $this->invoiceNumberGenerate();
    //                     $order->basket_id   = $basket->id;
    //                     $order->subtotal    = $subTotal;
    //                     $order->discount    = $discount;
    //                     $order->tax         = $tax_amount;
    //                     $order->shipping_charge = $ship_charge;
    //                     $order->grandtotal  = $grandTotal;
    //                     $order->ipaddress   = request()->ip();
    //                     $order->coupon      = $couponCode;
    //                     $order->remarks     = '';
    //                     $order->billed_at   = date('Y-m-d H:i:s');
    //                     $order->status       = 'SUCCESS';
    //                     $order->paid        = 1;
    //                     $order->save();


    //                     if (isset($paymentInstrumentDetails['data']['paymentInstrument'])) {

    //                         $paymentInstrument          = $paymentInstrumentDetails['data']['paymentInstrument'];
    //                         $payment->checksum          = $checksum;
    //                         $payment->reference_id      = $providerReferenceId;
    //                         $payment->payment_method    = isset($paymentInstrument['type']) ? $paymentInstrument['type'] : null;
    //                         $payment->utr               = isset($paymentInstrument['utr']) ? $paymentInstrument['utr'] : null;
    //                         $payment->card_type         = isset($paymentInstrument['cardType']) ? $paymentInstrument['cardType'] : null;
    //                         $payment->arn               = isset($paymentInstrument['arn']) ? $paymentInstrument['arn'] : null;
    //                         $payment->pg_authorization_code = isset($paymentInstrument['pgAuthorizationCode']) ? $paymentInstrument['pgAuthorizationCode'] : null;
    //                         $payment->pg_transaction_id = isset($paymentInstrument['pgTransactionId']) ? $paymentInstrument['pgTransactionId'] : null;
    //                         $payment->bank_transaction_id = isset($paymentInstrument['bankTransactionId']) ? $paymentInstrument['bankTransactionId'] : null;
    //                         $payment->bank_id           = isset($paymentInstrument['bankId']) ? $paymentInstrument['bankId'] : null;
    //                         $payment->pg_service_transaction_id = isset($paymentInstrument['pgServiceTransactionId']) ? $paymentInstrument['pgServiceTransactionId'] : null;
    //                         $payment->payment_status    = 'SUCCESS';
    //                         $payment->response_msg      = json_encode($paymentInstrumentDetails);
    //                         $payment->save();
    //                     }
    //                     $this->stockDecrease($basket->id);
    //                     OrderAddress::where('basket_id', $basket->id)->where('user_id', $user->id)->update(['order_id' => $order->id]);
    //                     Basket::where('id', $basket->id)->update(['status' => 1]);
    //                 } else {
    //                     dd('access decided,transaction_id doesn`t matched-userId : ' . auth()->user()->id);
    //                 }
    //             } else {
    //                 dd('access decided,basket doesn`t matched-userId : ' . auth()->user()->id);
    //             }
    //         } else {
    //             dd('access decided,basket expired-userId : ' . auth()->user()->id);
    //         }

    //         $invoice_id = $order->invoice_id;

    //         $this->sendOrderNotification($order);

    //         return view('frontend.thanks', compact('providerReferenceId', 'transactionId', 'invoice_id'));
    //     } else {

    //         //HANDLE YOUR ERROR MESSAGE HERE
    //         dd('Failed : ' . $request->code . ', Please Try Again Later.');
    //     }
    // }




    public function CheckApiStatus($transactionId)
    {
        $saltIndex = 1;
        $merchantId = env('PHONEPE_MERCHANT_ID');
        $saltKey     = env('PHONEPE_SALT_KEY');
        $url        = env('PHONEPE_URL');

        $finalXHeader = hash('sha256', '/pg/v1/status/' . $merchantId . '/' . $transactionId . $saltKey) . '###' . $saltIndex;

        // API Endpoint
        $url = "https://api.phonepe.com/apis/hermes/pg/v1/status/$merchantId/$transactionId";

        // Send request to PhonePe
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'accept' => 'application/json',
            'X-VERIFY' => $finalXHeader,
            'X-MERCHANT-ID' => $merchantId,
        ])->get($url);



        return $response->json();
    }

    public function giftCodeApply(Request $request)
    {
        $date_now                = date('Y-m-d h:i:s');
        $response                = array();
        $response['result']      = 0;
        $response['msg']         = '';
        $response['value']       = 0;
        $response['value_type']  = 0;
        $response['coupon_id']   = 0;
        $response['coupon_code'] = 0;
        $subTotal = 0;
        $session_string = session('session_string');;
        $basket = Basket::where('session', $session_string)->where('status', 0)->first() ?? abort(404);

        $items = CartItem::where('basket_id', $basket->id)->get();
        foreach ($items as $listing) {
            $itemSubTtl      = floatval($listing->price_amount * $listing->quantity);

            $subTotal      = $subTotal + $itemSubTtl;
        }


        $coupon_details = Coupon::where('code', $request->gift_code)->where('start_time', '<=', $date_now)->where('end_time', '>=', $date_now)->where('min_sales', '<=', $subTotal)->first();
        if ($coupon_details && $coupon_details->value_type) {
            if ($coupon_details->value_type == 'percentage') {
                $value = intval($coupon_details->value) . '% OFF';
            } else {
                $value = '$' . $coupon_details->value . ' OFF';
            }

            $basket->coupon = $coupon_details->id;
            $basket->save();

            $response['msg']      = '<span class="text-success">Coupon "' . $request->gift_code . '" Applied ' . $value . '</span>';
            $response['value']       = $coupon_details->value;
            $response['coupon_id']   = $coupon_details->id;
            $response['coupon_code'] = $coupon_details->code;
            $response['value_type']  = $coupon_details->value_type;
            $response['result']      = 1;

            return  response()->json($response);
        } else {
            $response['msg']      = '<span class="text-danger">Coupon "' . $request->gift_code . '" is invalid or not applicable</span>';
            $response['result']      = 0;
            $response['value']       = 0;
            $response['value_type']  = '';

            $basket->coupon = null;
            $basket->save();

            return  response()->json($response);
        }
    }



    public function stockDecrease($basket_id)
    {
        $basket = Basket::with('items')->whereId($basket_id)->first();
        if ($basket) {
            foreach ($basket->items ?? [] as $item) {
                $product = ProductVariant::where('id', $item->product_variation_id)->first();
                if ($product) {
                    $product->in_stock = ($product->in_stock - $item->quantity ?? 0);
                    $product->save();
                }
            }
        }

        return 1;
    }
}
