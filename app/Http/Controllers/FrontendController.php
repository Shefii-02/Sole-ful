<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Banner;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Doctor;
use App\Models\Enquiry;
use App\Models\Package;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;



class FrontendController extends Controller
{


    public function home(){
        if(Auth::check() && auth('web')->user()->type == 'superadmin'){
            return redirect()->route('admin.dashboard');
        }
        if(Auth::check() && auth('web')->user()->type == 'user'){
            return redirect()->route('account.dashboard');
        }
        else{
            return redirect()->route('login');
        }
    }

    public function index()
    {
        // $banners    = Banner::where('status', 1)->orderby('display_order')->get();
        // $slider_in_desktop = $banners->pluck('desktop');
        // $slider_in_mobile = $banners->pluck('mobile');
        // $services   = Service::where('status', 1)->orderby('display_order')->get();
        // $blogs      = BlogPost::where('status', 1)->orderby('created_at', 'desc')->get();
        // $doctors    = Doctor::where('status', 1)->orderby('display_order')->get();

        // $testimonials = $this->getTestimonials();
        // compact('slider_in_desktop', 'slider_in_mobile', 'services', 'blogs', 'doctors', 'testimonials')
        return view('frontend.index');
    }
    

    public function shop()
    {
        // $services   = Service::where('status', 1)->orderby('display_order')->get();, compact('services')
        return view('frontend.shop');
    }
    public function product($slug)
    {
        // $services   = Service::where('status', 1)->orderby('display_order')->get();
        // $service   = Service::where('status', 1)->where('slug', $slug)->first() ?? abort(404);
        // , compact('service', 'services')
        return view('frontend.product-single');
    }
    public function doctors()
    {
        $doctors   = Doctor::where('status', 1)->orderby('display_order')->get();
        return view('frontend.doctors', compact('doctors'));
    }
    public function doctorSingle($slug)
    {
        $doctor   = Doctor::where('status', 1)->where('slug', $slug)->first() ?? abort(404);
        return view('frontend.doctor-single', compact('doctor'));
    }
    public function packages()
    {
        $packages   = Package::where('status', 1)->orderby('display_order')->get();
        return view('frontend.packages', compact('packages'));
    }
    public function packageSingle($slug)
    {
        $packages   = Package::where('status', 1)->orderby('display_order')->get();

        $package   = Package::where('status', 1)->where('slug', $slug)->first() ?? abort(404);
        return view('frontend.package-single', compact('package', 'packages'));
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

    public function contactSend(Request $request){
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
