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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

        $productVariation          = ProductVariant::with('product')->where('id', $request->variation_id)->first();

        if ($productVariation) {
            if ($productVariation->in_stock >= $request->quantity) {
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
                    $items->prev_quantity    = 0;
                    $items->quantity         = $request->quantity;
                    $items->price_amount     = $productVariation->price;
                    $items->picture          = $productVariation->images->first()->image;
                    $items->special_note     = $productVariation->variation;
                    $response['message'] = 'Product Added to your cart <a href="/cart" target="_blank" class="my-3 btn btn-theme">View Cart</a>';
                    $response['result'] = true;
                } else {
                    if ($productVariation->in_stock >= $items->quantity + $request->quantity) {
                        $items->quantity        = $items->quantity + $request->quantity;
                        $response['message'] = 'Product Added to your cart <a href="/cart" target="_blank" class="my-3 btn btn-theme">View Cart</a>';
                        $response['result'] = true;
                    } else {
                        $response['result'] = false;
                        $response['message'] = "You have already this product added total you have requested {($items->quantity + $request->quantity)} units, but we currently have only {$productVariation->in_stock} in stock. Please adjust your order quantity. or contact our customer care";
                    }
                }

                try {
                    if ($request->quantity >= 1) {
                        $items->save();
                    } else {
                        $items->delete();
                    }

                    $itemsCounts = CartItem::where('basket_id', $basket->id)->count();
                 
                    $response['cart_count'] = $itemsCounts;
                    DB::commit();
                } catch (Exception $e) {
                    
                    Log::info("ProductError :" . $e);

                    DB::rollBack();
                    $response['result'] = false;
                    $response['cart_count'] = CartItem::where('basket_id', $basket->id)->count();
                    $response['message'] = 'Product Can`t be added, some issue please try again ';
                }
            } else {
                $response['result'] = false;
                $response['cart_count'] = CartItem::where('basket_id', $basket->id)->count();
                $response['message'] = "You have requested {$request->quantity} units, but we currently have only {$productVariation->in_stock} in stock. Please adjust your order quantity. or contact our customer care";
            }
        } else {
            $response['result'] = false;
            $response['cart_count']     = CartItem::where('basket_id', $basket->id)->count();
            $response['message'] = 'Product Can`t be added, beacause invalid request..';
        }

        return  response()->json($response);
    }


    public function getCartList(Request $request)
    {
        if (session()->has('session_string')) {
            $session_string = session('session_string');;
            $basket = Basket::where('session', $session_string)->where('status', 0)->first();
            $products = CartItem::where('basket_id', $basket->id)->get();
            return view('frontend.partials.cart-listing', compact('products'))->render();
        } else {
            return view('frontend.partials.cart-listing')->render();
        }
    }

    /**
     * Display the specified resource.
     */
    public function cart(Basket $basket)
    {

        $session_string = session('session_string');
        $basket = Basket::where('session', $session_string)->where('status', 0)->first();

        $this->CartRefresh();
        if ($basket) {
            $items = CartItem::where('basket_id', $basket->id)->get();
            return view('frontend.cart', compact('items', 'basket'));
        } else {
            return view('frontend.cart');
        }
    }

    public function cartProductAdd(Request $request)
    {
        $response = array();
        $response['result'] = 0;
        $response['cart_count'] = 0;
        $response['addToCartData'] = '';

        if (session()->has('session_string')) {
            $session_string = session('session_string');;
            $basket = Basket::where('session', $session_string)->where('status', 0)->first();

            if ($basket) {
                $pdct_vari        = ProductVariant::where('id', $request->product_id)->first();

                if ($pdct_vari) {
                    $psku  = $pdct_vari->sku;
                } else {
                    $psku = $request->product_sku;
                }
                $items            = CartItem::where('product_sku', $psku)->where('basket_id', $basket->id)->first();

                try {
                  
                    if ($request->quantity >= 1) {
                        if ($pdct_vari->in_stock >= $request->quantity) {
                            $items->quantity =  $request->quantity;
                            $items->save();
                            $response['result'] = 1;
                        }
                        else{
                            $response['message'] = "You have requested {$request->quantity} units, but we currently have only {$pdct_vari->in_stock} in stock. Please adjust your order quantity. or contact our customer care";
                        }
                        
                     
                    } else {
                        $items->delete();
                        $response['result'] = 1;
                        $response['message'] = "Product Removed Successfully";
                    }

                    $itemsCounts = CartItem::where('basket_id', $basket->id)->count();

                    
                    // $response['result'] = 1;
                    $response['cart_count'] = $itemsCounts;


                    $items_val[] = [
                        "item_id"     => $items->product_sku,
                        "item_name"   => $items->product_name,
                        "affiliation" => $basket ? $basket->city ?? "" : '',
                        "index"       => 0,
                        "item_brand"  => "Soleful",
                        "item_variant" => $items->variation,
                        "location_id" => "Banguluru",
                        "price"       => $items->price_amount,
                        "quantity"    => $items->quantity
                    ];

                    $response['addToCartData'] = [                        
                        "currency" => "INR",
                        "value" => $items->price_amount,
                        "items" =>  $items_val
                    ];
                    return  response()->json($response);
                } catch (Exception $e) {
                    Log::error('Something Faced Error,please try again:'.$e);
                    $response['message'] = "Something Faced Error,please try again";
                    $response['cart_count'] = CartItem::where('basket_id', $basket->id)->count();
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


                $basket->save();
                $items = CartItem::where('basket_id', $basket->id)
                    ->where(function ($query) {
                        $query->whereNull('parent')
                            ->orWhere('parent', '=', 0); // Add this line to include items with parent = 0 if applicable
                    })
                    ->get();

                if ($items->count() > 0) {
                    return view('frontend.checkout', compact('items', 'basket'));
                } else {
                    return redirect('/cart');
                }
            }
        }
        return redirect('/cart');
    }

    function postSignin(Request $request)
    {
        $request->validate([
            'email'        => 'bail|required|email',
            'password'    => 'bail|required'
        ]);
        $rememberMe = $request->has('remember');
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $rememberMe)) {
            $session_string = session('session_string');
            $basket = Basket::where('session', $session_string)->where('status', 0)->first();

            if ($basket) {
                $basket->user_id =  auth()->user()->id;
                $basket->email =  auth()->user()->email;
                $basket->save();
            }
            if ($request->has('redirect_uri')) {
                return redirect($request->redirect_uri);
                exit;
            }

            session()->flash('success', 'You have successfully logged in.');
            return redirect()->back();
        } else {
            session()->flash('failed', 'Invalid login attempt');

            return redirect()->back();
        }
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
                        if (!$listing->product_variation || $listing->product_variation->in_stock < $listing->quantity) {
                            CartItem::where('id', $listing->id)->delete();
                        }
                    }
                }
            }
        }
    }
}
