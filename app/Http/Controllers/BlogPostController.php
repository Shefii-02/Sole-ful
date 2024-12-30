<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogPostRequest;
use App\Http\Requests\UpdateBlogPostRequest;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $posts = BlogPost::orderBy('created_at', 'desc')->get();
        return view('admin.blogs.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = BlogCategory::where('status', 1)->get();
        return view('admin.blogs.posts.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogPostRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $new            = new BlogPost();
            $new->title      = $request->name ?? null;
            $new->slug      = Str::slug($new->title);
            $new->category_id  = $request->category;
            $new->description  = $request->description;
            $new->image    = uploadFile($request->file('image'), 'services');
   
            $new->status    = $request->has('status') ? 1 : 0;
            $new->save();
            DB::commit();
            Session::flash('success_msg', 'Successfully Added');
            return  redirect()->route('admin.blogs.index');
        } catch (Exception $e) {
            DB::rollBack();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $post = BlogPost::where('id', $id)->first() ?? abort(404);
        $categories = BlogCategory::where('status', 1)->get();
        return view('admin.blogs.posts.form', compact('categories', 'post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogPostRequest $request, $id)
    {
        //
        $post = BlogPost::where('id', $id)->first() ?? abort(404);
        DB::beginTransaction();
        try {
            $post->title              = $request->name ?? null;
            $post->slug              = Str::slug($post->title);
            $post->category_id          = $request->category;
            $post->description          = $request->description;
          
            $post->status            = $request->has('status') ? 1 : 0;
            if ((!$request->has('exist_image') && $post->image != null)  || $request->hasFile('image')) {
                deleteFile($post->image);
                $post->image = null;
            }
            if ($request->hasFile('image')) {
                $post->image   = uploadFile($request->file('image'), 'services');
            }
            $post->save();
            Db::commit();
            Session::flash('success_msg', 'Successfully Updated');
            return  redirect()->route('admin.blogs.index');
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
            $post =  BlogPost::where('id', $id)->first() ?? abort(404);
            deleteFile($post->image);
            $post->delete();
            Db::commit();
            Session::flash('success_msg', 'Successfully Deleted');
            return  redirect()->route('admin.blogs.index');
        } catch (Exception $e) {
            DB::rollback();
            Session::flash('failed_msg', 'Failed..!' . $e->getMessage());
            return redirect()->back();
        }
    }
}
