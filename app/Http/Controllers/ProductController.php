<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\BestSellProduct;
use App\Models\Category;
use App\Models\Color;
use App\Models\FeaturedProduct;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use App\Models\StockUpdate;
use App\Models\VariationImage;
use App\Models\VariationKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::get();
        $sizes = Size::get();
        $colors = Color::get();
        return view('admin.products.form', compact('categories', 'sizes', 'colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
        DB::beginTransaction();
        $product                    = new Product();
        /****** Basic Info ****/
        $product->seller_id         = '01';
        $product->product_no        = $request->product_no;
        $product->product_name      = $request->product_name;
        $product->slug              = Str::slug($request->product_name);
        $product->availability      = 'online';
        $product->art_code          = $request->art_code;
        $product->description       = $request->description;
        $product->shoe_type         = $request->shoe_type;
        $product->gender            = 'Women';
        $product->brand             = 'Soleful';
        $product->care_instruction  = $request->care_instruction;
        $product->occasion          = $request->occasion;
        $product->marketed_by       = $request->marketed_by;
        $product->manufactured_by   = $request->manufactured_by;
        $product->country_of_origin = 'India';
        $product->status            = $request->has('status') ? 1 : 0;
        $product->seo_title         = $request->seo_title ?? '';
        $product->seo_description   = $request->seo_description ?? '';
        $product->seo_keywords      = $request->seo_keywords ?? '';
        $product->has_variation     = $request->has('has_variants');
        try {
            $product->save();
            if ($request->has('categories') && count($request->categories) > 0) {
                foreach ($request->categories as $category) {
                    $category_product                   = new ProductCategory();
                    $category_product->category_id      = $category;
                    $category_product->product_id       = $product->id;
                    $category_product->save();
                }
            }

            if ($request->has('has_variants')) {
                if ($request->has('variant_options') && count($request->variant_options)) {
                    foreach ($request->variant_options as $key => $val) {
                        foreach ($request->variant_option_values[$key] as $index => $value) {
                            if ($value != '') {
                                $option                 = new Option();
                                $option->product_id     = $product->id;
                                $option->name           = $request->variant_options[$key]; // $key
                                $option->value          = $value;
                                $option->save();
                            }
                        }
                    }
                }

                if ($request->has('variants') && count($request->variants) > 0) {
                    foreach ($request->variants as $key => $value) {
                        $product_variation                  = new ProductVariant();
                        $product_variation->product_id        = $product->id;
                        $product_variation->variation       = $request->variants[$key];
                        $product_variation->sku                = $request->variants_sku[$key];
                        $product_variation->variation_name    = $request->variants_name[$key];
                        $product_variation->weight            = $request->variants_weight[$key];
                        $product_variation->price            = $request->variants_price[$key];
                        $product_variation->in_stock        = $request->variants_stock[$key];
                        $product_variation->save();

                        $variants = explode(',', $request->variants[$key]);

                        foreach ($variants as $variant) {
                            list($type, $value) = explode(':', $variant);

                            $vkey                   = new VariationKey();
                            $vkey->variation_id     = $product_variation->id;
                            $vkey->product_id       = $product->id;
                            $vkey->type             = trim($type);
                            $vkey->value            = trim($value);
                            $vkey->save();
                        }
                    }
                }
            } else {

                $product_variation                      = new ProductVariant();
                $product_variation->product_id          = $product->id;
                $product_variation->variation           = $product->product_name;
                $product_variation->variation_name      = $product->product_name;
                $product_variation->sku                 = $request->product_sku_single;
                $product_variation->variation_name      = $request->product_name_single ?? '';
                $product_variation->weight              = $request->product_weight_single;
                $product_variation->price               = $request->product_price_single;
                $product_variation->in_stock            = $request->product_stock_single;
                $product_variation->save();
            }

            if ($request->has('product_images') && count($request->product_images) > 0) {

                foreach ($request->product_images as $key => $image) {

                    if ($uploaded = $this->__uploadMorePicture($image, 'images/products/')) {

                        $product_img                = new ProductImage;
                        $product_img->image       = $uploaded;
                        $product_img->type          = $request->product_images_type[$key] ?? 'Extra Image';
                        $product_img->product_id    = $product->id;
                        $product_img->save();

                        if (isset($request->product_images_variant[$key]) && count($request->product_images_variant[$key]) > 0) {
                            foreach ($request->product_images_variant[$key] as $ikey => $sku) {
                                $variant                = ProductVariant::whereSku($sku)->whereProductId($product->id)->first();
                                if ($variant) {
                                    $vari_img               = new VariationImage;
                                    $vari_img->variation_id = $variant->id;
                                    $vari_img->picture_id   = $product_img->id;
                                    $vari_img->product_id   = $product->id;
                                    $vari_img->save();
                                }
                            }
                        }
                    }
                }
            }


            BestSellProduct::where('product_id', $product->id)->delete();
            if ($request->has('bestSell')) {
                $best = new BestSellProduct();
                $best->product_id = $product->id;
                $best->save();
            }

            FeaturedProduct::where('product_id', $product->id)->delete();
            if ($request->has('featured')) {
                $feature = new FeaturedProduct();
                $feature->product_id = $product->id;
                $feature->save();
            }



            DB::commit();
            Session::flash('success_msg', "Product saved successfully");
            return response()->json([
                'success' => true,
                'message' => 'Product saved successfully!',
            ]);
        } catch (\Exception $e) {
            // Handle unexpected exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500); // Internal Server Error
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product)
    {
        //
        $product    = Product::whereId($product)->first() ?? abort(404);
        $categories = Category::get();
        $sizes = Size::get();
        $colors = Color::get();

        return view('admin.products.form', compact('categories', 'sizes', 'colors', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $product)
    {
        //
        $product    = Product::whereId($product)->first() ?? abort(404);

        DB::beginTransaction();
        /****** Basic Info ****/
        // $product->seller_id         = '01';
        $product->product_no        = $request->product_no;
        $product->product_name      = $request->product_name;
        $product->slug              = Str::slug($request->product_name);
        // $product->availability      = 'online';
        $product->art_code          = $request->art_code;
        $product->description       = $request->description;
        $product->shoe_type         = $request->shoe_type;
        // $product->gender            = 'Women';
        // $product->brand             = 'Soleful';
        $product->care_instruction  = $request->care_instruction;
        $product->occasion          = $request->occasion;
        $product->marketed_by       = $request->marketed_by;
        $product->manufactured_by   = $request->manufactured_by;
        // $product->country_of_origin = 'India';
        $product->status            = $request->has('status') ? 1 : 0;
        $product->seo_title         = $request->seo_title ?? '';
        $product->seo_description   = $request->seo_description ?? '';
        $product->seo_keywords      = $request->seo_keywords ?? '';
        $product->has_variation     = $request->has('has_variants');
        try {
            $product->save();

            // Delete all relationship data for recreation



            Option::where('product_id', $product->id)->delete();
            VariationImage::where('product_id', $product->id)->delete();
            // ProductImage::where('product_id', $product->id)->delete();
            ProductVariant::where('product_id', $product->id)->delete();
            VariationKey::where('product_id', $product->id)->delete();
            ProductCategory::where('product_id', $product->id)->delete();

            if ($request->has('categories') && count($request->categories) > 0) {
                foreach ($request->categories as $category) {
                    $category_product                   = new ProductCategory();
                    $category_product->category_id      = $category;
                    $category_product->product_id       = $product->id;
                    $category_product->save();
                }
            }

            if ($request->has('has_variants')) {
                if ($request->has('variant_options') && count($request->variant_options)) {
                    foreach ($request->variant_options as $key => $val) {
                        foreach ($request->variant_option_values[$key] as $index => $value) {
                            if ($value != '') {
                                $option                 = new Option();
                                $option->product_id     = $product->id;
                                $option->name           = $request->variant_options[$key]; // $key
                                $option->value          = $value;
                                $option->save();
                            }
                        }
                    }
                }

                if ($request->has('variants') && count($request->variants) > 0) {
                    foreach ($request->variants as $key => $value) {
                        $product_variation                  = new ProductVariant();
                        $product_variation->product_id      = $product->id;
                        $product_variation->variation       = $request->variants[$key];
                        $product_variation->sku             = $request->variants_sku[$key];
                        $product_variation->variation_name  = $request->variants_name[$key];
                        $product_variation->weight          = $request->variants_weight[$key];
                        $product_variation->price           = $request->variants_price[$key];
                        $product_variation->in_stock        = $request->variants_stock[$key];
                        $product_variation->save();

                        $variants = explode(',', $request->variants[$key]);

                        foreach ($variants as $variant) {
                            list($type, $value) = explode(':', $variant);

                            $vkey                   = new VariationKey();
                            $vkey->variation_id     = $product_variation->id;
                            $vkey->product_id       = $product->id;
                            $vkey->type             = trim($type);
                            $vkey->value            = trim($value);
                            $vkey->save();
                        }
                    }
                }
            } else {
                $product_variation                  = new ProductVariant();
                $product_variation->product_id      = $product->id;
                $product_variation->variation       = $product->product_name;
                $product_variation->variation_name  = $product->product_name;
                $product_variation->sku             = $request->product_sku_single;
                $product_variation->weight          = $request->product_weight_single;
                $product_variation->price           = $request->product_price_single;
                $product_variation->in_stock        = $request->product_stock_single;
                $product_variation->save();
            }


            if ($request->has('product_images') && count($request->product_images) > 0) {  // Handle Image uploads

                $saved = [];

                foreach ($request->product_images as $key => $image) {

                    if (!(substr($key, 0, 4) == 'UID-' && $product_img = ProductImage::where('id', str_replace('UID-', '', $key))->where('product_id', $product->id)->first())) // if does not exists...
                        $product_img                = new ProductImage;

                    if (($uploaded = $this->__uploadMorePicture($image, 'images/products/')) || $product_img->id != NULL) {  // If a picture is uploaded



                        if ($product_img->image != '' && $uploaded != '')
                            @unlink('images/products/' . $product_img->image); // If there is already an existing picture, delete it first

                        if ($uploaded != '')
                            $product_img->image       = $uploaded;

                        $product_img->type          = $request->product_images_type[$key] ?? 'Extra Image'; // Update image type even if image not uploaded
                        $product_img->product_id    = $product->id;
                        $product_img->save();

                        $saved[] = $product_img->id;

                        if (isset($request->product_images_variant[$key]) && count($request->product_images_variant[$key]) > 0) {
                            foreach ($request->product_images_variant[$key] as $ikey => $sku) {
                                $variant                = ProductVariant::whereSku($sku)->whereProductId($product->id)->first();

                                if ($variant) {
                                    $vari_img               = new VariationImage;
                                    $vari_img->variation_id = $variant->id;
                                    $vari_img->picture_id   = $product_img->id;
                                    $vari_img->product_id   = $product->id;
                                    $vari_img->save();
                                }
                            }
                        }
                    }
                }

                $removed_images = ProductImage::where('product_id', $product->id)->whereNotIn('id', $saved)->get(); // Catch all existing images that is removed in update

                foreach ($removed_images as $image) {
                    @unlink('images/products/' . $product_img->image); // Delete image file
                    VariationImage::where('product_id', $product->id)->where('picture_id', $image->id)->delete();
                    $image->delete();
                }
            }

            //deleted images deleting  from this disk and database
            if ($request->has('deleted_images') && count($request->deleted_images) > 0) {
                foreach ($request->deleted_images as $delProductImage) {
                    $product_img = ProductImage::where('id', str_replace('UID-', '', $delProductImage))->where('product_id', $product->id)->first(); // if exists image...
                    if ($product_img) {
                        VariationImage::where('product_id', $product->id)->where('picture_id', $product_img->id)->delete();
                        @unlink('images/products/' . $product_img->image); // Delete image file
                        ProductImage::where('id', $product_img->id)->delete();
                    }
                }
            }
            // 

            BestSellProduct::where('product_id', $product->id)->delete();
            if ($request->has('bestSell')) {
                $best = new BestSellProduct();
                $best->product_id = $product->id;
                $best->save();
            }

            FeaturedProduct::where('product_id', $product->id)->delete();
            if ($request->has('featured')) {
                $feature = new FeaturedProduct();
                $feature->product_id = $product->id;
                $feature->save();
            }

            DB::commit();
            Session::flash('success_msg', "Product updated successfully");
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully!',
            ]);
        } catch (\Exception $e) {
            // Handle unexpected exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500); // Internal Server Error
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product)
    {
        //
        try {
            $product = Product::where('id', $product)->first() or abort(404);
            Session::flash('success_msg', "Successfully deleted the product");
            return redirect()->route('admin.products.index');
            exit;
        } catch (\Exception $e) {
            Session::flash('success_msg', "Unable to delete the product");
            return redirect()->back();
            exit;
        }
    }



    public function stock()
    {
        $products = Product::get();

        return view('admin.products.stocks', compact('products'));
    }



    public function stockUpdate(Request $request, $productId)
    {
        $product = Product::find($productId);

        if ($product) {
            foreach ($request->variants as $variantId => $newStock) {
                $variant = $product->product_variation()->find($variantId);

                if ($variant) {
                    $lastStock = $variant->in_stock;
                    $updatedStock = $newStock;

                    if ($newStock != $lastStock) {
                        StockUpdate::createStockUpdate($productId, $variant->sku, $lastStock, $updatedStock);
                    }

                    // Update the variant stock
                    $variant->in_stock = $newStock;
                    $variant->save();
                }
            }
        }

        Session::flash('success_msg', "Stock updated successfully.");
        return redirect()->back();
    }


    public function bestSelling(Request $request)
    {
        $products = Product::where('status', 1)->get();
        $bestSell = BestSellProduct::query()->pluck('product_id')->toArray();
        return view('admin.products.best-selling', compact('products', 'bestSell'));
    }


    public function bestSellingUpdate(Request $request)
    {

        BestSellProduct::query()->delete();

        foreach ($request->bestSell ?? [] as $item) {
            $best = new BestSellProduct();
            $best->product_id = $item;
            $best->save();
        }

        Session::flash('success_msg', "Successfully Updated");
        return redirect()->back();
    }

    public function featuredProducts(Request $request)
    {
        $products = Product::where('status', 1)->get();
        $featuredProduct = FeaturedProduct::query()->pluck('product_id')->toArray();
        return view('admin.products.featured-products', compact('products', 'featuredProduct'));
    }


    public function featuredProductsUpdate(Request $request)
    {

        FeaturedProduct::query()->delete();

        foreach ($request->featuredProducts ?? [] as $item) {
            $best = new FeaturedProduct();
            $best->product_id = $item;
            $best->save();
        }

        Session::flash('success_msg', "Successfully Updated");
        return redirect()->back();
    }







    public function artCodeCheck(Request $request)
    {
        // Validate the input
        $request->validate([
            'art_code' => 'required|string|max:255',
        ]);

        // Exclude the current product (if editing)
        $query = Product::where('art_code', $request->art_code);
        if ($request->has('product_id') && !is_null($request->product_id)) {
            $query->where('id', '!=', $request->product_id);
        }

        $product = $query->first();

        if ($product) {
            return response()->json([
                'status' => 208,
                'message' => 'Product ART code already exists in our record.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product ART code is available.',
        ]);
    }

    public function productNoCheck(Request $request)
    {
        // Validate the input
        $request->validate([
            'product_no' => 'required|string|max:255',
        ]);

        // Exclude the current product (if editing)
        $query = Product::where('product_no', $request->product_no);
        if ($request->has('product_id') && !is_null($request->product_id)) {
            $query->where('id', '!=', $request->product_id);
        }

        $product = $query->first();

        if ($product) {
            return response()->json([
                'status' => 208,
                'message' => 'Product number already exists in our record.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product number is available.',
        ]);
    }

    public function skuCheck(Request $request)
    {
        // Validate the input
        $request->validate([
            'sku' => 'required|string|max:255',
        ]);

        // Exclude the current product variant (if editing)
        $query = ProductVariant::where('sku', $request->sku);
        if ($request->has('product_id') && !is_null($request->product_id)) {
            $query->where('product_id', '!=',  $request->product_id);
        }

        $skuExists = $query->exists();

        if ($skuExists) {
            return response()->json([
                'status' => 208,
                'message' => $request->sku . ' SKU already exists in our record.',
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'SKU is available.',
        ]);
    }


    public function generateAutosku(Request $request)
    {
        $seller_code = '01';
        $product_no = $request->product_no;
        $art_code   = $request->art_code;
        $selValues  = $request->selValues;
        $variants = explode(',', $selValues);
        foreach ($variants ?? [] as $variant) {
            list($type, $value) = explode(':', $variant);
            if ($type == 'size') {
                $size = $value;
            } else if ($type == 'color') {
                $color = $value;
            }
        }



        $size       = trim($size ?? '');
        $color      = trim($color ?? '');
        $sizeCode   = Size::where('size_value', $size)->pluck('size_code')->first();
        $colorCode  = Color::where('color_name', $color)->pluck('color_code')->first();


        return $seller_code . $product_no . $art_code . $colorCode . $sizeCode;
    }



    public function __uploadMorePicture($name, $path = '')
    {
        if (!empty($name) && strlen($name) > 6) {
            $picture = $name;

            if (preg_match('/data:image/', $picture)) {
                list($type, $picture) = explode(';', $picture);
                list($i, $picture) = explode(',', $picture);
                $picture = base64_decode($picture);
                $image_name = Str::random(30) . '.png';
                Storage::disk('public')->put($path . $image_name, $picture);

                return  $image_name;
            }

            return false;
        }
        return false;
    }
}
