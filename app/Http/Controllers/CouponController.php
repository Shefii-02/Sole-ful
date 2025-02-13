<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $coupons = Coupon::get();
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //
        return view('admin.coupons.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        //
        DB::beginTransaction();
        //
        try {
            $coupon = Coupon::create($request->validated());
            $coupon->status = $request->has('status') ? 'active' : 'inactive';
            $coupon->save();
            DB::commit();
            Session::flash('success_msg', 'Successfully Added');
            return  redirect()->route('admin.coupons.index');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $coupon = Coupon::Where('id', $id)->first() ?? abort(404);
        return view('admin.coupons.form', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, $coupon)
    {
        //

        DB::beginTransaction();
        //
        try {
            $coupon = Coupon::findOrFail($coupon) ?? abort(404);
            $coupon->update($request->validated());
            $coupon->status = $request->has('status') ? 'active' : 'inactive';
            $coupon->save();
            DB::commit();
            Session::flash('success_msg', 'Successfully Updated');
            return  redirect()->route('admin.coupons.index');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Coupon::where('id', $id)->delete() ?? abort(404);
            Db::commit();
            Session::flash('success_msg', 'Successfully Deleted');
            return  redirect()->route('admin.coupons.index');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }
}
