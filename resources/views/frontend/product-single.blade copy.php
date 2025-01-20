@extends('layouts.app')
@push('header')
    <style>
        .size-tab label {
            color: #444;
            cursor: pointer;
            display: inline-block;
            font-family: "futuramedium";
            font-size: 15px;
            line-height: 1;
            margin-bottom: 10px;
            max-width: 100%;
            position: relative;
            text-transform: uppercase;
        }

        .size-button {
            background: #fff;
            border: 1px solid #a1a1a1;
            border-radius: 50%;
            height: 50px;
            line-height: 50px !important;
            margin-right: 10px !important;
            text-align: center;
            width: 50px;
        }

        .size-tab label.disabled {
            border: 1px solid #a1a1a1;
            opacity: .5;
        }

        .size-tab label.disabled:after {
            background-color: #d5d6d9;
            content: "";
            height: 1px;
            left: 0;
            position: absolute;
            top: 50%;
            transform: rotate(-45deg);
            width: 100%;
        }

        .color-tab label.active img {
            border: 2px solid #e30024;
        }

        .color-tab label img {
            border: 1px solid #a1a1a1;
            border-radius: 100%;
        }
    </style>
@endpush
@section('content')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area bg-img" data-bg="assets/img/banner/breadcrumb-banner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <nav aria-label="breadcrumb">
                            <h1 class="breadcrumb-title">shop</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $product->product_name }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- product details wrapper start -->
    <div class="product-details-wrapper section-padding">
        <div class="container custom-container">
            <div class="row">
                <div class="col-12">
                    <!-- product details inner end -->
                    <div class="product-details-inner">
                        <div class="row">
                            <div class="col-lg-5">

                                @php
                                    $images = product_images($product->id);
                                @endphp
                                <div class="product-large-slider mb-4">
                                    @foreach ($images as $key => $variaion_slider)
                                        <!--  img-showcase --> @php $x = 0; @endphp
                                        @foreach ($variaion_slider as $vari_images)
                                            <div class="pro-large-img img-zoom" data-category="{{ $key }}">
                                                <img src="{{ asset('images/products/' . $vari_images) }}"
                                                    onerror="this.onerror=null;this.src='/assets/images/dummy-product.jpg';"
                                                    alt="{{ $product->product_name }}">
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>

                                <div class="pro-nav slick-row-5">
                                    @foreach ($images as $key => $variaion_slider)
                                        <!--  img-showcase --> @php $x = 0; @endphp
                                        @foreach ($variaion_slider as $vari_images)
                                            <div class="pro-nav-thumb"><img
                                                    src="{{ asset('images/products/' . $vari_images) }}"
                                                    onerror="this.onerror=null;this.src='/assets/images/dummy-product.jpg';"
                                                    alt="{{ $product->product_name }}" />
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>

                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <h3 class="pro-det-title product-title">{{ $product->product_name }}</h3>
                                    {{-- <div class="pro-review">
                                        <span><a href="#">1 Review(s)</a></span>
                                    </div> --}}
                                    <div class="price-box">
                                        <span class="regular-price">{{ min_price($product->id) }}</span>
                                    </div>
                                    <div class="price-box">
                                        <span class="text-success small">Inclusive of all taxes</span>
                                    </div>
                                    <p>{{ $product->care_instruction }}</p>
                                    <div class="product__variations">
                                        @if(count($product->option)>0 && ($product->has_variation == 1))
                                            @php
                                                $options = $product->option->pluck('type')->unique()->toArray();
                                                if(in_array('size', $options))
                                                    $first_option = 'size';
                                                elseif(in_array('type', $options))
                                                    $first_option = 'type';
                                                else
                                                    $first_option = 'color';
                                            @endphp
                                           <div class="product__variations @if($product->has_customization) d-none @endif">
                                                <div class="row position-relative d-flex align-items-center w-100" >
                                                    <div class="col-3">
                                                            <h5 class="mb-0 mt-3">Select {{ ($first_option)}}</h5>
                                                    </div>
                                                    <div class="col-9">
                                                        <div class="row" >
                                                            @php
                                                                $key1 =0;
                                                               // dd($product->option->groupBy('variation_id'));
                                                            @endphp
                                                            
                                                            {{-- @foreach($product->option->where('type',$first_option) as $size_items)  --}}
                                                            @php
                                                                $uniq_types = $product->option()->where('type',$first_option)->get();
                                                            @endphp
                                                            
                                                            @foreach($uniq_types->unique('value') as $size_items)
                                                    <!--/////////// Show First Option ////////////////////-->  
                                                                <div class="col-6 col-lg-4 text-center option_vals cursor-pointer">
                                                                    @php
                                                                        if($first_option == 'size')
                                                                            if(in_array('type', $options))
                                                                        	    $second_option = 'type';
                                                                        	else
                                                                        	    $second_option = 'color';
                                                                        elseif($first_option == 'type')
                                                                            if(in_array('color', $options))
                                                                        	    $second_option = 'color';
                                                                        else
                                                                                $second_option = '';
                                                                    @endphp
                                                                   
                                                                      @if ($product->option->where('type', $second_option)->count() == 0)
                                                                            @php
                                                                                $variation_data = App\Models\VariationKey::leftJoin('product_variations', 'variation_keys.variation_id', 'product_variations.id')
                                                                                    ->where(function ($query) {
                                                                                        return $query->where('product_variations.sku', '<>', '')->orWhere('product_variations.sku', '<>', null);
                                                                                    })
                                                                                    ->where('value', $size_items->value)
                                                                                    ->where('product_variations.product_id', $product->id)
                                                                                    ->first();
                                                                            @endphp
                                                                        @endif
                                                             
                                                                    <div class="round-checkbox  mb-2"> 
                                                                        <input type="radio" name="single_selection" @if($product->option->where('type',$second_option)->count() == 0 && ($variation_data))  data-vname="{{$variation_data->variation}}" data-price="{{$variation_data->price}}" data-specialprice="{{$variation_data->special_price}}" data-id="{{$variation_data->variation_id}}" @endif data-option="{{$size_items->id}}" @if($key1 == 0) checked @endif class="vari_checkbox" id="checkbox_option_rounded_{{$size_items->id}}">
                                                                        <label for="checkbox_option_rounded_{{$size_items->id}}" ></label>
                                                                    </div>
                                                                    <div data-option="{{$size_items->id}}" id="show_variations_{{$size_items->id}}" class="show_variations @if($key1 == 0) active @endif">
                                                                        <div class="card position-relative bg-white vari_type border-0 justify-content-center" >
                                                                            <div class="row">
                                                                                <div class="col-md-12 position-relative">
                                                                                    <img src="{{imageExisted('/assets/images/icon-img/'.$size_items->value.'.png')}}">
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <p class="card-price fw-bold">{{$size_items->value}} </p>
                                                                                    @if($product->option->where('type',$second_option)->count() == 0 && ($variation_data))
                                                                                        <small class="d-none">{{getPrice($variation_data->price)}} </small>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                    <!--/////////// Show Only  Two Option Time ////////////////////-->  
                                                                        @if($product->option->where('type',$second_option)->count() > 0)
                                                                            <div id="child_div_{{$size_items->id}}" class=" rounded mt-3 child_div pt-4" @if($key1 == 0) style="display:block" @endif>
                                                                                
                                                                                <div class="row d-flex align-items-center w-100 m-0">
                                                                                     <div class="col-3">
                                                                                         <div class="row">
                                                                                            <h5 class=" text-start">Select {{titleText($second_option)}}</h5>
                                                                                             
                                                                                         </div>
                                                                                    </div>
                                                                                    <div class="col-9 p-0">
                                                                                        <div class="row flex-row-reverse11 justify-content-end11 w-100 m-0" >
                                                                                            @php
                                                                                                    $ii = 0;
                                                                                                    $third_option ='';
                                                                                                    if($second_option == 'type'){
                                                                                                        if(in_array('color', $options))
                                                                                                    	    $third_option = 'color';
                                                                                                        else
                                                                                                            $third_option = '';
                                                                                                    }
                                                                                                    $key2 = 0
                                                                                               @endphp
                                                                                        @php
                                                                                            // $uniq_values = $product->option()->where('type',$second_option)->get();
                                                                                            $firstOption_Vids = $product->option()->where('type',$first_option)->where('value',$size_items->value)->pluck('variation_id')->toArray();
                                                                                            $uniq_values = $product->option()->where('type',$second_option)->whereIn('variation_id',$firstOption_Vids)->get();
                                                                                           
                                                                                        @endphp
                                                                                            @foreach($uniq_values as $type_items)
                                                                                                @if($product->option->where('type',$second_option)->count() == 0)
                                                                                                    @php
                                                                                                        $variation_data = App\Models\VariationKey::leftJoin('product_variations','variation_keys.variation_id','product_variations.id')
                                                                                                                                            ->where(function($query){
                                                                                                                                                 return $query
                                                                                                                                                        ->where('product_variations.sku', '<>','')
                                                                                                                                                        ->orWhere('product_variations.sku', '<>',NULL);
                                                                                                                     						})
                                                                                                                     						->where('value',$size_items->value)
                                                                                                                                            ->where('product_variations.product_id',$product->id)
                                                                                                                                            ->first(); 
                                                                                                    @endphp
                                                                                                @else
                                                                                
                                                                                                   @php
                                                                                                       $vari_ids = $product->variationList->where('value',$size_items->value)->pluck('variation_id');
                                                                                                       $variation_data = App\Models\VariationKey::leftJoin('product_variations','variation_keys.variation_id','product_variations.id')
                                                                                                                                                ->where(function($query){
                                                                                                                                                     return $query
                                                                                                                                                            ->where('product_variations.sku', '<>','')
                                                                                                                                                            ->orWhere('product_variations.sku', '<>',NULL);
                                                                                                                         						})
                                                                                                                                                ->where('product_variations.product_id',$product->id)
                                                                                                                                                ->where('value',$type_items->value)
                                                                                                                                                ->whereIn('variation_id',$vari_ids)
                                                                                                                                                ->first(); 
                                                                                                   
                                                                                                    @endphp
                                                                                                @endif
                                                                                                @if($variation_data)
                                                                                                        <div class="col-6 col-md-6 col-lg-4 text-center child_div_type {{$variation_data->value}}">
                                                                                                            <div class="card position-relative bg-white second_section border-0" data-childId="child_div_{{$type_items->id}}">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-md-12 position-relative">
                                                                                                                        <img src="{{imageExisted('/assets/images/icon-img/'.$variation_data->value.'.png')}}">
                                                                                                                    </div>
                                                                                                                    <div class="col-md-12">
                                                                                                                        <p class="card-price fw-bold">{{$variation_data->value}} </p>
                                                                                                                        @if($third_option == '')
                                                                                                                        <small class="d-none">{{getPrice($variation_data->price)}} </small>
                                                                                                                        @endif
                                                                                                                    </div>
                                                                                                                    <div class="round-radio ">
                                                                                                                        <input type="radio" data-childId="child_div_{{$type_items->id}}"  class="option__type" @if($third_option == '') data-vname="{{$variation_data->variation}}"  data-price="{{$variation_data->price}}" data-specialprice="{{$variation_data->special_price}}" data-id="{{$variation_data->variation_id}}" @endif  name="vari_type_{{$key1}}" @if($key1 == 0 && $ii == 0) checked @endif  id="radio_rounded_{{$key1}}_{{$key2}}">
                                                                                                                        <label for="radio_rounded_{{$key1}}_{{$key2}}" ></label>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        @php 
                                                                                                            $ii = $ii + 1;
                                                                                                        @endphp
                                                                                                @endif
                                                                                                @php
                                                                                                    $key2 = $key2 +1;
                                                                                                @endphp
                                                                                            @endforeach  
                                                                                        </div>
                                                                                    </div>
                                                                                     
                                                                               </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                @php
                                                                    $key1= $key1 +1;
                                                                @endphp
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="quantity-cart-box d-flex align-items-center mb-4">
                                        <div class="quantity">
                                            <div class="pro-qty"><input type="text" value="1"></div>
                                        </div>
                                        <a href="cart.html" class="btn btn-dark">Add To Cart</a>
                                    </div>
                                    <div class="pro-size1 mb-4 ">
                                        <h5 class="cat-title mb-3 fw-bolder">Size :</h5>

                                        <div class="size-tab">
                                            @foreach (['37', '38', '39', '40', '41'] as $size)
                                                <label
                                                    class="size-button {{ $sizes->contains('value', $size) ? '' : 'disabled' }}"
                                                    data-size-id="{{ $size }}">
                                                    <input type="radio" class="hidden" name="size"
                                                        value="{{ $size }}">
                                                    {{ $size }}
                                                </label>
                                            @endforeach
                                        </div>

                                        <div class="size-chart">
                                            <a href="#" class="text-theme" data-bs-toggle="modal"
                                                data-bs-target="#sizeChart">Size Guide</a>
                                        </div>
                                    </div>

                                    <div class="color-option1 mb-4">
                                        <h5 class="cat-title mb-3 fw-bolder">Colors :</h5>
                                        <div class="color-tab">
                                            @foreach ($colors as $color)
                                                <label class="color-button" data-color-id="{{ $color->id }}">
                                                    <img src="{{ asset('images/products/' . $color->image_url) }}"
                                                        alt="{{ $color->value }}">
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="availability mb-4">
                                        <h5 class="cat-title">Availability:</h5>
                                        <span>In Stock</span>
                                    </div>
                                    <div class="share-icon">
                                        <h5 class="cat-title">Share:</h5>
                                        <div class="sharethis-inline-share-buttons"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- product details reviews start -->
                    <div class="product-details-reviews section-padding">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-review-info">
                                    <ul class="nav review-tab" role="tablist">
                                        <li>
                                            <button class="active" id="tab_one_btn" type="button" data-bs-toggle="tab"
                                                data-bs-target="#tab_one" role="tab" aria-controls="tab_one"
                                                aria-selected="true">description</button>
                                        </li>
                                        <li>
                                            <button id="tab_two_btn" type="button" data-bs-toggle="tab"
                                                data-bs-target="#tab_two" role="tab" aria-controls="tab_two"
                                                aria-selected="false">information</button>
                                        </li>
                                        <li>
                                            <button id="tab_three_btn" type="button" data-bs-toggle="tab"
                                                data-bs-target="#tab_three" role="tab" aria-controls="tab_three"
                                                aria-selected="false">reviews</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content reviews-tab">
                                        <div class="tab-pane fade show active" id="tab_one" role="tabpanel"
                                            aria-labelledby="tab_one_btn">
                                            <div class="tab-one">
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla
                                                    augue nec est tristique auctor. Ipsum metus feugiat sem, quis fermentum
                                                    turpis eros eget velit. Donec ac tempus ante. Fusce ultricies massa
                                                    massa. Fusce aliquam, purus eget sagittis vulputate, sapien libero
                                                    hendrerit est, sed commodo augue nisi non neque.</p>
                                                <div class="review-description">
                                                    <div class="tab-thumb">
                                                        <img src="assets/img/about/services.jpg" alt="">
                                                    </div>
                                                    <div class="tab-des">
                                                        <h3>Product Information :</h3>
                                                        <ul>
                                                            <li>Donec non est at libero vulputate rutrum</li>
                                                            <li>Morbi ornare lectus quis justo gravida</li>
                                                            <li>Pellentesque aliquet, sem eget laoreet</li>
                                                            <li>Donec a neque libero</li>
                                                            <li>Pellentesque aliquet, sem eget laoreet</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <p>Cras neque metus, consequat et blandit et, luctus a nunc. Etiam gravida
                                                    vehicula tellus, in imperdiet ligula euismod eget. Pellentesque habitant
                                                    morbi tristique senectus et netus et malesuada fames ac turpis egestas.
                                                    Nam erat mi, rutrum at sollicitudin rhoncus, ultricies posuere erat.
                                                    Duis convallis, arcu nec aliquam consequat, purus felis vehicula felis,
                                                    a dapibus enim lorem nec augue. Nunc facilisis sagittis ullamcorper.</p>
                                                <p>Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed
                                                    et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et
                                                    ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus
                                                    adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada
                                                    tincidunt.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab_two" role="tabpanel"
                                            aria-labelledby="tab_two_btn">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>color</td>
                                                        <td>black, blue, red</td>
                                                    </tr>
                                                    <tr>
                                                        <td>size</td>
                                                        <td>L, M, S</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="tab_three" role="tabpanel"
                                            aria-labelledby="tab_three_btn">
                                            <form action="#" class="review-form">
                                                <h5>1 review for <span>Chaz Kangeroo Hoodies</span></h5>
                                                <div class="total-reviews">
                                                    <div class="rev-avatar">
                                                        <img src="assets/img/about/avatar.jpg" alt="">
                                                    </div>
                                                    <div class="review-box">
                                                        <div class="ratings">
                                                            <span class="good"><i class="fa fa-star"></i></span>
                                                            <span class="good"><i class="fa fa-star"></i></span>
                                                            <span class="good"><i class="fa fa-star"></i></span>
                                                            <span class="good"><i class="fa fa-star"></i></span>
                                                            <span><i class="fa fa-star"></i></span>
                                                        </div>
                                                        <div class="post-author">
                                                            <p><span>admin -</span> 30 Nov, 2018</p>
                                                        </div>
                                                        <p>Aliquam fringilla euismod risus ac bibendum. Sed sit amet sem
                                                            varius ante feugiat lacinia. Nunc ipsum nulla, vulputate ut
                                                            venenatis vitae, malesuada ut mi. Quisque iaculis, dui congue
                                                            placerat pretium, augue erat accumsan lacus</p>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Your Name</label>
                                                        <input type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Your Email</label>
                                                        <input type="email" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Your Review</label>
                                                        <textarea class="form-control" required></textarea>
                                                        <div class="help-block pt-10"><span
                                                                class="text-danger">Note:</span>
                                                            HTML is not translated!
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <div class="col">
                                                        <label class="col-form-label"><span class="text-danger">*</span>
                                                            Rating</label>
                                                        &nbsp;&nbsp;&nbsp; Bad&nbsp;
                                                        <input type="radio" value="1" name="rating">
                                                        &nbsp;
                                                        <input type="radio" value="2" name="rating">
                                                        &nbsp;
                                                        <input type="radio" value="3" name="rating">
                                                        &nbsp;
                                                        <input type="radio" value="4" name="rating">
                                                        &nbsp;
                                                        <input type="radio" value="5" name="rating" checked>
                                                        &nbsp;Good
                                                    </div>
                                                </div>
                                                <div class="buttons">
                                                    <button class="sqr-btn" type="submit">Continue</button>
                                                </div>
                                            </form> <!-- end of review-form -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details reviews end -->

                    <!-- featured product area start -->
                    <section class="Related-product">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section-title text-center">
                                        <h2 class="title">Related Product</h2>
                                        <p class="sub-title">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="product-carousel-4 mbn-50 slick-row-15 slick-arrow-style">
                                        <!-- product single item start -->
                                        <div class="product-item mb-50">
                                            <div class="product-thumb">
                                                <a href="product-details.html">
                                                    <img src="assets/img/product/product-1.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h5 class="product-name">
                                                    <a href="product-details.html">Leather Mens Slipper</a>
                                                </h5>
                                                <div class="price-box">
                                                    <span class="price-regular">$80.00</span>
                                                    <span class="price-old"><del>$70.00</del></span>
                                                </div>
                                                <div class="product-action-link">
                                                    <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                                                            class="ion-android-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" title="Add To Cart"><i
                                                            class="ion-bag"></i></a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#quick_view">
                                                        <span data-bs-toggle="tooltip" title="Quick View"><i
                                                                class="ion-ios-eye-outline"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product single item start -->

                                        <!-- product single item start -->
                                        <div class="product-item mb-50">
                                            <div class="product-thumb">
                                                <a href="product-details.html">
                                                    <img src="assets/img/product/product-2.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h5 class="product-name">
                                                    <a href="product-details.html">Quickiin Mens shoes</a>
                                                </h5>
                                                <div class="price-box">
                                                    <span class="price-regular">$80.00</span>
                                                    <span class="price-old"><del>$70.00</del></span>
                                                </div>
                                                <div class="product-action-link">
                                                    <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                                                            class="ion-android-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" title="Add To Cart"><i
                                                            class="ion-bag"></i></a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#quick_view">
                                                        <span data-bs-toggle="tooltip" title="Quick View"><i
                                                                class="ion-ios-eye-outline"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product single item start -->

                                        <!-- product single item start -->
                                        <div class="product-item mb-50">
                                            <div class="product-thumb">
                                                <a href="product-details.html">
                                                    <img src="assets/img/product/product-3.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h5 class="product-name">
                                                    <a href="product-details.html">Rexpo Womens shoes</a>
                                                </h5>
                                                <div class="price-box">
                                                    <span class="price-regular">$80.00</span>
                                                    <span class="price-old"><del>$70.00</del></span>
                                                </div>
                                                <div class="product-action-link">
                                                    <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                                                            class="ion-android-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" title="Add To Cart"><i
                                                            class="ion-bag"></i></a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#quick_view">
                                                        <span data-bs-toggle="tooltip" title="Quick View"><i
                                                                class="ion-ios-eye-outline"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product single item start -->

                                        <!-- product single item start -->
                                        <div class="product-item mb-50">
                                            <div class="product-thumb">
                                                <a href="product-details.html">
                                                    <img src="assets/img/product/product-4.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h5 class="product-name">
                                                    <a href="product-details.html">Primitive Mens shoes</a>
                                                </h5>
                                                <div class="price-box">
                                                    <span class="price-regular">$80.00</span>
                                                    <span class="price-old"><del>$70.00</del></span>
                                                </div>
                                                <div class="product-action-link">
                                                    <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                                                            class="ion-android-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" title="Add To Cart"><i
                                                            class="ion-bag"></i></a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#quick_view">
                                                        <span data-bs-toggle="tooltip" title="Quick View"><i
                                                                class="ion-ios-eye-outline"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product single item start -->

                                        <!-- product single item start -->
                                        <div class="product-item mb-50">
                                            <div class="product-thumb">
                                                <a href="product-details.html">
                                                    <img src="assets/img/product/product-5.jpg" alt="">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h5 class="product-name">
                                                    <a href="product-details.html">Leather Mens Slipper</a>
                                                </h5>
                                                <div class="price-box">
                                                    <span class="price-regular">$80.00</span>
                                                    <span class="price-old"><del>$70.00</del></span>
                                                </div>
                                                <div class="product-action-link">
                                                    <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                                                            class="ion-android-favorite-outline"></i></a>
                                                    <a href="#" data-bs-toggle="tooltip" title="Add To Cart"><i
                                                            class="ion-bag"></i></a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#quick_view">
                                                        <span data-bs-toggle="tooltip" title="Quick View"><i
                                                                class="ion-ios-eye-outline"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- product single item start -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- featured product area end -->
                </div>
            </div>
        </div>
    </div>
    <!-- product details wrapper end -->
