@extends('layouts.app')
@section('content')
    <!-- Hero Slider Section Start -->
<section class="hero-slider" @detect style="margin-top: 10px;" @else style="margin-top: 47px;"
    @enddetect>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="hero-slider-active slick-arrow-style slick-arrow-style_hero slick-dot-style">
                    @detect
                        @foreach ($slider_in_mobile ?? [] as $mobile)
                            <!-- Single Slider Item Start -->
                            <div class="hero-single-slide">
                                <a href="{{ $mobile['link'] != null ? $mobile['link'] : '#' }}" target="_blank">

                                    <div class="hero-slider-item bg-img"
                                        data-bg="{{ asset('images/' . $mobile['mobile']) }}">
                                    </div>

                                </a>
                            </div>
                            <!-- Single Slider Item End -->
                        @endforeach
                    @else
                        @foreach ($slider_in_desktop ?? [] as $desktop)
                            <!-- Single Slider Item Start -->
                            <div class="hero-single-slide">
                                <a href="{{ $desktop['link'] != null ? $desktop['link'] : '#' }}" target="_blank">
                                    <div class="hero-slider-item bg-img"
                                        data-bg="{{ asset('images/' . $desktop['desktop']) }}">
                                    </div>
                                </a>
                            </div>
                            <!-- Single Slider Item End -->
                        @endforeach
                    @enddetect
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Slider Section End -->


<!-- Featured Collections Start -->
<section class="our-product section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title">Featured Collections </h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="product-carousel-4 mbn-50 slick-row-15 slick-arrow-style">
                    @foreach ($featuredProduct ?? [] as $featuredPdct)
                        <div class="product-item mb-50">
                            <div class="product-thumb">
                                <a target="_blank"
                                    href="{{ route('public.product', ['uid' => $featuredPdct->product->unique_value, 'slug' => $featuredPdct->product->slug]) }}">
                                    <img src="{{ isset($featuredPdct->product->MainThumbImage) && $featuredPdct->product->MainThumbImage->image ? asset('images/products/' . $featuredPdct->product->MainThumbImage->image) : asset('images/default.jpg') }}"
                                        alt="{{ $featuredPdct->product->product_name }}">
                                </a>
                            </div>
                            <div class="product-content">
                                <h5 class="product-name">
                                    <a target="_blank"
                                        href="{{ route('public.product', ['uid' => $featuredPdct->product->unique_value, 'slug' => $featuredPdct->product->slug]) }}">{{ $featuredPdct->product->product_name }}</a>
                                </h5>

                                <div class="price-box">
                                    <div class="">
                                        <small>Sizes :
                                            @foreach ($featuredPdct->product->variationSizes->unique('value')->pluck('value') ?? [] as $abSize)
                                                <i class="text-grey">{{ $abSize }},</i>
                                            @endforeach
                                        </small>
                                    </div>
                                    <div class="my-2">
                                        <small>Colors :
                                            @foreach ($featuredPdct->product->variationColors->unique('value')->pluck('value') ?? [] as $abColor)
                                                <i class="text-grey text-capitalize">{{ strtolower($abColor) }},</i>
                                            @endforeach
                                        </small>
                                    </div>

                                    <span class="price-regular small fw-semibold">
                                        {{ getPrice($featuredPdct->product->minPrice) }}
                                    </span>
                                </div>
                                <div class="product-action-link">
                                    <a href="#" id="wishlist-btn-{{ $featuredPdct->product->id }}"
                                        class="wishlist-btn" data-product-id="{{ $featuredPdct->product->id }}"
                                        title="Add To Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="#" data-bs-toggle="modal"
                                        data-product-id="{{ $featuredPdct->product->id }}" data-bs-target="#quick_view"
                                        class="quick_view-btn" title="Add To Cart"><i class="bi bi-bag-check"></i></a>
                                    <a target="_blank"
                                        href="{{ route('public.product', ['uid' => $featuredPdct->product->unique_value, 'slug' => $featuredPdct->product->slug]) }}">
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
        <div class="row mt-5"> 
            <div class="col-12">
                <div class="product2-carousel-4 mbn-50 slick-row-15 slick-arrow-style"  dir="rtl" >
                 
                    @foreach ($featuredProduct->reverse() ?? [] as $featuredPdct)
                        <div class="product-item mb-50">
                            <div class="product-thumb">
                                <a target="_blank"
                                    href="{{ route('public.product', ['uid' => $featuredPdct->product->unique_value, 'slug' => $featuredPdct->product->slug]) }}">
                                    <img src="{{ isset($featuredPdct->product->MainThumbImage) && $featuredPdct->product->MainThumbImage->image ? asset('images/products/' . $featuredPdct->product->MainThumbImage->image) : asset('images/default.jpg') }}"
                                        alt="{{ $featuredPdct->product->product_name }}">
                                </a>
                            </div>
                            <div class="product-content">
                                <h5 class="product-name">
                                    <a target="_blank"
                                        href="{{ route('public.product', ['uid' => $featuredPdct->product->unique_value, 'slug' => $featuredPdct->product->slug]) }}">{{ $featuredPdct->product->product_name }}</a>
                                </h5>

                                <div class="price-box">
                                    <div class="">
                                        <small>Sizes :
                                            @foreach ($featuredPdct->product->variationSizes->unique('value')->pluck('value') ?? [] as $abSize)
                                                <i class="text-grey">{{ $abSize }},</i>
                                            @endforeach
                                        </small>
                                    </div>
                                    <div class="my-2">
                                        <small>Colors :
                                            @foreach ($featuredPdct->product->variationColors->unique('value')->pluck('value') ?? [] as $abColor)
                                                <i class="text-grey text-capitalize">{{ strtolower($abColor) }},</i>
                                            @endforeach
                                        </small>
                                    </div>

                                    <span class="price-regular small fw-semibold">
                                        {{ getPrice($featuredPdct->product->minPrice) }}
                                    </span>
                                </div>
                                <div class="product-action-link">
                                    <a href="#" id="wishlist-btn-{{ $featuredPdct->product->id }}"
                                        class="wishlist-btn" data-product-id="{{ $featuredPdct->product->id }}"
                                        title="Add To Wishlist"><i class="bi bi-heart"></i></a>
                                    <a href="#" data-bs-toggle="modal"
                                        data-product-id="{{ $featuredPdct->product->id }}" data-bs-target="#quick_view"
                                        class="quick_view-btn" title="Add To Cart"><i class="bi bi-bag-check"></i></a>
                                    <a target="_blank"
                                        href="{{ route('public.product', ['uid' => $featuredPdct->product->unique_value, 'slug' => $featuredPdct->product->slug]) }}">
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

