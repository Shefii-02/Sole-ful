<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{csrf_token()}">

    <title>Soleful</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!--=== Favicon ===-->
    {{-- <link rel="icon" type="image/x-icon" href="/assets/img/logo/logo.png"> --}}
    {{-- <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" /> --}}
    <!--=== All Plugins CSS ===-->
    {{-- <link href="/assets/css/plugins.css?v=1.2" rel="stylesheet"> --}}
    <!--=== All Vendor CSS ===-->
    {{-- <link href="/assets/css/vendor.css?v=1.2" rel="stylesheet"> --}}
    <!--=== Main Style CSS ===-->
    {{-- <link href="/assets/css/style.css?v=1.2" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta http-equiv="refresh" content="1800">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script> --}}
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    @stack('header')

    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=678d3d239b23f500127153b0&product=inline-share-buttons&source=platform"
        async="async"></script>
    <style>
        :root,
        [data-bs-theme=light].:host,
        html {
            --bs-body-font-family: "lato-bold" !important;
        }

      

        .font-family-lato {
            font-family: "lato-bold" !important;
        }

        .product-listing .cart-item,
        .product-detail-slider .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .product-listing .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 5px;
        }

        .product-listing .cart-item-image,
        .product-detail-slider .cart-item-image {
            width: 40px;
            height: 40px;
            background-color: #eee;
            margin-right: 10px;
        }

        .item-count-addon {
            position: absolute;
            top: -20px;
            right: -10px;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            text-align: center;
            font-size: 12px;
        }

        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cart-item-details {
            flex-grow: 1;
            margin-right: 10px;
        }

        .product-listing .cart-item-title,
        .product-detail-slider .cart-item-title {
            font-size: 14px;
            color: #333;
            margin-bottom: 3px;
        }

        .max-h-75 {
            max-height: 20rem;
        }
    </style>
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

        .color-tab label.active img,
        .size-button.active {
            border: 5px solid #df9b19;
        }

        .color-tab label img {
            border: 1px solid #a1a1a1;
            border-radius: 100%;
        }

        .pac-logo {
            z-index: 99999999 !important;
        }

        .toast-container {
            z-index: 999999999 !important;
        }



        /* .pro-nav {
            height: 100%;
   
            overflow-y: auto;
     
        } */

        .pro-nav-thumb .slick-slide {
            min-height: 100px !important;
            transform: none !important;
        }

        .pro-nav .slick-list {
            height: 100% !important;
            /* Ensure the list takes full height */
        }

        /* .pro-nav .slick-track {
            display: flex;
            flex-direction: column;
            
        } */

        .pro-nav .slick-slide {
            margin: 5px 0;
            /* Adjust spacing between thumbnails */
        }

        .product-large-slider {
            width: 100%;
            /* Ensure main slider takes full width */
        }

        #st-1 {

            z-index: 1 !important;
        }

        .lg-backdrop.in {
            opacity: 0.5 !important;
        }

        .lg-outer {
            width: 60% !important;
            height: 70% !important;
            position: fixed;
            top: 50px !important;
            margin: 0 auto;
            left: 22% !important;
            z-index: 1050;
            text-align: left;
            opacity: 0.001;
            outline: none;
            will-change: auto;
            overflow: hidden;
            border-radius: 25px;
            background: #fff;
        }


        .lg-outer .lg-inner {
            bottom: 40px !important;
        }

        .lg-item {
            display: inline-block;
            height: 100%;
            position: absolute;
            text-align: center;
            width: 100%;
        }


        .lg-next,
        .lg-prev {
            color: #fff !important;
        }

        .lg-counter,
        .lg-toolbar .lg-icon {
            color: #000000 !important;
            display: block !important;

        }


        .product-large-slider .slick-dots {
            display: none !important;
            bottom: -25px;
            display: block;
            list-style: none;
            margin: 0;
            padding: 0;
            position: absolute;
            text-align: center;
            width: 100%;
        }

        .product-large-slider .slick-dots li,
        .product-large-slider .slick-dots li button {
            cursor: pointer;
            height: 10px;
            width: 10px;
        }

        .product-large-slider .slick-dots li {
            display: inline-block;
            margin: 0 5px;
            padding: 0;
            position: relative;
        }

        .product-large-slider .slick-dots li button {
            background: #000000;
            border: 0;
            color: #000000;
            display: block;
            font-size: 0;
            line-height: 0;
            outline: none;
            padding: 5px;
        }

        .product-large-slider li.slick-active button {
            background: #df9b19 !important;
        }

        .product-large-slider .slick-dots li,
        .product-large-slider .slick-dots li button {
            cursor: pointer;
            border-radius: 25px;
        }


        @media only screen and (max-width: 600px) {
            .product-large-slider .slick-dots {
                display: block !important;
                margin-top: 5px;
                position: static !important;
            }


            .offcanvas {
                width: 60% !important;
            }

            .lg-outer {
                width: 100% !important;
                height: 85% !important;
                position: fixed;
                top: 50px !important;
                margin: 0 auto;
                left: 0% !important;
                z-index: 1050;
                text-align: left;
                opacity: 0.001;
                outline: none;
                will-change: auto;
                overflow: hidden;
                border-radius: 25px;
                background: #fff;
            }


        }

        .pro-large-img img {
            border: 0 !important;
        }

        @media screen and (max-width:640px) {
            .gallery-lightbox-controls {
                display: flex !important;

            }

            .gallery-lightbox-control-btn .gallery-lightbox-control-btn-icon svg * {
                stroke: white;
            }
        }


        .peer:checked~.peer-checked\:bg-theme-500 {
            --tw-bg-opacity: 1;
            background-color: rgb(223 155 25);
        }

        .lg-outer .lg-item:before,
        .lg-outer .lg-img-wrap:before {
            content: "";
            display: inline-block;
            height: 100%;
            vertical-align: text-top !important;
        }

        .lg-outer .lg-item,
        .lg-outer .lg-img-wrap {
            text-align: left !important;
            width: 100%;
        }

        picture.lg-img-wrap {
            display: flex !important;
            justify-content: center;
        }

        /* #header-wr {
            min-height: 100vh;
        } */

        #header-wr .dropdown-item:focus,
        .dropdown-item:hover {
            color: #ffffff !important;
            background-color: #df9b19 !important;
        }

        body {
            font-family: "lato-bold" !important;
        }
    </style>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0QQTEYFCNM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-0QQTEYFCNM');
    </script>
