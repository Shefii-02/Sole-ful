<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBasketRequest;
use App\Http\Requests\UpdateBasketRequest;
use App\Models\Basket;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BasketController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBasketRequest $request)
    {
        DB::beginTransaction();
        //
        if (session()->has('session_string')) {
            $randomString = session('session_string');
        } else {
            $randomString = Str::random(45);
        }

        session(['session_string' => $randomString]);


        if (session()->has('session_string')) {
            $session_string = session('session_string');
        } else {
            $session_string = $randomString;
        }

        $basket = Basket::where('session', $session_string)->where('status', 0)->first();
        //if basket not created then create a new one
        if (!$basket) {
            $basket = new Basket();
            $basket->session = $session_string;
            $basket->save();
        }


        $productVariation          = ProductVariant::with('products')->where('id', $request->pdct_id)->first();

        if ($productVariation) {
            $items = CartItem::where('product_sku', $productVariation->sku)->where('basket_id', $basket->id)->first();
            if (!$items) {
                $items                   = new CartItem();
                $items->basket_id         = $basket->id;
                $items->product_id       = $productVariation->product->id;
                $items->product_variation_id = $productVariation->id;
                $items->parent           = null;
                $items->product_sku      = $productVariation->sku;
                $items->product_name     = $productVariation->product->product_name;
                $items->variation        = $request->product_name ?? $productVariation->variation_name;
                $items->prev_quantity    = null;
                $items->quantity         = $request->quantity;
                $items->price_amount     = $productVariation->price;
                $items->picture          = $productVariation->images->first()->image;
                $items->special_note     = $productVariation->variation;
            } else {
                $items->quantity        = $items->quantity + $request->quantity;
            }

            try {
                if ($request->quantity >= 1) {
                    $items->save();
                } else {
                    $items->delete();
                }

                $itemsCounts = CartItem::where('basket_id', $basket->id)->count();
                $response['result'] = true;
                $response['cart_count'] = $itemsCounts;
                $response['message'] = 'Product Added to your cart';
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $response['result'] = false;
                $response['cart_count'] = CartItem::where('basket_id', $basket->id)->count();
                $response['message'] = 'Product Can`t be added, some issue please try again';
            }
        } else {
            $response['result'] = false;
            $response['cart_count']     = CartItem::where('basket_id', $basket->id)->count();
            $response['message'] = 'Product Can`t be added, beacause invalid request..';
        }

        return  response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function cart(Basket $basket)
    {
        $session_string = session('session_string');
        $basket = Basket::where('session', $session_string)->where('status', 0)->first();
        if ($basket) {
            $items = CartItem::with('product')->where('basket_id', $basket->id)->get();
            return view('frontend.cart', compact('items', 'basket'));
        } else {
            return view('frontend.cart');
        }
    }

    public function productadd(Request $request)
    {
        $response = array();
        $response['result'] = 0;
        $response['cart_count'] = 0;
        $response['addToCartData'] = '';

        if (session()->has('session_string')) {
            $session_string = session('session_string');;
            $basket = Basket::where('session', $session_string)->where('status', 0)->first();

            if ($basket) {
                $pdct_vari        = ProductVariation::where('id', $request->product_id)->first();
                if ($pdct_vari) {
                    $psku  = $pdct_vari->sku;
                } else {
                    $psku = $request->product_sku;
                }
                $items            = Item::where('product_sku', $psku)->where('basket_id', $basket->id)->first();
                $items->quantity =  $request->quantity;
                try {
                    if ($request->quantity >= 1) {
                        $items->save();
                    } else {
                        $items->delete();
                    }

                    $itemsCounts = Item::where('basket_id', $basket->id)->count();

                    if ($itemsCounts == 0) {
                        $basket->special_campaign = 0;
                        $basket->serve_date = NULL;
                        $basket->serve_time = NULL;
                        $basket->save();
                    }
                    $response['result'] = 1;
                    $response['cart_count'] = $itemsCounts;


                    $items_val[] = [
                        "item_id"     => $items->product_sku,
                        "item_name"   => $items->product_name,
                        "affiliation" => $basket ? $basket->city ?? "" : '',
                        "index"       => 0,
                        "item_brand"  => "Sweetiepie",
                        "item_variant" => $items->variation,
                        "location_id" => "Toronto",
                        "price"       => $items->price_amount,
                        "quantity"    => $items->quantity
                    ];

                    $response['addToCartData'] = [
                        "currency" => "CAD",
                        "value" => $items->price_amount,
                        "items" =>  $items_val
                    ];


                    return  response()->json($response);
                } catch (Exceprion $e) {
                    $response['cart_count'] = Item::where('basket_id', $basket->id)->count();
                    return  response()->json($response);
                }
            }
        }


        return  response()->json($response);
    }

    public function checkout(Request $request)
    {


        $this->CartRefresh();

        if (session()->has('session_string')) {


            $session_string = session('session_string');

            $basket = Basket::where('session', $session_string)->where('status', 0)->first();

            if ($basket) {
                if ($request->all() != null && $basket->special_campaign == 0) {
                    if ($basket->order_type == 'pickup') {
                        $basket->serve_date = $request->pickup_date;
                        $basket->serve_time = $request->pickup_time;
                    } else {
                        $basket->serve_date = $request->shipping_date;
                    }
                    $basket->remarks = $request->remark;
                }

                $basket->save();
                $items = Item::with('parentItem')
                    ->where('basket_id', $basket->id)
                    ->where(function ($query) {
                        $query->whereNull('parent')
                            ->orWhere('parent', '=', 0); // Add this line to include items with parent = 0 if applicable
                    })
                    ->get();

                if ($items->count() > 0) {
                    $shiiping_method = Shipping::where('order_type', $basket->order_type)->first();
                    $cities     = City::get();
                    $province   = Province::get();
                    $greetingCardproducts   =   Product::with('product_variation', 'images', 'product_city', 'variationList', 'specializations')
                        ->whereHas('product_variation', function ($query) {
                            $query->where('sku', '<>', '');
                        })
                        ->where('greeting_card', '1')
                        ->get();

                    if (($basket->order_type == 'pickup' && $basket->serve_date != '' && $basket->serve_time != '') || ($basket->order_type == 'delivery' && $basket->serve_date != '')) {
                        return view('frontend.checkout', compact('items', 'shiiping_method', 'basket', 'cities', 'province', 'greetingCardproducts'));
                    } else {
                        return redirect('/cart');
                    }
                } else {
                    return redirect('/cart');
                }
            }
        }
        return redirect('/cart');
    }
    public function gift_code_apply(Request $request){
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
        $basket = Basket::where('session',$session_string)->where('status',0)->first() ?? abort(404);


        $items = Item::where('basket_id',$basket->id)->get();
        foreach ($items as $listing){
            $itemSubTtl      = floatval($listing->price_amount * $listing->quantity);
           
            $subTotal      = $subTotal + $itemSubTtl;
        }
        
        $coupon_details = Coupon::where('availability','<>','in-store')->where('code',$request->gift_code)->where('start_time','<=',$date_now)->where('end_time','>=',$date_now)->where('min_sale','<=',$subTotal)->first();
        if($coupon_details && $coupon_details->value_type){
            if($coupon_details->value_type == 'percentage'){
                $value = intval($coupon_details->value). '% OFF';
            }
            else
            {
                $value = '$'.$coupon_details->value. ' OFF';
            }
            
            $response['msg']      = '<span class="text-success">Coupon "'.$request->gift_code.'" Applied '.$value.'</span>';
            $response['value']       = $coupon_details->value;
            $response['coupon_id']   = $coupon_details->id;
            $response['coupon_code'] = $coupon_details->code;
            $response['value_type']  = $coupon_details->value_type; 
            $response['result']      = 1;
            
            $basket->coupon_id = $coupon_details->id;
            $basket->save();
            return  response()->json($response);
        }
        else
        {
            $response['msg']      = '<span class="text-danger">Coupon "'.$request->gift_code.'" is invalid or not applicable</span>';
            $response['result']      = 0;
            $response['value']       = 0;
            $response['value_type']  = ''; 
            
            $basket->coupon_id = NULL;
            $basket->save();
            return  response()->json($response);
        }
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Basket $basket)
    {
        //
    }
}