<!-- Featured Collections End -->

<!-- Banner Statistic Area Start -->
<div class="banner-statistics">
    <div class="container">
        <div class="row g-0 mtn-30" x-data="bannerImageSwitcher()" x-init="init()">
            <div class="col-md-6">
                <div class="img-container first-offer mt-30">
                    <a class="d-block" :href="offerFirstRedirection">
                        <img class="w-100" :src="offerAdvertisementFirst" alt="offer-image-1">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="img-container second-offer mt-30">
                    <a class="d-block" :href="offerSecondRedirection">
                        <img class="w-100" :src="offerAdvertisementSecond" alt="offer-image-2">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner Statistic Area End -->
<!-- top seller area start -->
<section class="top-seller-area section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title">Season’s Top Picks</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5">
                @if ($productOffer)
                    <div class="product-banner">
                        <a href="{{ $productOffer->redirection }}" target="_blank">
                            <img src="{{ asset('images/' . $productOffer->image) }}" alt="product banner">
                        </a>
                    </div>
                @endif
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7">
                <div class="top-seller-carousel slick-row-15 mtn-30">
                    @foreach ($bestSellProduct ?? [] as $bestPRoduct)
                        <!-- product item start -->
                        <div class="slide-item">
                            <div class="pro-item-small mt-30">
                                <div class="product-thumb">
                                    <a target="_blank"
                                        href="{{ route('public.product', ['uid' => $bestPRoduct->product->unique_value, 'slug' => $bestPRoduct->product->slug]) }}">
                                        <img src="{{ isset($bestPRoduct->product->MainThumbImage) && $bestPRoduct->product->MainThumbImage->image ? asset('images/products/' . $bestPRoduct->product->MainThumbImage->image) : asset('images/default.jpg') }}"
                                            alt="{{ $bestPRoduct->product->product_name }}">
                                    </a>
                                </div>
                                <div class="pro-small-content">
                                    <a target="_blank"
                                        href="{{ route('public.product', ['uid' => $bestPRoduct->product->unique_value, 'slug' => $bestPRoduct->product->slug]) }}">
                                        <h6 class="product-name">
                                            {{ $bestPRoduct->product->product_name }}
                                        </h6>
                                        <div class="price-box">
                                            <div class="">
                                                <small>Sizes :
                                                    @foreach ($bestPRoduct->product->variationSizes->unique('value')->pluck('value') ?? [] as $abSize)
                                                        <i class="text-grey">{{ $abSize }},</i>
                                                    @endforeach
                                                </small>
                                            </div>
                                            <div class="my-2">
                                                <small>Colors :
                                                    @foreach ($bestPRoduct->product->variationColors->unique('value')->pluck('value') ?? [] as $abColor)
                                                        <i class="text-grey text-capitalize">{{ strtolower($abColor) }},</i>
                                                    @endforeach
                                                </small>
                                            </div>
                                            <span class="price-regular">
                                                {{ getPrice($bestPRoduct->product->minPrice) }}</span>
                                        </div>
                                    </a>
                                    {{-- <div class="ratings">
                                        <span><i class="ion-android-star"></i></span>
                                        <span><i class="ion-android-star"></i></span>
                                        <span><i class="ion-android-star"></i></span>
                                        <span><i class="ion-android-star"></i></span>
                                        <span><i class="ion-android-star"></i></span>
                                    </div> --}}
                                    <div class="product-link-2">
                                        <a href="#" id="wishlist-btn-{{ $bestPRoduct->product->id }}"
                                            class="wishlist-btn" data-product-id="{{ $bestPRoduct->product->id }}"
                                            data-bs-toggle="tooltip" title="Add To Wishlist"><i
                                                class="bi bi-heart"></i></a>
                                        <a data-bs-toggle="modal" data-product-id="{{ $bestPRoduct->product->id }}"
                                            data-bs-target="#quick_view" title="Add To Cart" class="quick_view-btn">
                                            <i class="bi bi-bag-check"></i>
                                        </a>

                                        <a target="_blank"
                                            href="{{ route('public.product', ['uid' => $bestPRoduct->product->unique_value, 'slug' => $bestPRoduct->product->slug]) }}">
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
@if ($blogs->count())
    <!-- Latest Blog Area Start -->

