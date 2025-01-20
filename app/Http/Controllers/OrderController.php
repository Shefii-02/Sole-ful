<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Basket;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;

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

    public function place_order(CheckoutFormRequest $request)
    {

        if (session()->has('session_string')) {

            $session_string = session('session_string');

            $basket = Basket::where('session', $session_string)->where('status', 0)->first() ?? abort(404);

            if ((env('APP_URL') == 'https://www.stage.mysweetiepie.ca')) {
                if (($request->nameOnCard == 'Card Test') &&  ($request->cardNumber == 4111111111111111)) {
                } else {
                    return redirect('/checkout')->withInput($request->input())->with('error', 'Payment Failed' . '<br><span style="color:red;font-size:16px;font-weight:700;">Only accepted Test cards<span>');
                }
            }


            if ($basket->order_type == 'pickup') {
                $store = Store::where('id', $basket->pickup_id)->first();
            } else {
                $store = Store::where('shipping', 1)->first() ?? '';


                if ($request->has('make_gift_checkbox')) {
                    $basket->make_gift   = $request->has('make_gift_checkbox') ? 1 : 0;
                    $basket->card_msg    = $request->card_msg;
                    $basket->save();
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
                //////////////////////////////////////////////////////Sign up///////////////////////////////////////
                if ($request->has('clickedSignup')) {
                    if ($user = $this->userSignup($billing_add)) {

                        Auth::login($user);

                        if ($basket) {
                            $basket = Basket::where('id', $basket->id)->first();
                            $basket->user_id    =  $user->id;
                            $basket->email      =  $user->email;
                            $basket->save();
                        }
                    }
                }
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
                    Address::where('basket_id', $basket->id)->delete();

                    //existing customer address details
                    if (auth()->check()) {
                        $billing_add  = Myaddress::where('id', $request->billing_address)->first();
                        if (!$billing_add) {
                            $billing_add = Myaddress::where('user_id', auth()->user()->id)->first();
                        }

                        $this->storeAddress($billing_add, $basket->id, 'billing');

                        if ($basket->order_type == 'delivery') {
                            // if(!$request->has('same_billing')){
                            //     $this->storeAddress($billing_add,$basket->id,'delivery');
                            // }
                            // else
                            // {
                            $shipping_add = Myaddress::where('id', $request->shipping_address)->first();
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

                    //promotional_mails store
                    if ($request->has('promotional_mails')) {
                        $already = Subscribe::where('email', $billing_add->email)->first();
                        if (!$already && isset($billing_add->email)) {

                            $new = new Subscribe();
                            $new->email = $billing_add->email;
                            $new->save();
                        }

                        // $apiDomain = env('TNG_API_DOMAIN'); 
                        // $url = $apiDomain."/api/website/new-subscriber";
                        // $post = ['email'        => auth()->check() ? auth()->user()->email : $billing_add->email];
                        // $result__api = CurlSendPostRequest($url,$post);
                        // $result__api = json_decode($result__api);
                    }


                    ///////////////////////////////////////////////////Payment Integration////////////////////////////////////////////////////////////////////////////
                    $now = \DateTime::createFromFormat('U.u', microtime(true));
                    $paymeny_id = 'SWP' . $now->format("YmdHis") . rand(0, 10);
                    // $pay = $this->makePayment($paymeny_id,$grand,$basket,$request);

                    // $refNum = $pay->getReferenceNum();
                    // $txnNum = $pay->getTxnNumber();
                    // $resCod = $pay->getResponseCode();
                    // $receipt = new MonerisReceipt($pay->receipt());
                    // $txnNum = $receipt->read('transaction');
                    // $refNum = $receipt->read('reference');
                    // $resCod = $pay->status;


                    // // 
                    // if( ($resCod< 50 && strlen($refNum) > 5 && strlen($txnNum) > 5 && is_numeric($resCod)) || env('APP_URL') == 'https://www.stage.mysweetiepie.ca')
                    // {
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
                            Discount::whereName($basket->coupon)->increment('usage');
                        }

                        if ($order->status == 1) {

                            Address::where('basket_id', $basket->id)->update(['order_id' => $order->id]);


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
                        Address::where('basket_id', $basket->id)->delete();
                        return redirect('/checkout')->withInput($request->input())->with('error', 'Payment Failed' . '<br><span style="color:red;font-size:16px;font-weight:700;">' . $message_text . '-' . $pay->getResponseCode() . '<span>'); //
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    Address::where('basket_id', $basket->id)->delete();
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
            $save_add              = new Address();
            $save_add->order_id    = 0;
            $save_add->firstname   = $address->firstname;
            $save_add->lastname    = $address->lastname;
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

    public function userSignup($billing)
    {
        $userCheck = User::where('email', $billing->email)->first();

        if (!$userCheck) {
            $user               = new User();
            $user->email         = $billing->email;
            $user->firstname     = $billing->firstname;
            $user->lastname     = $billing->lastname;
            $user->name         = $billing->firstname . ' ' . $billing->lastname;
            $user->address      = $billing->address;
            $user->postalcode     = $billing->postalcode;
            $user->city          = $billing->city;
            $user->province     = $billing->province;
            $user->country      = 'canada';
            $user->phone        = $billing->phone;
            $user->province     = $billing->province;
            $user->birthday     = '';
            $user->password     = Hash::make($billing->password);
            $user->status          = 1;

            try {
                $user->save();

                $myadd              = new Myaddress();
                $myadd->user_id        = $user->id;
                $myadd->firstname   = $user->firstname;
                $myadd->lastname    = $user->lastname;
                $myadd->address     = $user->address;
                $myadd->postalcode  = $user->postalcode;
                $myadd->city        = $user->city;
                $myadd->province    = $user->province;
                $myadd->country      = 'canada';
                $myadd->base        = '1';
                $myadd->save();

                try {
                    Mail::to($user->email)->send(new SignupMail($user));
                } catch (\Exception $e) {
                }

                return $user;
            } catch (\Exception $e) {
            }

            return false;
        } else {
            return false;
        }
    }
    function makePayment($paymeny_id, $grand_total, $basket, Request $request)
    {
        $store_id = 'gwca049783';
        $api_token = 'HlZvxtFTjW1WOobrS9wj';

        //$store_id = 'store3'; //'monca06152';
        //$api_token = 'yesguy'; //'CfYSX9fhTgM8v1vPXd8Q';

        /*if(($request->has('cardtest') && $request->cardtest == 'yes') || $_SERVER['REMOTE_ADDR'] == '127.0.0.1')
        {
            $store_id='store5';
            $api_token='yesguy';
        }*/

        $exp_dates = explode('/', $request->expirationDate);

        $cvv = $request->securityCode;
        $expiry_year = $exp_dates[1];
        $expiry_month = sprintf("%02d", $exp_dates[0]); // Format the month as a two-digit number
        $date = $expiry_year . $expiry_month;

        $customername   = $request->nameOnCard;
        $type           = 'purchase';
        $cust_id        = $customername . ' | ' . $basket->email;
        $order_id       = $paymeny_id;
        $amount         = number_format($grand_total, 2);
        $pan            = $request->cardNumber;
        $expiry_date    = $date;
        $crypt          = '7';
        $dynamic_descriptor = 'MySweetiePie Order';
        $status_check   = 'false';

        $txnArray = array(
            'type' => $type,
            'order_id' => $order_id,
            'cust_id' => $cust_id,
            'amount' => $amount,
            'pan' => $pan,
            'expdate' => $expiry_date,
            'crypt_type' => $crypt,
            'dynamic_descriptor' => $dynamic_descriptor
        );

        $mpgTxn = new mpgTransaction($txnArray);
        $mpgRequest = new mpgRequest($mpgTxn);
        $mpgRequest->setProcCountryCode("CA");

        //if(($request->has('cardtest') && $request->cardtest == 'yes') || $_SERVER['REMOTE_ADDR'] == '127.0.0.1')

        // $mpgRequest->setTestMode(true);


        $mpgHttpPost  = new mpgHttpsPost($store_id, $api_token, $mpgRequest);
        $mpgResponse = $mpgHttpPost->getMpgResponse();


        return $mpgResponse;
    }

    
    function invoiceNumberGenerate(){
        $ordercount = Order::where('created_at','>=',date('Y-m-d 00:00:00'))->where('created_at','<=',date('Y-m-d 23:59:59'))->count();
        return 'SWP'.date('ymd').sprintf('%04d', $ordercount+1);
    }
    public function CheckOutCalculation(){
        
        $session_string = session('session_string');;
        $basket = Basket::where('session',$session_string)->where('status',0)->first() ?? abort(404); 
        $calculations  = $this->GrandTotalCalculation($basket);
        return view('frontend.checkout-calculation',compact('calculations','basket'))->render();
    }
    

        
    function GrandTotalCalculation($basket){
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
        $items = CartItem::where('basket_id',$basket->id)->get();
        $itemCount = $items->count() ?? 0;
   
        
        foreach ($items as $listing2){
            $itemSubTtl2      = floatval($listing2->price_amount * $listing2->quantity);
           
            $subTotal2      = $subTotal2 + $itemSubTtl2;
        }


            $coupon_details = Coupon::where('id',$basket->coupon_id)->where('start_time','<=',$date_now)->where('end_time','>=',$date_now)->where('min_sale','<=',$subTotal2)->first();
            if($coupon_details && $basket->coupon_id != '' && $basket->coupon_id != NULL){
                if($coupon_details->value_type == 'amount'){
                    $discount = floatval($coupon_details->value);
                    $discount_amount = 0;
                    if($itemCount > 0){
                        $discount_amount = floatval($discount/$itemCount);
                    }
                   
                    foreach ($items as $listing){
                        $itemSubTtl      = floatval($listing->price_amount * $listing->quantity);
                        $itemSub_total   = $itemSubTtl - $discount_amount;
                        $itemttlTax[]    = ($itemSub_total * $listing->tax_percentage) / 100;
                        $subTotal[]      = $itemSubTtl;
                    }
                }
                else
                {
                    $dicountPercentage = $coupon_details->value;
                    $ttlDiscount = array();
                    foreach ($items as $listing){
                        $itemSubTtl = floatval($listing->price_amount * $listing->quantity);
                        $discount_amount = ( $itemSubTtl * $dicountPercentage) / 100;
                        $itemSub_total   = $itemSubTtl - $discount_amount;
                        $itemttlTax[]    = ($itemSub_total * $listing->tax_percentage) / 100;
                        $ttlDiscount[]   =  $discount_amount;
                        $subTotal[]      = $itemSubTtl;
                    }
                    
                    $discount = array_sum($ttlDiscount);
                }
                
                
                $Calculation['DiscountCode'] =  $coupon_details->code;
            }
            else{
                foreach ($items as $listing){
                   
                        $amnt           = $listing->price_amount;
                    
                    	        
                    $itemSubTtl     = floatval($amnt * $listing->quantity);
                    $itemttlTax[]   = ($itemSubTtl * $listing->tax_percentage) / 100;
                    $subTotal[]     = $itemSubTtl;
                }
            }
            
            //shipping charge
            $shiping_method = Shipping::where('order_type',$basket->order_type)->first();
            $discount = min($discount, array_sum($subTotal));
            $Calculation['subTotal']        = array_sum($subTotal);
            $Calculation['itemTotalTax']    = array_sum($itemttlTax);
            $Calculation['Discount']        = $discount;
            $Calculation['ShippingCharge']  = $shiping_method->charge;
            $Calculation['shippingTax']     = ($shiping_method->charge * 13) / 100; 
            $Calculation['TotalTax']        = $Calculation['itemTotalTax'] + $Calculation['shippingTax'];
            $Calculation['grandTotal']      = ($Calculation['subTotal'] - $Calculation['Discount']) + $Calculation['ShippingCharge'] + $Calculation['TotalTax'] ;
            
        return json_encode($Calculation);
    }

    function identifyCreditCard($cardNumber) {
        $cardTypes = array(
            'visa_card'              => '/^4[0-9]{12}(?:[0-9]{3})?$/',
            'master_card'        => '/^5[1-5][0-9]{14}$/',
            'american_expres'  => '/^3[47][0-9]{13}$/',
            'discover_card'          => '/^6(?:011|5[0-9]{2})[0-9]{12}$/',
        );
    
        foreach ($cardTypes as $type => $pattern) {
            if (preg_match($pattern, $cardNumber)) {
                return $type;
            }
        }
    
        return null;
    }
        
        
    function CartRefresh(){
        if (session()->has('session_string')) {
            $session_string = session('session_string');
            $basket = Basket::where('session',$session_string)->where('status',0)->first();
            if($basket){
                $items = CartItem::where('basket_id',$basket->id)->get();
                if($items){
                    foreach($items as $listing){
                        if($listing->product_variation){
                            if($listing->has_special_price == 1){
                                $checkSpecialPrice    = $listing->product->has_special_price == 1 && $listing->product->special_price_from <= date('Y-m-d') && $listing->product->special_price_to >= date('Y-m-d');   
                                if(!$checkSpecialPrice && $listing->product->has_special_price == 1)
                                {
                                    CartItem::where('id',$listing->id)->update(['has_special_price' => 0,'price_amount' => $listing->product->price,'special_price_from' => null,'special_price_to' =>null]);
                                }
                            }
                        }
                        else{
                           CartItem::where('id',$listing->id)->delete(); 
                        }
                        
                    }
                }
            }
        }
    }
}
