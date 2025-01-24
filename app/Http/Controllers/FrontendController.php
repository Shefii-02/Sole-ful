<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Appointment;
use App\Models\Banner;
use App\Models\BestSellProduct;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Doctor;
use App\Models\Enquiry;
use App\Models\FeaturedProduct;
use App\Models\Package;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Service;
use App\Models\VariationKey;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;



class FrontendController extends Controller
{


    public function home()
    {
        if (Auth::check() && auth('web')->user()->type == 'superadmin') {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::check() && auth('web')->user()->type == 'user') {
            return redirect()->route('account.dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function index()
    {
        $banners                = Banner::where('status', 1)->select('desktop', 'mobile', 'link')->orderby('display_order');
        $slider_in_desktop      = $banners->whereNotNull('desktop')->select('desktop', 'link')->get();
        $slider_in_mobile       = $banners->whereNotNull('mobile')->select('mobile', 'link')->get();
        $bestSellProduct        = BestSellProduct::get();
        $featuredProduct        = FeaturedProduct::get();
        $blogs                  = BlogPost::orderBy('created_at', 'desc')->get();
        $productOffer           = Advertisement::where('text','product')->inRandomOrder()->limit(1)->first();
        return view('frontend.index', compact('slider_in_desktop', 'slider_in_mobile', 'bestSellProduct', 'featuredProduct', 'blogs','productOffer'));
    }

    public function getWishlist(Request $request)
    {
        $wishlistIds = $request->input('wishlist');
        $products = Product::whereIn('id', $wishlistIds)->get();

        return view('frontend.partials.wishlist', compact('products'))->render();
    }


    public function QuickView(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::where('id', $product_id)->first() ??  abort(404);

        return view('frontend.partials.product-single', compact('product'))->render();
    }

    public function shop(Request $request)
    {
        $productOffer           = Advertisement::where('text','product')->inRandomOrder()->limit(1)->first();

        $query = Product::where('status', 1);

        // Filter by price range
        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereHas('product_variation', function ($q) use ($request) {
                $q->whereBetween('price', [$request->price_min, $request->price_max]);
            });
        }

        // Filter by color
        if ($request->has('colors')) {

            $query->whereHas('variationKeys', function ($q) use ($request) {
                $q->where('type', 'color')->whereIn('value', $request->colors);
            });
        }

        // Filter by size
        if ($request->has('sizes')) {
            $query->whereHas('variationKeys', function ($q) use ($request) {
                $q->where('type', 'size')->whereIn('value', $request->sizes);
            });
        }

        if ($request->has('categories')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('name', $request->categories);
            });
        }

        $products = $query->get();

        // Get available colors with unique product counts
        $available_colors =  VariationKey::where('type', 'color')
            ->whereHas('product', function ($q) {
                $q->where('status', 1);
            })
            ->select('value', DB::raw('COUNT(DISTINCT product_id) as product_count'))
            ->groupBy('value')
            ->get();


        // Get available sizes with unique product counts
        $available_sizes = VariationKey::where('type', 'size')
            ->whereHas('product', function ($q) {
                $q->where('status', 1);
            })
            ->select('value', DB::raw('COUNT(DISTINCT product_id) as product_count'))
            ->groupBy('value')
            ->get();
        // Categories with product counts
        $categories = Category::with('products')->withCount([
            'products' => function ($query) {
                $query->where('status', 1);
            }
        ])->orderby('created_at', 'desc')->get();


        if ($request->ajax()) {
            // Render product list view and return as JSON for AJAX
            $html = view('frontend.product_list', compact('products'))->render();
            return response()->json(['html' => $html]);
        }

        return view('frontend.shop', compact('products', 'available_colors', 'available_sizes', 'categories','productOffer'));
    }


    public function product($uid, $slug)
    {
        $product = Product::where('unique_value', $uid)->where('slug', $slug)->first() ?? abort(404);
        $similarProducts = Product::limit(10)->get();
        $sizes = $product->variationKeys->where('type', 'size')->unique('value');
        $colors = $product->variationKeys->where('type', 'color')->unique('value');
        return view('frontend.product-single', compact('product', 'similarProducts', 'sizes', 'colors'));
    }