@endif


<!-- Service Features Start -->
<section class="service-policy-area">
    <div class="container">
        <div class="row">
            @foreach ([['icon' => 'policy-1.png', 'title' => 'FREE SHIPPING', 'desc' => 'Free shipping on all orders'], ['icon' => 'customer-support.png', 'title' => 'ONLINE SUPPORT', 'desc' => 'Dedicated online support', 'id' => 'support-link'], ['icon' => 'policy-3.png', 'title' => 'PAYMENTS', 'desc' => 'Hassle-Free Payments.']] as $policy)
                <div class="col-lg-4">
                    @if (isset($policy['id']) && $policy['id'] == 'support-link')
                        <a href="#" id="support-link">
                    @endif
                    <div class="service-policy-item mt-30 bg-{{ $loop->iteration }} rounded-3">
                        <div class="policy-icon">
                            <img src="assets/img/icon/{{ $policy['icon'] }}" alt="policy icon">
                        </div>
                        <div class="policy-content">
                            <h5 class="policy-title">

                                {{ $policy['title'] }}

                            </h5>
                            <p class="policy-desc">{{ $policy['desc'] }}</p>
                        </div>
                    </div>
                    @if (isset($policy['id']) && $policy['id'] == 'support-link')
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- Service Features End -->


@endsection

@push('footer')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var supportLink = document.getElementById("support-link");
        if (supportLink) {
            var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            if (isMobile) {
                supportLink.href = "https://wa.me/+917996666225"; // Replace with your WhatsApp number
            } else {
                supportLink.href = "mailto:relationship@soleful.in"; // Replace with your support email
            }
        }
    });
</script>

<script>
    function bannerImageSwitcher() {
        return {
            advertisements: @json($offerAdvertisements ?? []),
            offerAdvertisementFirst: '',
            offerAdvertisementSecond: '',
            offerFirstRedirection: '#',
            offerSecondRedirection: '#',
            init() {
                if (this.advertisements.length > 0) {
                    this.assignRandomImages();
                }
            },
            assignRandomImages() {
                // () => 0.5 - Math.random()
                const shuffledAds = this.advertisements.sort();
                if (shuffledAds[0]) {
                    this.offerAdvertisementFirst = '/images/' + shuffledAds[0].image;
                    this.offerFirstRedirection = shuffledAds[0].redirection || '#';
                }
                if (shuffledAds[1]) {
                    this.offerAdvertisementSecond = '/images/' + shuffledAds[1].image;
                    this.offerSecondRedirection = shuffledAds[1].redirection || '#';
                }
            }
        };
    }
</script>
@endpush