@endsection


@push('footer')
    <script>
        $(document).ready(function() {
            let selectedSize = null;
            let selectedColor = null;

            // Handle size selection
            $('.size-tab').on('click', '.size-button:not(.disabled)', function() {
                $('.size-tab .size-button').removeClass('active');
                $(this).addClass('active');
                selectedSize = $(this).data('size-id');
                updateProductDetails();
            });

            // Handle color selection
            $('.color-tab').on('click', '.color-button', function() {
                $('.color-tab .color-button').removeClass('active');
                $(this).addClass('active');
                selectedColor = $(this).data('color-id');
                updateProductDetails();
            });

            function updateProductDetails() {
                if (selectedSize && selectedColor) {
                    $.ajax({
                        url: '/product-variation-details',
                        method: 'GET',
                        data: {
                            size_id: selectedSize,
                            color_id: selectedColor
                        },
                        success: function(response) {
                            // Update product price, image, and other details
                            $('.regular-price').text('₹ ' + response.price);
                            $('.product-large-slider').html(response.imagesHtml);
                            $('.pro-nav').html(response.thumbnailsHtml);

                            // Reinitialize slick slider
                            initializeSlickSlider();
                        },
                        error: function() {
                            alert('Failed to update product details. Please try again.');
                        }
                    });
                }
            }

            function initializeSlickSlider() {
                $('.product-large-slider').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: true,
                    fade: true,
                    asNavFor: '.pro-nav',
                });

                $('.pro-nav').slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    asNavFor: '.product-large-slider',
                    dots: false,
                    focusOnSelect: true,
                });
            }
        });
    </script>
@endpush