    public function getVariationDetails(Request $request)
    {
        $product = $request->product_id;
        $size    = $request->size;
        $variationIds = VariationKey::where('type','size')->where('product_id',$product)->where('value',$size)->pluck('variation_id');
        $variations = ProductVariant::query()->whereHas('variationkey', function ($q) use ($variationIds) {
                                                $q->whereIn('variation_id', $variationIds);
                                            })->get();
        
        return view('frontend.partials.product-variations', ['variations' => $variations])->render();
    }


    public function blogs()
    {
        $blogs   = BlogPost::where('status', 1)->orderby('created_at', 'desc')->get();
        return view('frontend.blogs', compact('blogs'));
    }

    public function blogCategory($slug)
    {
        $blogCategory = BlogCategory::where('slug', $slug)->first() ?? abort(404);
        $blogs   = BlogPost::where('status', 1)->where('category_id', $blogCategory->id)->orderby('created_at', 'desc')->get();
        return view('frontend.blogs', compact('blogs'));
    }

    public function blogSingle($slug)
    {
        $blogs   = BlogPost::where('status', 1)->orderby('created_at', 'desc')->get();
        $categories = BlogCategory::where('status', 1)->orderby('display_order')->get();
        $blog   = BlogPost::where('status', 1)->where('slug', $slug)->first() ?? abort(404);

        return view('frontend.blog-single', compact('blog', 'categories', 'blogs'));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function contactSend(Request $request)
    {
        DB::beginTransaction();
        try {
            $new            = new Enquiry();
            $new->name      = $request->fullname;
            $new->email     = $request->email;
            $new->mobile    = $request->phone;
            $new->notes     = $request->message;
            $new->status    = 0;
            $new->save();
            DB::commit();
            Session::flash('success_msg', 'Successfully Submited');
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }
    public function about()
    {
        return view('frontend.about');
    }

    public function appointment(Request $request)
    {
        DB::beginTransaction();
        try {
            $new            = new Appointment();
            $new->name      = $request->fullname;
            $new->email     = $request->email;
            $new->mobile    = $request->phone;
            $new->doctor_id = $request->has('doctor') ? $request->doctor : null;
            $new->service_id = $request->has('service_id') ? $request->service_id : null;
            $new->notes     = $request->message;
            $new->status    = 0;
            $new->save();
            DB::commit();
            Session::flash('success_msg', 'Successfully Submited');
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }




    protected function getTestimonials()
    {
        // Base API URL
        $url = 'https://maps.googleapis.com/maps/api/place/details/json';

        // Common parameters
        $commonParams = [
            'fields' => 'reviews,rating',
            'place_id' => env('GOOGLE_PLACE_ID'), // Get Place ID from .env
            'key' => env('GOOGLE_API_KEY'),      // Get API Key from .env
        ];

        // API Call 1: Without `reviews_sort`
        $response1 = Http::get($url, $commonParams);

        // API Call 2: With `reviews_sort=newest`
        $response2 = Http::get($url, array_merge($commonParams, ['reviews_sort' => 'newest']));

        // Check if both responses are successful
        if ($response1->successful() && $response2->successful()) {
            $data1 = $response1->json();
            $data2 = $response2->json();

            // Combine responses
            $combinedReviews = array_merge(
                $data1['result']['reviews'] ?? [],
                $data2['result']['reviews'] ?? []
            );

            // Remove duplicates by author_name
            $uniqueReviews = collect($combinedReviews)->unique('author_name')->values()->all();

            return [
                'status' => $response1->status() ?: $response2->status(),
                'rating' => $data1['result']['rating'] ?? $data2['result']['rating'] ?? 'No rating available',
                'reviews' => $uniqueReviews, // Combined and deduplicated reviews
            ];
        }

        // Handle errors for either API call
        return [
            'error' => 'Failed to fetch place details',
            'status' => $response1->status() ?: $response2->status(),
        ];
    }
}
