<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Models\Banner;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $banners = Banner::orderBy('display_order', 'asc')->get();
        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        //

        return view('admin.banners.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        //
        DB::beginTransaction();
        try {
                $new            = new Banner();
                $new->desktop   = uploadFile($request->file('desktop_image'), 'banners');
                $new->mobile    = uploadFile($request->file('mobile_image'), 'banners');
                $new->display_order  = $request->display_order;
                $new->link      = $request->redirection;
                $new->name      = $request->name;
                $new->type      = 'Banner';
                $new->status    = $request->has('status') ? 1 : 0;
            $new->save();
            DB::commit();
            Session::flash('success_msg', 'Successfully Added');
            return  redirect()->route('admin.banners.index');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $banner = Banner::where('id',$id)->first() ?? abort(404);

        return view('admin.banners.form',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request,$id)
    {
        //

        $banner = Banner::where('id',$id)->first() ?? abort(404);
        DB::beginTransaction();
        try {
    
            if((!$request->has('exist_desktop_image') && $banner->desktop != null)  || $request->hasFile('desktop_image') ){
                deleteFile($banner->desktop);
                $banner->desktop = null;
            }

            if((!$request->has('exist_mobile_image') && $banner->mobile != null)  || $request->hasFile('mobile_image') ){
                deleteFile($banner->mobile);
                $banner->mobile = null;
            }

            if($request->hasFile('desktop_image')){
                $banner->desktop   = uploadFile($request->file('desktop_image'), 'banners');
            }
            if($request->hasFile('mobile_image')){
                $banner->mobile    = uploadFile($request->file('mobile_image'), 'banners');
            }
            $banner->type      = 'Banner';
            $banner->display_order  = $request->display_order;
            $banner->status    = $request->has('status') ? 1 : 0;
            $banner->name      = $request->name;
            $banner->link         = $request->redirection;
            $banner->save();
            Db::commit();
            Session::flash('success_msg', 'Successfully Updated');
            return  redirect()->route('admin.banners.index');
        } catch (Exception $e) {
         
            DB::rollback();
   
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        DB::beginTransaction();
        try{
            $banner =  Banner::where('id', $id)->first() ?? abort(404);
            deleteFile($banner->desktop);
            deleteFile($banner->mobile);
            $banner->delete();
            Db::commit();
            Session::flash('success_msg', 'Successfully Deleted');
            return  redirect()->route('admin.banners.index');
        }
        catch(Exception $e){
            DB::rollback();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
       
    }
}
