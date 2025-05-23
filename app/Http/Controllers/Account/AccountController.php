<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressDetailsRequest;
use App\Models\Myaddress;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    private $userId;
    public function __construct()
    {
        $this->middleware('web');

        $this->middleware(function ($request, $next) {
            $this->userId = auth()->user()->id;
            return $next($request);
        });
    }

    function myaccount()
    {
        return view('frontend.account.myaccount');
    }



    public function ordersShow(Request $request)
    {

        // if ($request->has('filter') && ($request->filter != NULL)) {
        //     $year = $request->filter;

        //     $startDay = Carbon::create($year, 1, 1, 0, 0, 0)->toDateTimeString(); // Start day of the year with time
        //     $endDay = Carbon::create($year, 12, 31, 23, 59, 59)->toDateTimeString(); // End day of the year with time

        // } else {
        //     $year = Carbon::now()->format('Y');
        //     $startDay = Carbon::create($year, 1, 1, 0, 0, 0)->toDateTimeString(); // Start day of the year with time
        //     $endDay = Carbon::now()->year($year)->toDateTimeString(); // Current day of the year
        // }

        $user_id = $this->userId;

        $orders = Order::where('orders.user_id', $user_id)
            // ->whereBetween('orders.created_at', [$startDay, $endDay])
            ->orderBy('id', 'desc')
            ->get();


        return view('frontend.account.orders', compact('orders'));
    }
    public function ordersDetails(Request $request) {}
    public function ordersCancell(Request $request) {}
    public function ordersTrack(Request $request) {}
    public function addressShow(Request $request)
    {
        $myadd = Myaddress::whereUserId($this->userId)->orderBy('base', 'DESC')->get();
        return view('frontend.account.my-address', compact('myadd'));
    }
    public function addressCreate(AddressDetailsRequest $request)
    {


        $myadd              = new Myaddress();
        $myadd->user_id    = auth()->user()->id;
        $myadd->name        = $request->name ?? null;
        $myadd->email       = $request->email ?? null;
        $myadd->mobile      = $request->mobile ?? null;
        $myadd->address     = $request->address ?? null;
        $myadd->locality    = $request->locality ?? null;
        $myadd->landmark    = $request->landmark ?? null;
        $myadd->pincode     = $request->pincode ?? null;
        $myadd->house_name  = $request->house_name ?? null;
        $myadd->house_no    = $request->house_no ?? null;
        $myadd->state       = $request->state ?? null;
        $myadd->country     = 'India';
        $myadd->base        = $request->has('base') ? 1 : 0;


        try {
            $myadd->save();

            if ($myadd->base == 1) {

                Myaddress::where('base', 1)->whereUserId($this->userId)->where('id', '<>', $myadd->id)->update(['base' => 0]);
            }
            session()->flash('success', 'The address has been successfully created');
            return redirect()->back();
        } catch (Exception $e) {
            dd($e->getMessage());
            session()->flash('failed', $e->getMessage());
            return redirect()->back();
        }
    }

    public function addressUpdate(AddressDetailsRequest $request)
    {
        $myadd = Myaddress::whereId($request->id)->whereUserId($this->userId)->first();

        $myadd->name        = $request->name  ?? null;
        $myadd->email       = $request->email  ?? null;
        $myadd->mobile      = $request->mobile  ?? null;
        $myadd->address     = $request->address  ?? null;
        $myadd->locality    = $request->locality  ?? null;
        $myadd->landmark    = $request->landmark  ?? null;
        $myadd->pincode     = $request->pincode  ?? null;
        $myadd->house_name  = $request->house_name  ?? null;
        $myadd->house_no    = $request->house_no  ?? null;
        $myadd->state       = $request->state  ?? null;
        $myadd->base        = $request->has('base') ? 1 : 0;

        try {

            $myadd->save();
            if ($myadd->base == 1) {
                Myaddress::whereUserId($this->userId)->where('id', '<>', $myadd->id)->update(['base' => 0]);
            }

            session()->flash('success', 'The address has been successfully updated.');
            return redirect()->back();
        } catch (Exception $e) {
            dd($e->getMessage());
            session()->flash('failed', $e->getMessage());
            return redirect()->back();
        }
    }

    public function addressDelete($id)
    {
        $my_add = Myaddress::whereUserId($this->userId)->get();
        if ($my_add->count() > 1) {
            $address = Myaddress::whereId($id)->whereUserId($this->userId)->first();

            if ($address->base == 1) {
                $newBase = Myaddress::whereUserId($this->userId)->first();
                $newBase->base = 1;
                $newBase->save();
            } else {
                $any_base = Myaddress::whereUserId($this->userId)->where('base', 1)->first();
                if (!$any_base) {
                    $newBase = Myaddress::whereUserId($this->userId)->first();
                    $newBase->base = 1;
                    $newBase->save();
                }
            }

            $address->delete();
            session()->flash('success', 'The address has been successfully deleted.');
            return redirect()->back();
        } else {
            session()->flash('failed', 'At least one Address must be included');
            return redirect()->back();
        }
    }

    public function profileShow(Request $request)
    {
        $account    = User::whereId($this->userId)->first() ?? abort(404);
        return view('frontend.account.login-security', compact('account'));
    }
    public function profileUpdate(Request $request)
    {

        $acc        = User::whereId($this->userId)->first() ?? abort(404);
        $acc->name      = $request->name;
        $acc->email = $request->email;
        $acc->mobile = $request->mobile;
        try {
   
            $acc->save();  
    
            session()->flash('success', 'The profile has been successfully updated.');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('failed', $e->getMessage());
            return redirect()->back();
        }
    }
    public function resetPassword(Request $request)
    {
        $acc    = User::whereId($this->userId)->first() ?? abort(404);
        $acc->password = Hash::make($request->password);
        try {
            $acc->save();
            session()->flash('success', 'The password has been successfully updated.');
            return redirect()->back();
        } catch (Exception $e) {
            session()->flash('failed', $e->getMessage());
            return redirect()->back();
        }
    }
    public function supportCenter(Request $request)
    {
        return view('frontend.account.contact-suppot');
    }
}
