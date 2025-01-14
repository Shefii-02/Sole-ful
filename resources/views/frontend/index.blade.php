@extends('layouts.app')
@section('content')
    <!-- hero slider section start -->
    <section class="hero-slider">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
                        @detect
                            {{-- 
                        slider_in_mobile
                        bestSellProduct
                        featuredProduct --}}
                            @foreach ($slider_in_mobile ?? [] as $mobile)
                                <!-- single slider item start -->
                                <div class="hero-single-slide">
                                    <div class="hero-slider-item bg-img" data-bg="{{ asset('images/' . $mobile) }}">

                                    </div>
                                </div>
                                <!-- single slider item end -->
                            @endforeach
                        @else
                            @foreach ($slider_in_desktop ?? [] as $desktop)
                                <!-- single slider item start -->
                                <div class="hero-single-slide">
                                    <div class="hero-slider-item bg-img" data-bg="{{ asset('images/' . $desktop) }}">

                                    </div>
                                </div>
                                <!-- single slider item end -->
                            @endforeach
                        @enddetect
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- hero slider section end -->

    <!-- service features start -->
    <section class="service-policy-area">
        <div class="container">
            <div class="row">
                <!-- single policy item start -->
                <div class="col-lg-4">
                    <div class="service-policy-item mt-30 bg-1 rounded-3">
                        <div class="policy-icon">
                            <img src="assets/img/icon/policy-1.png" alt="policy icon">
                        </div>
                        <div class="policy-content">
                            <h5 class="policy-title">FREE SHIPPING</h5>
                            <p class="policy-desc">Free shipping on all order</p>
                        </div>
                    </div>
                </div>
                <!-- single policy item start -->

                <!-- single policy item start -->
                <div class="col-lg-4">
                    <div class="service-policy-item mt-30 bg-2  rounded-3">
                        <div class="policy-icon">
                            <img src="assets/img/icon/policy-2.png" alt="policy icon">
                        </div>
                        <div class="policy-content">
                            <h5 class="policy-title">ONLINE SUPPORT</h5>
                            <p class="policy-desc">Online support 24 hours a day</p>
                        </div>
                    </div>
                </div>
                <!-- single policy item start -->

                <!-- single policy item start -->
                <div class="col-lg-4">
                    <div class="service-policy-item mt-30 bg-3  rounded-3">
                        <div class="policy-icon">
                            <img src="assets/img/icon/policy-3.png" alt="policy icon">
                        </div>
                        <div class="policy-content">
                            <h5 class="policy-title">MONEY RETURN</h5>
                            <p class="policy-desc">Back guarantee under 5 days</p>
                        </div>
                    </div>
                </div>
                <!-- single policy item start -->
            </div>
        </div>
    </section>
    <!-- service features end -->

    <!-- our product area start -->
    <section class="our-product section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Featured Collections </h2>
                        <p class="sub-title">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-carousel-4 mbn-50 slick-row-15 slick-arrow-style">
                        @foreach ($featuredProduct ?? [] as $featuredPdct)
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
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#quick_view"> <span
                                                data-bs-toggle="tooltip" title="Quick View"><i
                                                    class="ion-ios-eye-outline"></i></span> </a>
                                    </div>
                                </div>
                            </div>
                            <!-- product single item start -->
                        @endforeach
                      
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- our product area end -->

    <!-- banner statistic area start -->
    <div class="banner-statistics">
        <div class="container">
            <div class="row g-0 mtn-30">
                <div class="col-md-6">
                    <div class="img-container first-offer mt-30">
                        <a class="d-block" href="product-details.html">
                            <img class="w-100" src="assets/img/banner/banner-1.jpg" alt="banner-image">
                        </a>
                        <div class="banner-text">
                            <h5 class="banner-subtitle">sports shoes</h5>
                            <h3 class="banner-title">20% Off<br>For Sports men</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="img-container second-offer mt-30">
                        <a class="d-block" href="product-details.html">
                            <img class="w-100" src="assets/img/banner/banner-2.jpg" alt="banner-image">
                        </a>
                        <div class="banner-text">
                            <h5 class="banner-subtitle">sports shoes</h5>
                            <h3 class="banner-title">20% Off<br>For Sports men</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner statistic area end -->

    <!-- top seller area start -->
    <section class="top-seller-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Season’s Top Picks</h2>
                        <p class="sub-title">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-5">
                    <div class="product-banner">
                        <a href="#">
                            <img src="assets/img/banner/banner-3.jpg" alt="product banner">
                        </a>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7">
                    <div class="top-seller-carousel slick-row-15 mtn-30">
                        @foreach ($bestSellProduct ?? [] as $bestPRoduct)
                            <!-- product item start -->
                            <div class="slide-item">
                                <div class="pro-item-small mt-30">
                                    <div class="product-thumb">
                                        <a href="product-details.html">
                                            <img src="assets/img/product/pro-small-1.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="pro-small-content">
                                        <h6 class="product-name">
                                            <a href="product-details.html">Simple Fabric Shoe</a>
                                        </h6>
                                        <div class="price-box">
                                            <span class="price-regular">$80.00</span>
                                            <span class="price-old"><del>$70.00</del></span>
                                        </div>
                                        <div class="ratings">
                                            <span><i class="ion-android-star"></i></span>
                                            <span><i class="ion-android-star"></i></span>
                                            <span><i class="ion-android-star"></i></span>
                                            <span><i class="ion-android-star"></i></span>
                                            <span><i class="ion-android-star"></i></span>
                                        </div>
                                        <div class="product-link-2">
                                            <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                                                    class="ion-android-favorite-outline"></i></a>
                                            <a href="#" data-bs-toggle="tooltip" title="Add To Cart"><i
                                                    class="ion-bag"></i></a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#quick_view">
                                                <span data-bs-toggle="tooltip" title="Quick View"><i
                                                        class="ion-ios-eye-outline"></i></span> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- product item start -->
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- top seller area end -->

    <!-- latest blog area start -->
    <section class="latest-blog-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">our blog</h2>
                        <p class="sub-title">Lorem ipsum dolor sit amet consectetur adipisicing</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="blog-carousel-active slick-row-15">
                        @foreach ($blogs ?? [] as $blog)
                            <!-- blog single item start -->
                            <div class="blog-post-item">
                                <div class="blog-thumb">
                                    <a href="blog-details.html">
                                        <img src="assets/img/blog/blog-1.jpg" alt="blog thumb">
                                    </a>
                                </div>
                                <div class="blog-content">
                                    <h5 class="blog-title">
                                        <a href="blog-details.html">
                                            Celebrity Daughter Opens About to Having Her Eye color
                                        </a>
                                    </h5>
                                    <ul class="blog-meta">
                                        <li><span>By: </span>Admin,</li>
                                        <li><span>On: </span>14.07.2029</li>
                                    </ul>
                                    <a href="blog-details.html" class="read-more">Read More...</a>
                                </div>
                            </div>
                            <!-- blog single item start -->
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- latest blog area end -->
@endsection
