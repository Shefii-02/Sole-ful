<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function __construct()
    {
       
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $advertisement = Advertisement::orderBy('created_at', 'desc')->get();

        return view('admin.advertisement.index',compact('advertisement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.advertisement.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            $furnishing = Advertisement::query()->create($request->input());
            $result = uploadFile($request->file('icon'), 'general');
            $furnishing->image = $result;
            $furnishing->save();
            Db::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }

        Session::flash('success_msg', 'Successfully Added');
        return redirect()->route('admin.advertisement.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $advertisement = Advertisement::where('id', $id)->first() ?? abort(404);
        return view('admin.advertisement.form', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        //
        
        //
        $advertisement = Advertisement::where('id', $id)->first() ?? abort(404);
        //
        DB::beginTransaction();
        try {
            $advertisement->fill($request->input());

            if ((!$request->has('exist_image') && $advertisement->icon != null)  || $request->hasFile('icon')) {
          
                Storage::disk('public')->delete('images/'.$advertisement->image);
                $advertisement->image = null;
            }

            if ($request->hasFile('icon')) {

                $result = uploadFile($request->file('icon'), 'general');
                $advertisement->image = $result;
            }
            $advertisement->save();

            Db::commit();
        } catch (Exception $e) {

            DB::rollback();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }

        Session::flash('success_msg', 'Successfully Updated');
        return redirect()->route('admin.advertisement.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        DB::beginTransaction();
        try{
            $advertisement =  Advertisement::where('id', $id)->first() ?? abort(404);
            Storage::disk('public')->delete('images/'.$advertisement->image);
            $advertisement->delete();
            Db::commit();
        }
        catch(Exception $e){

            DB::rollback();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
        Session::flash('success_msg', 'Successfully Deleted');
        return  redirect()->route('admin.advertisement.index');
    }
}
