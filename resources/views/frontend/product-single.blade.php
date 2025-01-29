@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area bg-img" data-bg="assets/img/breadcrumb-banner.webp">
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
                                
                                <div class="product-large-slider mb-4">
                                  
                                </div>

                                <div class="pro-nav slick-row-5">
                                   
                                </div>

                            </div>
                            <div class="col-lg-7">
                                <div class="product-details-des">
                                    <h3 class="pro-det-title product-title">{{ $product->product_name }}</h3>
                                    <div class="pro-review d-none">
                                        <span><a href="#">0 Review(s)</a></span>
                                    </div>
                                    <div class="price-box">
                                        <span class="regular-price">{{ min_price($product->id) }}</span>
                                    </div>
                                    <div class="price-box small">
                                        <small>SKU</small> : <span class="text-theme  productSku"></span>
                                    </div>
                                    <div class="price-box my-3">
                                        <span class="text-success small">Inclusive of all taxes</span>
                                    </div>

                                    <div class="product__variations">
                                        <h5 class="cat-title mb-3 fw-bolder">Available Sizes :</h5>
                                        <div class="size-tab round-radio">
                                            @foreach ($all_sizes as $size)
                                                <label
                                                    class="size-button {{ $sizes->contains('value', $size) ? '' : 'disabled' }}"
                                                    data-size-id="{{ $size }}">
                                                    <input type="radio" class="hidden variSize_checkbox"
                                                        data-product="{{ $product->id }}" name="size"
                                                        value="{{ $size }}">
                                                    <span>{{ $size }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                        <div class="size-chart mb-2">
                                            <a href="#" class="text-theme" data-bs-toggle="modal"
                                                data-bs-target="#sizeChart">Size Guide</a>
                                        </div>

                                        <div class="color-option1 mb-4">
                                            <h5 class="cat-title mb-3 fw-bolder">Available Colors :</h5>
                                            <div class="color-tab">

                                            </div>
                                        </div>

                                    </div>
                                    <div class="quantity-cart-box d-flex align-items-center mb-4">
                                        <div class="quantity" x-data="{ quantity: 1 }">
                                            <div class="pro-qty">
                                                <button class="dec qtybtn"
                                                    @click="quantity > 1 ? quantity-- : quantity">-</button>
                                                <input id="quantity" type="text" x-model="quantity" readonly>
                                                <button class="inc qtybtn" @click="quantity++">+</button>
                                            </div>
                                        </div>
                                        <button id="addToCartBtn" class="btn btn-dark add-to-cart">Add To Cart</button>
                                    </div>
                                    <div class="availability mb-4">
                                        <h5 class="cat-title">Availability:</h5>
                                        <span class="stockStatus text-capitalize">In Stock</span>
                                    </div>
                                    <div class="share-icon">
                                        <h5 class="cat-title">Share:</h5>
                                        <div class="sharethis-inline-share-buttons"></div>
                                    </div>
                                </div>

                                <div class="accordion accordion-flush mt-3" x-data="{ open: '' }">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-ProductDetails">
                                            <button class="accordion-button text-dark fw-bold"
                                                :class="{ 'collapsed': open !== 'ProductDetails' }" type="button"
                                                @click="open === 'ProductDetails' ? open = '' : open = 'ProductDetails'"
                                                aria-controls="flush-ProductDetails">
                                                Product Details
                                            </button>
                                        </h2>
                                        <div id="flush-ProductDetails" class="accordion-collapse collapse"
                                            :class="{ 'show': open === 'ProductDetails' }"
                                            aria-labelledby="flush-ProductDetails">
                                            <div class="accordion-body">
                                                <small> {{ $product->description }}</small>
                                                <br>
                                                <h5 class="mt-3 fw-bold mb-3">Specifications</h5>
                                                <div class="row">

                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Shoe Type</small><br>
                                                        <small class="text-grey ms-2">{{ $product->shoe_type }}</small>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Occasion</small><br>
                                                        @foreach ($product->categories ?? [] as $item)
                                                            <small class="text-grey ms-2">{{ $item->name }}</small>
                                                        @endforeach
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Upper Material</small><br>
                                                        <small class="text-grey ms-2">Vegan</small>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Heel Type</small><br>
                                                        <small class="text-grey ms-2">Flats</small>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Gender</small><br>
                                                        <small class="text-grey ms-2">Women</small>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Net Quantity</small><br>
                                                        <small class="text-grey ms-2">1</small>
                                                    </div>

                                                    <div class="col-lg-6 d-none">
                                                        <small class="mt-3 fw-bold">Available Sizes</small><br>
                                                        @foreach ($sizes ?? [] as $Asize)
                                                            <small
                                                                class="text-grey ms-2">{{ $Asize->value }}{{ $loop->last ? '' : ',' }}</small>
                                                        @endforeach
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Available Colors</small><br>
                                                        @foreach ($colors ?? [] as $Acolor)
                                                            <small
                                                                class="text-grey ms-2">{{ $Acolor->value }}{{ $loop->last ? '' : ',' }}</small>
                                                        @endforeach
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Brand</small><br>
                                                        <small class="text-grey ms-2">Soleful</small>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <small class="mt-3 fw-bold">Country of Origin</small><br>
                                                        <small class="text-grey ms-2">INDIA</small>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-CareInstruction">
                                            <button class="accordion-button text-dark fw-bold"
                                                :class="{ 'collapsed': open !== 'CareInstruction' }" type="button"
                                                @click="open === 'CareInstruction' ? open = '' : open = 'CareInstruction'"
                                                aria-controls="flush-CareInstruction">
                                                Care Instruction
                                            </button>
                                        </h2>
                                        <div id="flush-CareInstruction" class="accordion-collapse collapse"
                                            :class="{ 'show': open === 'CareInstruction' }"
                                            aria-labelledby="flush-CareInstruction">
                                            <div class="accordion-body">
                                                <small>{{ $product->care_instruction }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-OtherDetails">
                                            <button class="accordion-button text-dark fw-bold"
                                                :class="{ 'collapsed': open !== 'OtherDetails' }" type="button"
                                                @click="open === 'OtherDetails' ? open = '' : open = 'OtherDetails'"
                                                aria-controls="flush-OtherDetails">
                                                Other Details
                                            </button>
                                        </h2>
                                        <div id="flush-OtherDetails" class="accordion-collapse collapse d-none"
                                            :class="{ 'show': open === 'OtherDetails' }"
                                            aria-labelledby="flush-OtherDetails">
                                            <div class="accordion-body">
                                                <h6 class="fw-bold mb-2">
                                                    Manufactured By:
                                                </h6>
                                                <small>{{ $product->manufactured_by }}</small>
                                                <h6 class="mt-3 fw-bold mb-2">
                                                    Packed and Marketed By :
                                                </h6>
                                                <small>{{ $product->marketed_by }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-ConsumerComplaintContact">
                                            <button class="accordion-button text-dark fw-bold"
                                                :class="{ 'collapsed': open !== 'ConsumerComplaintContact' }"
                                                type="button"
                                                @click="open === 'ConsumerComplaintContact' ? open = '' : open = 'ConsumerComplaintContact'"
                                                aria-controls="flush-ConsumerComplaintContact">
                                                Consumer Complaint Contact
                                            </button>
                                        </h2>
                                        <div id="flush-ConsumerComplaintContact" class="accordion-collapse collapse"
                                            :class="{ 'show': open === 'ConsumerComplaintContact' }"
                                            aria-labelledby="flush-ConsumerComplaintContact">
                                            <div class="accordion-body">
                                                <small>Email: <a
                                                        href="mailto:relationship@soleful.in">relationship@soleful.in</a><br></small>
                                                <small>Phone: <a href="tel:+91 79966 66225">+91 79966 66225</a></small>
                                                <br>
                                                <small class="fw-bold">Please contact us at the marketer's address for any
                                                    customer complaints.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- featured product area start -->
                    <section class="Related-product mt-20">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section-title text-center">
                                        <h2 class="title fw-bold">Similar Products</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="product-carousel-4 mbn-50 slick-row-15 slick-arrow-style">
                                        @foreach ($similarProducts ?? [] as $similarProduct)
                                            <div class="product-item mb-50">
                                                <div class="product-thumb">
                                                    <a target="_blank"
                                                        href="{{ route('public.product', ['uid' => $similarProduct->unique_value, 'slug' => $similarProduct->slug]) }}">
                                                        <img src="{{ isset($similarProduct->MainThumbImage) && $similarProduct->MainThumbImage->image ? asset('images/products/' . $similarProduct->MainThumbImage->image) : asset('images/default.jpg') }}"
                                                            alt="{{ $similarProduct->product_name }}">
                                                    </a>
                                                </div>
                                                <div class="product-content">
                                                    <a target="_blank"
                                                        href="{{ route('public.product', ['uid' => $similarProduct->unique_value, 'slug' => $similarProduct->slug]) }}">
                                                        <h5 class="product-name">
                                                            {{ $similarProduct->product_name }}
                                                        </h5>
                                                        <div class="price-box">
                                                            <div class="">
                                                                <small>Sizes :
                                                                    @foreach ($similarProduct->variationSizes->unique('value')->pluck('value') ?? [] as $abSize)
                                                                        <i class="text-grey">{{ $abSize }},</i>
                                                                    @endforeach
                                                                </small>
                                                            </div>
                                                            <div class="my-2">
                                                                <small>Colors :
                                                                    @foreach ($similarProduct->variationColors->unique('value')->pluck('value') ?? [] as $abColor)
                                                                        <i class="text-grey">{{ $abColor }},</i>
                                                                    @endforeach
                                                                </small>
                                                            </div>
                                                            <span class="price-regular small fw-semibold">
                                                                ₹ {{ number_format($similarProduct->minPrice) }}</span>
                                                        </div>
                                                    </a>
                                                    <div class="product-action-link d-none">
                                                        <a href="#" id="wishlist-btn-{{ $similarProduct->id }}"
                                                            class="wishlist-btn"
                                                            data-product-id="{{ $similarProduct->id }}"
                                                            title="Add To Wishlist"><i class="bi bi-heart"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-product-id="{{ $similarProduct->id }}"
                                                            data-bs-target="#quick_view" class="quick_view-btn"
                                                            title="Add To Cart"><i class="bi bi-bag-check"></i></a>
                                                        <a target="_blank"
                                                            href="{{ route('public.product', ['uid' => $similarProduct->unique_value, 'slug' => $similarProduct->slug]) }}">
                                                            <span title="Detail View">
                                                                <i class="ion-ios-eye-outline"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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

