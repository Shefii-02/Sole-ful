<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Basket;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Myaddress;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function placeOrder(Request $request)
    {



        $this->submitPaymentForm($request);

        if (session()->has('session_string')) {
            $session_string = session('session_string');

            $basket = Basket::where('session', $session_string)->where('status', 0)->first() ?? abort(404);

            if ((env('APP_URL') == 'https://www.stage.mysweetiepie.ca')) {
                if (($request->nameOnCard == 'Card Test') &&  ($request->cardNumber == 4111111111111111)) {
                } else {
                    return redirect('/checkout')->withInput($request->input())->with('error', 'Payment Failed' . '<br><span style="color:red;font-size:16px;font-weight:700;">Only accepted Test cards<span>');
                }
            }

            if (!auth()->check()) {

                $billing_data['firstname']   = $request->b_firstname;
                $billing_data['lastname']    = $request->b_lastname;
                $billing_data['address']     = $request->b_address;
                $billing_data['postalcode']  = $request->b_postal;
                $billing_data['city']        = $request->b_city;
                $billing_data['province']    = $request->b_province;
                $billing_data['phone']       = $request->b_phone;
                $billing_data['email']       = $request->b_email;
                $billing_data['password']     = $request->password;

                $billing_add = json_decode(json_encode($billing_data));

                ////////////////////////////////////////////////////////////
                // if($request->has('same_billing')){
                $shipping_add = array();

                $shipping_add['firstname']   = $request->s_firstname;
                $shipping_add['lastname']    = $request->s_lastname;
                $shipping_add['address']     = $request->s_address;
                $shipping_add['postalcode']  = $request->s_postal;
                $shipping_add['city']        = $request->s_city;
                $shipping_add['province']    = $request->s_province;
                $shipping_add['phone']       = $request->s_phone;
                $shipping_add['email']       = $request->s_email;


                $shipping_data = json_decode(json_encode($shipping_add)); // convert array to collection
                // }
             
            }

            if ($basket) {
                //calculation_part
                $calculations  = $this->GrandTotalCalculation($basket);

                $calculations = json_decode($calculations);

                $totalAmount = $calculations->subTotal;
                $tax_amount  = $calculations->TotalTax;
                $discount    = $calculations->Discount;
                $couponCode  = $calculations->DiscountCode;
                $ship_charge = $calculations->ShippingCharge;
                $ship_tax    = $calculations->shippingTax;
                $grand       = $calculations->grandTotal;

                DB::beginTransaction();

                try {
                    MyAddress::where('basket_id', $basket->id)->delete();

                    //existing customer address details
                    if (auth()->check()) {
                        $billing_add  = MyAddress::where('id', $request->billing_address)->first();
                        if (!$billing_add) {
                            $billing_add = MyAddress::where('user_id', auth()->user()->id)->first();
                        }

                        $this->storeAddress($billing_add, $basket->id, 'billing');

                        if ($basket->order_type == 'delivery') {
                            // if(!$request->has('same_billing')){
                            //     $this->storeAddress($billing_add,$basket->id,'delivery');
                            // }
                            // else
                            // {
                            $shipping_add = MyAddress::where('id', $request->shipping_address)->first();
                            if (!$shipping_add && $shipping_data) {
                                $shipping_add = $shipping_data;
                            }
                            $this->storeAddress($shipping_add, $basket->id, 'delivery');
                            // }
                        }

                        $basket->email = auth()->check() ? auth()->user()->email : $billing_add->email;
                        $basket->user_id = auth()->user()->id;
                        $basket->save();
                    } else {
                        //gust customer address details

                        $this->storeAddress($billing_add, $basket->id, 'billing');

                        if ($basket->order_type == 'delivery') {
                            // if(!$request->has('same_billing')){
                            //     $this->storeAddress($billing_add,$basket->id,'delivery');
                            // }
                            // else
                            // {
                            $this->storeAddress($shipping_data, $basket->id, 'delivery');
                            // }
                        }
                    }

                

                    ///////////////////////////////////////////////////Payment Integration////////////////////////////////////////////////////////////////////////////
                    $now = \DateTime::createFromFormat('U.u', microtime(true));
                    $paymeny_id = 'Soleful' . $now->format("YmdHis") . rand(0, 10);
                  
                    $pay = $this->makePayment($paymeny_id, $grand, $basket, $request);

                    $refNum = $pay->getReferenceNum();
                    $txnNum = $pay->getTxnNumber();
                    $resCod = $pay->getResponseCode();

                    // 
                    if (($pay->getResponseCode() < 50 && strlen($refNum) > 5 && strlen($txnNum) > 5 && is_numeric($resCod)) || env('APP_URL') == 'https://www.stage.mysweetiepie.ca') {

                        $order              = new Order();
                        $order->basket_id   = $basket->id;
                        $order->subtotal    = $totalAmount;
                        $order->taxamount   = $tax_amount;
                        $order->discount    = $discount;
                        $order->coupon      = $couponCode;
                        $order->shipping_charge = floatval($ship_charge);
                        $order->grandtotal  = $grand;
                        $order->user_id     = auth()->check() ? auth()->user()->id : NULL;
                        $order->ipaddress   = request()->ip();
                        $order->email       = auth()->check() ? auth()->user()->email : $billing_add->email;
                        $order->status      = 0;
                        $s_add = [];
                        $order->payment_method = 'credit_card';
                        $order->card_type   = $this->identifyCreditCard($request->cardNumber);

                        $order->reference_num = $refNum;
                        $order->transaction_id = $txnNum;
                        $order->payment_status = 1;
                        $order->status  = 1;
                        $order->billed_at  = date('Y-m-d H:i:s');
                        $inv_id = $this->invoiceNumberGenerate();
                        $order->invoice_id  = $inv_id;
                        $order->paymeny_id  = $paymeny_id;
                        $order->affiliate_id = $basket->affiliate_id;
                        $order->save();

                        $basket->open   = 0;
                        $basket->page = 'thankyou';
                        $basket->save();

                        if ($basket->discount > 0 && $basket->coupon) {
                            Coupon::whereName($basket->coupon)->increment('usage');
                        }

                        if ($order->status == 1) {

                            MyAddress::where('basket_id', $basket->id)->update(['order_id' => $order->id]);


                            $basket->status = '1';
                            $basket->marketing_campaign_id = session()->has('campId') ? session('campId') : null;
                            $basket->save();
                        }

                        $invoice_id = $order->invoice_id;

                        DB::commit();



                        try {
                            $this->SendDataTrait();
                            // Dispatch the SendDataJob to the queue
                            // SendDataJob::dispatch()->delay(now()->addSeconds(10)); // Delayed dispatch

                        } catch (\Exception $e) {
                        }

                        if ($order->status == 1) {
                            $randomString = Str::random(45);
                            session(['session_string' => $randomString]);
                        }

                        if ($basket->special_campaign == 1) {
                            session()->flush();
                        }

                        $string = base64_encode(serialize(array('order_id' => $order->id, 'basket_id' => $basket->id)));

                        return redirect('/thankyou?order=' . $string);
                    } else {
                        $message_text = $pay->getMessage();
                        MyAddress::where('basket_id', $basket->id)->delete();
                        return redirect('/checkout')->withInput($request->input())->with('error', 'Payment Failed' . '<br><span style="color:red;font-size:16px;font-weight:700;">' . $message_text . '-' . $pay->getResponseCode() . '<span>'); //
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    MyAddress::where('basket_id', $basket->id)->delete();
                }
            } else {
                return redirect('/');
            }
        } else {
            return redirect('/');
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
                    "item_brand" => "Sweetiepie",
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
                "currency" => "CAD",
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
            $ggtrans .= '"Sweetiepie",';
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

    public function storeAddress($data, $basket_id, $type)
    {
        $address = $data;
        try {
            $save_add              = new Myaddress();
            $save_add->order_id    = 0;
            $save_add->name   = $address->name;
            $save_add->address     = $address->address;
            $save_add->postalcode  = $address->postalcode;
            $save_add->city        = $address->city;
            $save_add->province    = $address->province;
            $save_add->country     = 'CA';
            $save_add->phone       = auth()->check() ? auth()->user()->phone : $address->phone;
            $save_add->email       = auth()->check() ? auth()->user()->email : $address->email;
            $save_add->type        = $type;
            $save_add->user_id     = auth()->check() ? auth()->user()->id : 0;
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
        return 'Soleful' . date('ymd') . sprintf('%04d', $ordercount + 1);
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

        $coupon_details = Coupon::where('id', $basket->coupon_id)->where('start_time', '<=', $date_now)->where('end_time', '>=', $date_now)->where('min_sale', '<=', $subTotal2)->first();
        if ($coupon_details && $basket->coupon_id != '' && $basket->coupon_id != NULL) {
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
                $items = CartItem::where('basket_id', $basket->id)->get();
                if ($items) {
                    foreach ($items as $listing) {
                        if ($listing->product_variation) {
                            if ($listing->has_special_price == 1) {
                                $checkSpecialPrice    = $listing->product->has_special_price == 1 && $listing->product->special_price_from <= date('Y-m-d') && $listing->product->special_price_to >= date('Y-m-d');
                                if (!$checkSpecialPrice && $listing->product->has_special_price == 1) {
                                    CartItem::where('id', $listing->id)->update(['has_special_price' => 0, 'price_amount' => $listing->product->price, 'special_price_from' => null, 'special_price_to' => null]);
                                }
                            }
                        } else {
                            CartItem::where('id', $listing->id)->delete();
                        }
                    }
                }
            }
        }
    }


    public function submitPaymentForm(Request $request)
    {
        $amount = 2000;
        $name   = 'shefii';

        if ($name != '' && $amount != '') {

            $merchantId = env('PhonePeMerchantId');
            $apiKey = env('PhonePeApiKey');

            $redirectUrl = url('confirm');
            $order_id = uniqid();


            $transaction_data = array(
                'merchantId' => "$merchantId",
                'merchantTransactionId' => "$order_id",
                "merchantUserId" => $order_id,
                'amount' => $amount * 100,
                'redirectUrl' => "$redirectUrl",
                'redirectMode' => "POST",
                'callbackUrl' => "$redirectUrl",
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
                CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
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
                    'amount' => $amount,
                    'transaction_id' => $order_id,
                    'payment_status' => 'PAYMENT_PENDING',
                    'response_msg' => $response,
                    'providerReferenceId' => '',
                    'merchantOrderId' => '',
                    'checksum' => ''
                ];


                dd($res, $data, 'Pending for Payment integration');

                // end database insert

                if (isset($res->code) && ($res->code == 'PAYMENT_INITIATED')) {

                    $payUrl = $res->data->instrumentResponse->redirectInfo->url;

                    return redirect()->away($payUrl);
                } else {
                    //HANDLE YOUR ERROR MESSAGE HERE
                    dd('ERROR : ' . $res);
                }
            }
        }
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

        $coupon_details = Coupon::where('availability', '<>', 'in-store')->where('code', $request->gift_code)->where('start_time', '<=', $date_now)->where('end_time', '>=', $date_now)->where('min_sale', '<=', $subTotal)->first();
        if ($coupon_details && $coupon_details->value_type) {
            if ($coupon_details->value_type == 'percentage') {
                $value = intval($coupon_details->value) . '% OFF';
            } else {
                $value = '$' . $coupon_details->value . ' OFF';
            }

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

            return  response()->json($response);
        }
    }
}
