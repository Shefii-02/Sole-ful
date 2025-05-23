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
use App\Models\Size;
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
            return redirect()->route('account.home');
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
        $productOffer           = Advertisement::where('text', 'product')->inRandomOrder()->limit(1)->first();
        $offerAdvertisements = \App\Models\Advertisement::where('text','offer')->select('image','redirection')->get();
     
        return view('frontend.index', compact('slider_in_desktop', 'slider_in_mobile', 'bestSellProduct', 'featuredProduct', 'blogs', 'productOffer','offerAdvertisements'));
    }

    public function getWishlist(Request $request)
    {

        $wishlistIds = $request->input('wishlist');
        if(is_array($wishlistIds)){
            $products = Product::whereIn('id', $wishlistIds)->get();
        }
        else{
            $products = collect();
        }

        

        return view('frontend.partials.wishlist', compact('products'));
    }


    public function QuickView(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::where('id', $product_id)->first() ??  abort(404);

        $all_sizes   =  Size::query()->pluck('size_value');
        $sizes = $product->variationKeys->where('type', 'size')->unique('value');
        $colors = $product->variationKeys->where('type', 'color')->unique('value');
        return view('frontend.partials.product-single', compact('product','all_sizes','sizes','colors'))->render();
    }

    public function shop(Request $request)
    {
        $productOffer = Advertisement::where('text', 'product')->inRandomOrder()->limit(1)->first();
    
        // Base query from ProductVariation instead of Product
        $query = ProductVariant::whereHas('product', function ($q) {
            $q->where('status', 1);
        });
    
        // Filter by price range
        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }
    
        // Filter by color
        if ($request->has('colors')) {
            $query->whereHas('variationkey', function ($q) use ($request) {
                $q->where('type', 'color')->whereIn('value', $request->colors);
            });
        }
    
        // Filter by size
        if ($request->has('sizes')) {
            $query->whereHas('variationkey', function ($q) use ($request) {
                $q->where('type', 'size')->whereIn('value', $request->sizes);
            });
        }
    
        // Filter by category
        if ($request->has('categories')) {
            $query->whereHas('product.categories', function ($q) use ($request) {
                $q->whereIn('name', $request->categories);
            });
        }
    
        // Filter by shoe type
        if ($request->has('shoe_type')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->whereIn('shoe_type', $request->shoe_type);
            });
        }
    
        // Get products with variations
        $productVariations = $query->with(['product', 'variationkey' => function ($q) {
            $q->where('type', 'color');
        }])->get();
        // ->inRandomOrder()

        // dd($productVariations);
        $uniqueVariations = $productVariations->unique(function ($variant) {
            return $variant->product_id . '-' . optional($variant->variationkey->first())->value;
        });
      
        // dd($uniqueVariations);

        // Get unique products from variations
        // $products = $productVariations->map->product->unique();
        $products = $uniqueVariations;
    // dd($products);
        // Get available colors with unique product counts
        $available_colors = VariationKey::where('type', 'color')
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
    
        // Get categories with product counts
        $categories = Category::withCount([
            'products' => function ($q) {
                $q->where('status', 1);
            }
        ])->orderBy('created_at', 'desc')->get();
    
        if ($request->ajax()) {
            // Render product list view and return as JSON for AJAX
            $html = view('frontend.partials.product_list', compact('products'))->render();
            return response()->json(['html' => $html]);
        }
    
        return view('frontend.shop', compact('products', 'available_colors', 'available_sizes', 'categories', 'productOffer'));
    }
    

    public function product($uid, $slug)
    {
        $product = Product::where('unique_value', $uid)->where('slug', $slug)->first() ?? abort(404);
        $similarProducts = Product::limit(10)->inRandomOrder()->get();
        $all_sizes   =  Size::query()->pluck('size_value');
        $sizes = $product->variationKeys->where('type', 'size')->unique('value');
        $colors = $product->variationKeys->where('type', 'color')->unique('value');

        return view('frontend.product-single', compact('product', 'similarProducts', 'sizes', 'colors', 'all_sizes'));
    }


    public function getVariationDetails(Request $request)
    {
        $product = $request->product_id;
        $size    = $request->size;
        $variationIds = VariationKey::where('type', 'size')->where('product_id', $product)->where('value', $size)->pluck('variation_id');
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
      
    }
    public function about()
    {
        return view('frontend.about');
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

    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (!$query) {
            return response()->json([]);
        }

        $products = ProductVariant::query()
            ->with(['product', 'variationkey']) // Preload relationships
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->whereHas('product', function ($productQuery) use ($query) {
                    $productQuery->Where('product_name', 'like', "%{$query}%")
                                 ->Where('shoe_type', 'like', "%{$query}%");
                                 
                })
                    ->orWhere('variation_name', 'like', "%{$query}%") // Search in variation name
                    ->orWhere('variation', 'like', "%{$query}%"); // Search in variation
            })
            ->take(50) // Fetch more records initially for deduplication
            ->get();

        // Ensure uniqueness by product_id
        $products = $products->unique('product_id')->values(); // Use Laravel Collection's `unique`
        $results = view('frontend.partials.search-results', compact('products'))->render();

        return response()->json($results);
    }
}
