<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogCategoryRequest;
use App\Http\Requests\UpdateBlogCategoryRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = BlogCategory::orderBy('display_order', 'asc')->get();
        return view('admin.blogs.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.blogs.category.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogCategoryRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $new            = new BlogCategory();
            $new->name      = $request->name ?? null;
            $new->slug      = Str::slug($new->name);
            $new->image    = uploadFile($request->file('image'), 'services');
            $new->display_order  = $request->display_order;
            $new->status    = $request->has('status') ? 1 : 0;
            $new->save();
            DB::commit();
            Session::flash('success_msg', 'Successfully Added');
            return  redirect()->route('admin.blogs-category.index');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $category = BlogCategory::where('id', $id)->first() ?? abort(404);
        return view('admin.blogs.category.form', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogCategoryRequest $request,$id)
    {
        //
        $blogCategory = BlogCategory::where('id', $id)->first() ?? abort(404);
        DB::beginTransaction();
        try {
            $blogCategory->name              = $request->name ?? null;
            $blogCategory->slug              = Str::slug($blogCategory->name);
            $blogCategory->display_order     = $request->display_order;
            $blogCategory->status            = $request->has('status') ? 1 : 0;
            if ((!$request->has('exist_image') && $blogCategory->image != null)  || $request->hasFile('image')) {
                deleteFile($blogCategory->image);
                $blogCategory->image = null;
            }
            if ($request->hasFile('image')) {
                $blogCategory->image   = uploadFile($request->file('image'), 'services');
            }
            $blogCategory->save();
            Db::commit();
            Session::flash('success_msg', 'Successfully Updated');
            return  redirect()->route('admin.blogs-category.index');
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
        try {
            $category =  BlogCategory::where('id', $id)->first() ?? abort(404);
            deleteFile($category->image);
            BlogPost::where('category_id',$category->id)->delete();
            $category->delete();
            Db::commit();
            Session::flash('success_msg', 'Successfully Deleted');
            return  redirect()->route('admin.blogs-category.index');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }
}