</head>

<body>
    <div id="app">
        @include('layouts.header')
        <main class="py-4">
            @yield('content')
        </main>
        @detect
            <div class="bg-white bottom-0  position-fixed  px-3 rounded-2xl shadow-lg">
                <div class="flex">
                    <div class="flex-auto ">
                        <a href="#" class="text-center  mx-auto px-4 py-2  ">
                            <span class="block px-1 py-1">
                                <span class="bi bi-house"></span>
                                <span class="ml-3 text-sm align-bottom pb-1">Home</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex-auto ">
                        <a href="{{ route('public.shop') }}" class="text-center  mx-auto px-4 py-2  ">
                            <span class="block px-1 py-1">
                                <span class="bi bi-shop"></span>
                                <span class="ml-3 text-sm  align-bottom pb-1">Shop</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex-auto ">
                        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#Wishlist" aria-controls="Wishlist"
                            class="text-center wishlist-btn-view mx-auto px-4 py-2  ">
                            <span class="block px-1 py-1">
                                <span class="bi bi-heart"></span>
                                <span class="ml-3 text-sm  align-bottom pb-1">Wishlist</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex-auto ">
                        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#CartList" aria-controls="CartList"
                            class="text-center mx-auto px-4 py-2 cartList-btn-view ">
                            <span class="block px-1 py-1">
                                <span class="bi bi-cart-check"></span>
                                <span class="ml-3  text-sm  align-bottom pb-1">Cart</span>
                            </span>
                        </a>
                    </div>
                    <div class="flex-auto ">
                        <a href="{{ route('account.home') }}"
                            class="items-center justify-center text-center mx-auto px-4 py-2  ">
                            <span class="block px-1 py-1">
                                <span class="bi bi-person"></span>
                                <span class="ml-3 text-sm  align-bottom pb-1">Account</span>
                            </span>
                        </a>
                    </div>

                </div>
            </div>
        @enddetect
        <!-- Start Footer Area Wrapper -->
        <footer class="footer-wrapper">
            <!-- footer main area start -->
            <div class="footer-widget-area section-padding">
                <div class="container">
                    <div class="row mtn-40">
                        <!-- footer widget item start -->
                        <div class="col-xl-5 col-lg-3 col-md-6">
                            <div class="widget-item mt-10">
                                <h5 class="widget-title"> Contact Us</h5>
                                <div class="widget-body">
                                    <ul class="location-wrap">
                                        <li><i class="ion-ios-location-outline"></i>

                                            Soleful Ahdhia<br>
                                            #5, 1st floor, Geddalahalli,<br>
                                            Hennur Bagalur Main Road,<br>
                                            Bangalore - 560077.

                                        </li>
                                        <li><i class="ion-ios-email-outline"></i>Mail us: <a
                                                href="mailto:relationship@soleful.in">relationship@soleful.in</a>
                                        </li>
                                        <li><i class="ion-ios-telephone-outline"></i>Phone: <a
                                                href="tel:+917996666225">+91 79966 66225</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- footer widget item end -->

                        <!-- footer widget item start -->
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <div class="widget-item mt-10">
                                <h5 class="widget-title">Occasion</h5>
                                <div class="widget-body">
                                    <ul class="useful-link">
                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['categories[]' => 'Ethnic']) }}">Ethnic</a>
                                        </li>
                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['categories[]' => 'Casual']) }}">Casual</a>
                                        </li>

                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['categories[]' => 'Party']) }}">Party
                                            </a>
                                        </li>
                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['categories[]' => 'Formal']) }}">Formal</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- footer widget item end -->

                        <!-- footer widget item start -->
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <div class="widget-item mt-10">
                                <h5 class="widget-title">Information</h5>
                                <div class="widget-body">
                                    <ul class="useful-link">
                                        <li><a target="_blank" href="{{ url('T&C') }}">Terms and Conditions</a>
                                        </li>
                                        <li><a target="_blank" href="{{ url('refund_policy') }}">Refund Policy</a>
                                        </li>
                                        <li><a target="_blank" href="{{ url('return_policy') }}">Returns &
                                                Exchanges</a>
                                        </li>
                                        <li><a target="_blank" href="{{ url('shipping_policy') }}">Shipping &
                                                Delivery</a></li>
                                        <li><a target="_blank" href="{{ url('privacy_policy') }}">Privacy Policy</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- footer widget item end -->

                        <!-- footer widget item start -->
                        <div class="col-xl-2 col-lg-3 offset-xl-1 col-md-6">
                            <div class="widget-item mt-10">
                                <h5 class="widget-title">Quick Links</h5>
                                <div class="widget-body">
                                    <ul class="useful-link">

                                        <li><a target="_blank" href="{{ url('/account') }}">My Account</a></li>
                                        <li><a target="_blank" href="{{ url('/order-track') }}">Orders Tracking</a>
                                        </li>
                                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#sizeChart">Size
                                                Guide</a></li>

                                        <li><a target="_blank" href="{{ route('public.contact-us') }}">Contact Us</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- footer widget item end -->
                    </div>
                </div>
            </div>
            <!-- footer main area end -->

            <!-- footer bottom area start -->
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 order-2 order-md-1">
                            <div class="copyright-text text-center text-md-start">
                                <p>&copy; {{ date('Y') }} <b>Soleful Ahdhia</b> Made with <i
                                        class="fa fa-heart text-danger"></i> by <a target="_blank"
                                        href="https://whizcreativetech.com/"><b>Whiz Creative Tech</b></a></p>
                            </div>
                        </div>
                        <div class="col-md-6 order-1 order-md-2">
                            <div class="footer-social-link-1 flex justify-content-end gap-1 text-center text-md-end">
                                <a href="https://www.youtube.com/@Soleful.Ahdhia" target="_blank">
                                    <img src="{{ asset('assets/img/icon/Youtube.png') }}" class="w-50">
                                </a>
                                <a href="https://www.instagram.com/Soleful.ahdhia/" target="_blank">
                                    <img src="{{ asset('assets/img/icon/instagram.png') }}" class="w-50">
                                </a>
                                <a href="https://www.facebook.com/Soleful.Ahdhia/" target="_blank">
                                    <img src="{{ asset('assets/img/icon/Facebook.png') }}" class="w-50">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- footer bottom area end -->
        </footer>
        <!-- End Footer Area Wrapper -->


        <!-- Size Chart modal start -->
        <div class="modal" id="sizeChart">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close text-danger" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body ">
                        <img src="{{ asset('assets/img/size-chart.png') }}" class="w-100 mx-auto " />
                    </div>
                </div>
            </div>
        </div>
        <!-- Size Chart modal end -->



        <!-- Scroll to top start -->
        <div class="scroll-top not-visible mb-50">
            <i class="fa fa-angle-up"></i>
        </div>
        <!-- Scroll to Top End -->
    </div>


    <!-- Quick view modal start -->
    <div class="modal" id="quick_view">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body quickBody">
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="col-lg-12 rounded-5 h-75 bg-gray-100 ">
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="row gap-2 justify-center">
                                        <div class="col-3 rounded-5 h-10 bg-gray-100 ">
                                        </div>
                                        <div class="col-3 rounded-5 h-10 bg-gray-100 ">
                                        </div>
                                        <div class="col-3 rounded-5 h-10 bg-gray-100 ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                                <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                                <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                                <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                                <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick view modal end -->

    <div class="offcanvas offcanvas-end" id="Wishlist" aria-labelledby="WishlistLabel">
        <div class="offcanvas-header">
            <h5 id="WishlistLabel" class="fw-bold">Wishlist</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body wishlistBody">
            <div class="col-12 h-100 overflow-hidden">
                @include('frontend.partials.loader')
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" id="CartList" aria-labelledby="CartLabel">
        <div class="offcanvas-header">
            <h5 id="CartLabel" class="fw-bold">Cart</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body cartlistBody">
            <div class="col-12 h-100 overflow-hidden">
                @include('frontend.partials.loader')
            </div>
        </div>
    </div>



    <!--=== All Vendor Js ===-->
    <script src="/assets/js/vendor.js?v=1.2"></script>
    <!--=== All Plugins Js ===-->
    <script src="/assets/js/plugins.js?v=1.2"></script>
    <!--=== Active Js ===-->
    <script src="/assets/js/active.js?v=1.2"></script>



    <script>
        const toggleSearch = (search, button) => {
            const searchBar = document.getElementById(search),
                searchButton = document.getElementById(button),
                closeButton = searchBar.querySelector('.search__close'); // Close button

            searchButton.addEventListener('click', () => {
                // Toggle the show-search class to expand the search bar
                searchBar.classList.toggle('show-search');
            });

            closeButton.addEventListener('click', () => {
                // Close the search bar if close button is clicked
                searchBar.classList.remove('show-search');
            });
        };

        toggleSearch('search-bar', 'search-button');
    </script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.css') }}">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-bottom-center", // Toast position toast-top-right
            "timeOut": "5000", // Timeout duration
            "extendedTimeOut": "5000",
        };

        @if (session('success_msg'))
            toastr.success("{!! session('success_msg') !!}", "Success");
        @elseif (session('failed_msg'))
            toastr.error("{{ session('failed_msg') }}", "Error");
        @elseif (session('info'))
            toastr.info("{{ session('info') }}", "Info");
        @elseif (session('warning'))
            toastr.warning("{{ session('warning') }}", "Warning");
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}", "Error");
            @endforeach
        @endif
    </script>
    <!--=======================Javascript============================-->

    @stack('footer')

    <!-- LightGallery CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery/css/lightgallery.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightgallery@2.4.0-beta.0/css/lg-zoom.css">
    <!-- LightGallery JS (Latest) -->
    {{-- <script src="{{ asset('assets/plugins/lightgallery/lightgallery.umd.js?v=1') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/lightgallery/lightgallery.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightgallery/plugins/thumbnail/lg-thumbnail.umd.js"></script>
    <script src="{{ asset('assets/plugins/lightgallery/lg-zoom.umd.js') }}"></script>

    <script>
        var defaultSize = false;
        var choosedColor = '';
        $(document).ready(function() {
            let selectedSize = "{{ request()->get('size') }}";
            if (selectedSize) {
                $(".size-tab .size-button input[value='" + selectedSize + "']").prop("checked", true);
            } else {
                // Set first size button as checked by default
                $('.size-tab .size-button').not('.disabled').first().find('input[type="radio"]').prop('checked',
                    true);
            }

            // Function to handle active class toggle
            $('body').on('change', '.variSize_checkbox', function(e) {
                // Remove 'active' class from all labels
                $('.size-button').removeClass('active');

                // Add 'active' class to the parent label of the checked input
                if ($(this).is(':checked')) {
                    $(this).closest('.size-button').addClass('active');
                }
                var size = $(this).val();
                var product = $(this).data('product');

                // AJAX request for variation details
                $.ajax({
                    url: '/get-variation-details',
                    method: 'GET',
                    data: {
                        product_id: product,
                        size: size,
                    },
                    success: function(response) {
                        $('.color-tab').html(response);
                        let selectedColor = "{{ request()->get('color') }}";
                        // Set first color button as checked by default in the color-tab

                        if (choosedColor) {
                            $(".color-tab .color-button input[value='" + choosedColor + "']")
                                .prop("checked", true);
                        } else if (selectedColor) {
                            // Find the radio button with the matching value and check it
                            $(".color-tab .color-button input[value='" + selectedColor + "']")
                                .prop("checked", true);
                        } else {
                            // If no color is selected, check the first available color option
                            $(".color-tab .color-button input").first().prop("checked", true);
                        }


                        // Trigger change event on the first color option
                        $('.variColor_checkbox:checked').trigger('change');

                        if (!selectedSize && !defaultSize) {
                            $('.size-tab .size-button').not('.disabled').find(
                                'input[type="radio"]').prop('checked',
                                false);
                            $('.size-button').removeClass('active');

                            defaultSize = true;
                        }
                        // 
                        if (defaultSize && !QuickView) {
                            updateUrlWithSizeAndColor();
                        }

                    }
                });
            });

            // Trigger change event on the initially checked size radio input
            $('.variSize_checkbox:checked').trigger('change');

            var slideIndex = 0;
            // Function to handle color change
            $('body').on('change', '.variColor_checkbox', function(e) {
                // Remove 'active' class from all labels
                var colorButton = $(this).closest('.color-button'); // get the closest color button
                if (colorButton.length > 0) {
                    $('.color-button').removeClass('active');
                    colorButton.addClass('active');
                }

                choosedColor = $('.variColor_checkbox:checked').val();

                var color = $(this).val();
                var sku = $(this).data('sku');
                var price = $(this).data('price');
                var stock = $(this).data('stock');
                var pName = $(this).data('productname');
                var variation = $(this).data('variation');

                // Dynamically update SKU, price, and stock
                $('.productSku').text(sku);
                $('.regular-price').text(price);
                $('.stockStatus').text(stock);
                $('.product-title').text(pName);
                if (stock == 'in-stock') {
                    $('.add-to-cart').attr('id', 'addToCartBtn').removeAttr('disabled1'); // Set correct ID

                    $('.stockStatus').addClass('text-success').removeClass('text-danger');
                } else {
                    $('.add-to-cart').attr('id', 'inStock').attr('disabled1',
                        'disabled'); // Set different ID when out of stock
                    $('.stockStatus').addClass('text-danger').removeClass('text-success');
                }


                // Hide all previous images
                // $('.imgshowing').remove();

                var images = JSON.parse($(this).attr(
                    'data-image')); // Get the image array from the selected color
                var mainSlider = $('.product-large-slider'); // The main image slider container
                var thumbSlider = $('.pro-nav'); // The thumbnail slider container


                // Try to unslick existing sliders if initialized
                try {
                    if (mainSlider.hasClass('slick-initialized')) {
                        mainSlider.slick('unslick');
                    }

                    if (thumbSlider.hasClass('slick-initialized')) {
                        thumbSlider.slick('unslick');
                    }
                } catch (error) {
                    console.log('Error while unslicking: ', error);
                }


                // Initialize the product details slider

                mainSlider.slick({
                    infinite: false,
                    arrow: false,
                    dots: true,
                    // fade: true,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                    // asNavFor: '.pro-nav'
                });

                // // Initialize the thumbnail slider nav
                thumbSlider.slick({
                    infinite: false,
                    slidesToShow: 6,
                    vertical: true,
                    // verticalSwiping: false,
                    asNavFor: '.product-large-slider',
                    arrows: false,
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                    focusOnSelect: true
                });


                // Remove all slides dynamically using slickRemove
                // var totalSlides = mainSlider.slick('getSlick').slideCount;
                for (var i = slideIndex - 1; i >= 0; i--) {
                    mainSlider.slick('slickRemove', i);
                    thumbSlider.slick('slickRemove', i);
                }

                slideIndex = 0;


                // Clear the existing images in the main slider and the thumbnail slider
                mainSlider.html('');
                thumbSlider.html('');
                mainSlider.slick('refresh');
                thumbSlider.slick('refresh');

                // Add the new images to the main image slider dynamically
                $.each(images, function(index, image) {
                    // if (index < 2) {
                    slideIndex++;

                    mainSlider.slick('slickAdd', `
                        <div class="pro-large-img  imgshowing " >
                           
                                <img src="{{ asset('images/products/') }}/${image}"  data-src="{{ asset('images/products/') }}/${image}"
                                    onerror="this.onerror=null;this.src='/images/default.png';"
                                    alt="Product Image ${index + 1}">
                     
                        </div>
                    `);

                    // Add corresponding thumbnails to the thumbnail slider
                    thumbSlider.slick('slickAdd', `
                        <div class="pro-nav-thumb imgshowing">
                            <img src="{{ asset('images/products/') }}/${image}" 
                                onerror="this.onerror=null;this.src='/assets/images/dummy-product.jpg';"
                                alt="Thumbnail ${index + 1}" />
                        </div>
                    `);
                    // }
                });



                // Image zoom effect for the newly added images
                // if (defaultSize && !QuickView) {
                updateUrlWithSizeAndColor();

                // }

                var galleryElement = document.getElementById('lightgallery');

                // Debugging
                // console.log(typeof lightGallery); // Should NOT be "undefined"
                // console.log(galleryElement); // Should NOT be null

                // Destroy LightGallery if already initialized
                if (galleryElement.lg) {
                    galleryElement.lg.destroy(true);
                }

                // Initialize LightGallery
                lightGallery(galleryElement, {
                    selector: '.pro-large-img img',
                    download: false,
                    share: false,
                    plugins: [lgZoom],
                    mousewheel: true,
                    showZoomInOutIcons: true,
                    zoom: true, // Enable zoom
                    actualSize: false, // Show actual image size on double click
                    scale: 0.1, // Default scale level
                    enableZoomAfter: 100, // Delay zoom activation after opening
                    gestureZoom: false,
                    mobileSettings: {
                        controls: true,
                        showCloseIcon: true,
                        download: false,
                        rotate: false,
                        zoom: true,
                        gestureZoom: true,
                        showZoomInOutIcons: true,
                    }
                });

                $('#lightgallery').addClass('lg-initialized')

            });


            $('body').on('click', '#addToCartBtn', function(e) {
                // Get the selected color radio input
                const selectedColorInput = $('.variColor_checkbox:checked');

                // Check if a size is selected
                const selectedSizeInput = $('.variSize_checkbox:checked');

                if (!selectedSizeInput.length) {
                    toastr.error('Please select a size first', "Size not selected");
                    return; // Prevent further execution if no size is selected
                }


                if (!selectedColorInput.length) {
                    toastr.error('Please select a color', "Color not selected");
                    return;
                }

                // Extract data from the selected color and quantity input
                const color = selectedColorInput.val();
                const sku = selectedColorInput.data('sku');
                const variationId = selectedColorInput.data('variation');
                const price = selectedColorInput.data('price');
                const productName = selectedColorInput.data('productname');
                const stockStatus = selectedColorInput.data('stock');
                const quantity = $('#quantity').val();

                // Send the data via AJAX
                $.ajax({
                    url: '/add-to-cart',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        color: color,
                        sku: sku,
                        variation_id: variationId,
                        price: price,
                        product_name: productName,
                        stock_status: stockStatus,
                        quantity: quantity,
                    },
                    success: function(response) {

                        if (response.result) {
                            toastr.success(response.message, "Success");

                        } else {
                            toastr.error(response.message, "Error");

                        }
                        $('.cart-count').text(response.cart_count)
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });


            $('body').on('click', 'button#inStock', function(e) {

                toastr.error('This Product Out of Stock, please try later', "Out of Stock");

            });



            $('body').on('click', '.delete-btn', async function() {

                var item = $(this).closest('.cart-item');
                var quantity = $(this).val();
                var product_sku = $(this).data('psku');
                var product_id = $(this).data('pid');
                var product_price = $(this).data('price');
                var preorder = $(this).data('preorder')

                item.remove();
                await $.ajax({
                    url: `{{ route('public.product-add') }}`,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        'product_sku': product_sku,
                        'product_id': product_id,
                        'quantity': 0,
                        'price': product_price
                    },
                    success: function(response) {
                        location.reload();

                    },
                    error: function(xhr, status, error) {

                        alertJsFunction(status, 'error');
                        //  alert('something went wrong please try again')
                        // body.find('.product-loading').remove();
                    }
                });
                location.reload();

            })


            // Function to update the URL with selected size and color
            function updateUrlWithSizeAndColor() {
                let selectedSize = $('.variSize_checkbox:checked').val();
                let selectedColor = $('.variColor_checkbox:checked').val();
                choosedColor = selectedColor;

                // Construct the base URL (without parameters)
                let baseUrl = window.location.origin + window.location.pathname;

                // If a size is selected, add it to the URL
                if (selectedSize) {
                    baseUrl += "?size=" + selectedSize;
                }

                // If a color is selected, add it to the URL (appending & if size already exists)
                if (selectedColor) {
                    baseUrl += (selectedSize ? "&" : "?") + "color=" + selectedColor;
                }
                // Update the browser URL without reloading the page
                window.history.pushState({}, "", baseUrl);
            }

        });
    </script>
<style>
      @media (min-width: 768px) {
            body {
                font-family: "lato-bold" !important;
            }
        }
</style>
</body>

</html>
