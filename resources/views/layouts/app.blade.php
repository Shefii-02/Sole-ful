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
    <link rel="icon" type="image/x-icon" href="/assets/img/logo/logo.png">
    {{-- <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" /> --}}
    <!--=== All Plugins CSS ===-->
    <link href="/assets/css/plugins.css" rel="stylesheet">
    <!--=== All Vendor CSS ===-->
    <link href="/assets/css/vendor.css" rel="stylesheet">
    <!--=== Main Style CSS ===-->
    <link href="/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta http-equiv="refresh" content="1800">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('header')

    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=678d3d239b23f500127153b0&product=inline-share-buttons&source=platform"
        async="async"></script>
    <style>
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
    </style>
</head>

<body>
    <div id="app">
        @include('layouts.header')
        <main class="py-4">
            @yield('content')
        </main>

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
                                            <a href="https://maps.app.goo.gl/MtY4isgHncwS6jfB8" target="_blank">
                                                SOLEFUL<br>
                                                #5, 1st floor, Geddalahalli,<br>
                                                Hennur Bagalur Main Road,<br>
                                                Bangalore - 560077.
                                            </a>
                                        </li>
                                        <li><i class="ion-ios-email-outline"></i>Mail Us: <a
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
                                <h5 class="widget-title">Pages</h5>
                                <div class="widget-body">
                                    <ul class="useful-link">
                                        <li class="mb-3">
                                            <a target="_blank" href="{{ route('public.shop') }}">Shop</a>
                                        </li>
                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['shoe_type[]' => 'Casual Slides']) }}">Casual
                                                Slides</a>
                                        </li>
                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['shoe_type[]' => 'Ethnic Slides']) }}">Ethnic
                                                Slides</a>
                                        </li>
                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['shoe_type[]' => 'Casual Slipons']) }}">Casual
                                                Slipons</a>
                                        </li>
                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['categories[]' => 'Party Wear']) }}">Party
                                                Wear</a>
                                        </li>
                                        <li class="mb-3">
                                            <a target="_blank"
                                                href="{{ route('public.shop', ['categories[]' => 'Casual Wear']) }}">Casual
                                                Wear</a>
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
                                        <li><a target="_blank" href="{{ url('/') }}">Home</a></li>
                                        <li><a target="_blank" href="{{ url('T&C') }}">Terms and Conditions</a></li>
                                        <li><a target="_blank" href="{{ url('refund_policy') }}">Refund Policy</a></li>
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
                                <p>&copy; {{ date('Y') }} <b>Soleful</b> Made with <i
                                        class="fa fa-heart text-danger"></i> by <a target="_blank"
                                        href="https://whizcreativetech.com/"><b>Whiz Creative Tech</b></a></p>
                            </div>
                        </div>
                        <div class="col-md-6 order-1 order-md-2">
                            <div class="footer-social-link text-center text-md-end">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
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
        <div class="scroll-top not-visible">
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
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100 ">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                            <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                            <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100 ">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                            <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                            <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100 ">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                            <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                            <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                            <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                            <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100  ">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-8">
                                <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                                <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                                <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="col-lg-12 rounded-5 h-100 bg-gray-100  ">

                                </div>
                            </div>
                            <div class="col-8">
                                <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                                <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                                <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="col-lg-12 rounded-5 h-100 bg-gray-100 ">

                                </div>
                            </div>
                            <div class="col-8">
                                <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                                <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                                <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="col-lg-12 rounded-5 h-100 bg-gray-100  ">

                                </div>
                            </div>
                            <div class="col-8">
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

    <div class="offcanvas offcanvas-end" id="CartList" aria-labelledby="CartLabel">
        <div class="offcanvas-header">
            <h5 id="CartLabel" class="fw-bold">Cart</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body cartlistBody">
            <div class="col-12 h-100 overflow-hidden">
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100 ">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                            <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                            <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100 ">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                            <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                            <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100 ">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                            <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                            <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                            <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                            <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <div class="row">
                        <div class="col-4">
                            <div class="col-lg-12 rounded-5 h-100 bg-gray-100  ">

                            </div>
                        </div>
                        <div class="col-8">
                            <div class="col-8">
                                <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                                <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                                <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="col-lg-12 rounded-5 h-100 bg-gray-100  ">

                                </div>
                            </div>
                            <div class="col-8">
                                <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                                <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                                <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="col-lg-12 rounded-5 h-100 bg-gray-100 ">

                                </div>
                            </div>
                            <div class="col-8">
                                <div class="col-12 h-5 mb-2 bg-gray-100  text-light shimmer-bar"></div>
                                <div class="col-11 h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                                <div class="col-10 h-5 mb-2 bg-gray-100 shimmer-bar text-light"></div>
                                <div class="col-11  h-5 mb-2 bg-gray-100  text-light shimmer-bar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="row">
                            <div class="col-4">
                                <div class="col-lg-12 rounded-5 h-100 bg-gray-100  ">

                                </div>
                            </div>
                            <div class="col-8">
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

    <!--=======================Javascript============================-->
    <!--=== All Vendor Js ===-->
    <script src="/assets/js/vendor.js"></script>
    <!--=== All Plugins Js ===-->
    <script src="/assets/js/plugins.js"></script>
    <!--=== Active Js ===-->
    <script src="/assets/js/active.js"></script>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right", // Toast position
            "timeOut": "5000", // Timeout duration
            "extendedTimeOut": "5000",
        };
    </script>
    <script type="text/javascript">
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right", // Toast position
            "timeOut": "5000", // Timeout duration
            "extendedTimeOut": "5000",
        };

        @if (session('success_msg'))
            toastr.success("{{ session('success_msg') }}", "Success");
        @elseif (session('failed_msg'))
            toastr.error("{{ session('failed_msg') }}", "Error");
        @elseif (session('info'))
            toastr.info("{{ session('info') }}", "Info");
        @elseif (session('warning'))
            toastr.warning("{{ session('warning') }}", "Warning");
        @endif
    </script>

    @stack('footer')
    <script>
        $(document).ready(function() {
            // Set first size button as checked by default
            $('.size-tab .size-button').not('.disabled').first().find('input[type="radio"]').prop('checked', true);

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

                        // Set first color button as checked by default in the color-tab
                        $('.color-tab .color-button').not('.disabled').first().find(
                            'input[type="radio"]').prop('checked', true);
                        // Trigger change event on the first color option
                        $('.variColor_checkbox:checked').trigger('change');
                    }
                });
            });

            // Trigger change event on the initially checked size radio input
            $('.variSize_checkbox:checked').trigger('change');


            // Function to handle color change
            $('body').on('change', '.variColor_checkbox', function(e) {
                // Remove 'active' class from all labels
                var colorButton = $(this).closest('.color-button'); // get the closest color button
                if (colorButton.length > 0) {
                    $('.color-button').removeClass('active');
                    colorButton.addClass('active');
                }

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
                    $('.stockStatus').addClass('text-success').removeClass('text-danger');
                } else {
                    $('.stockStatus').addClass('text-danger').removeClass('text-success');
                }

                // Hide all previous images
                $('.imgshowing').hide();

                var images = JSON.parse($(this).attr(
                    'data-image')); // Get the image array from the selected color
                var mainSlider = $('.product-large-slider'); // The main image slider container
                var thumbSlider = $('.pro-nav'); // The thumbnail slider container

                // Clear the existing images in the main slider and the thumbnail slider
                mainSlider.empty();
                thumbSlider.empty();


                // Add the new images to the main image slider dynamically
                $.each(images, function(index, image) {
                    mainSlider.append(`
                        <div class="pro-large-img img-zoom imgshowing">
                            <img src="{{ asset('images/products/') }}/${image}" 
                                onerror="this.onerror=null;this.src='/images/default.png';"
                                alt="Product Image ${index + 1}">
                        </div>
                    `);

                    // Add corresponding thumbnails to the thumbnail slider
                    thumbSlider.append(`
                        <div class="pro-nav-thumb imgshowing">
                            <img src="{{ asset('images/products/') }}/${image}" 
                                onerror="this.onerror=null;this.src='/assets/images/dummy-product.jpg';"
                                alt="Thumbnail ${index + 1}" />
                        </div>
                    `);
                });


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
                    fade: true,
                    arrows: false,
                    asNavFor: '.pro-nav'
                });

                // Initialize the thumbnail slider nav
                thumbSlider.slick({
                    slidesToShow: 4,
                    asNavFor: '.product-large-slider',
                    arrows: false,
                    focusOnSelect: true
                });

                // Image zoom effect for the newly added images
                $('.img-zoom').zoom();
            });


            $('body').on('click', '#addToCartBtn', function(e) {
                // Get the selected color radio input
                const selectedColorInput = $('.variColor_checkbox:checked');

                if (!selectedColorInput.length) {
                    alert('Please select a color.');
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
                            toastr.success(response.message, "Error");

                        }
                        $('.cart-count').text(response.cart_count)
                    },
                    error: function() {
                        alert('An error occurred. Please try again.');
                    }
                });
            });
        });
    </script>
</body>

</html>
