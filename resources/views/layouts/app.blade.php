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
    <script src="//unpkg.com/alpinejs" defer></script>


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    @stack('header')
    <style>
        /* Ensure the search bar is positioned correctly */
        .search {
            position: relative;
            width: 40px;
            height: 40px;

            box-shadow: 0 4px 24px hsla(222, 68%, 12%, 0.1);
            border-radius: 4rem;
            padding: 10px;
            overflow: hidden;
            transition: width 0.5s cubic-bezier(0.9, 0, 0.3, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Input styling */
        .search__input {
            border: none;
            outline: none;
            width: 100%;
            /* Full width within the container */
            height: 100%;
            border-radius: 4rem;
            padding-left: 14px;
            font-family: var(--body-font);
            font-size: var(--small-font-size);
            font-weight: 500;
            opacity: 0;
            pointer-events: none;
            transition: opacity 1.5s;
        }

        /* Search button styling */
        .search__button {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            position: absolute;
            top: 0;
            bottom: 0;
            right: 10px;
            margin: auto;
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: transform 0.6s cubic-bezier(0.9, 0, 0.3, 0.9);
        }

        .search__icon,
        .search__close {
            color: var(--white-color);
            font-size: 1.5rem;
            position: absolute;
            transition: opacity 0.5s cubic-bezier(0.9, 0, 0.3, 0.9);
        }

        .search__close {
            opacity: 0;
            /* Hidden by default */
        }

        /* When search bar expands */
        .show-search {
            width: 100%;
        }

        .show-search .search__input {
            opacity: 1;
            pointer-events: initial;
        }

        .show-search .search__button {
            transform: rotate(90deg);
        }

        .show-search .search__icon {
            opacity: 0;
        }

        .show-search .search__close {
            opacity: 1;
        }

        /*=============== BREAKPOINTS ===============*/
        @media screen and (min-width: 576px) {
            .show-search {
                width: 450px;
                /* Larger width for medium screens */
            }
        }
    </style>

</head>

<body>
    <div id="app">
        @include('layouts.header')
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

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
                            <div class="widget-item mt-40">
                                <h5 class="widget-title">My Account</h5>
                                <div class="widget-body">
                                    <ul class="location-wrap">
                                        <li><i class="ion-ios-location-outline"></i>184 Main Rd E, St Albans VIC 3021,
                                            Australia</li>
                                        <li><i class="ion-ios-email-outline"></i>Mail Us: <a
                                                href="mailto:yourmail@gmail.com">yourmail@gmail.com</a></li>
                                        <li><i class="ion-ios-telephone-outline"></i>Phone: <a
                                                href="%2b0025425456554.html">+ 00 254 254565</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- footer widget item end -->

                        <!-- footer widget item start -->
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <div class="widget-item mt-40">
                                <h5 class="widget-title">Categories</h5>
                                <div class="widget-body">
                                    <ul class="useful-link">
                                        <li><a href="#">Ecommerce</a></li>
                                        <li><a href="#">Shopify</a></li>
                                        <li><a href="#">Prestashop</a></li>
                                        <li><a href="#">Opencart</a></li>
                                        <li><a href="#">Magento</a></li>
                                        <li><a href="#">Jigoshop</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- footer widget item end -->

                        <!-- footer widget item start -->
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <div class="widget-item mt-40">
                                <h5 class="widget-title">Information</h5>
                                <div class="widget-body">
                                    <ul class="useful-link">
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">About Us</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                        <li><a href="#">Returns & Exchanges</a></li>
                                        <li><a href="#">Shipping & Delivery</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- footer widget item end -->

                        <!-- footer widget item start -->
                        <div class="col-xl-2 col-lg-3 offset-xl-1 col-md-6">
                            <div class="widget-item mt-40">
                                <h5 class="widget-title">Quick Links</h5>
                                <div class="widget-body">
                                    <ul class="useful-link">
                                        <li><a href="#">Store Location</a></li>
                                        <li><a href="#">My Account</a></li>
                                        <li><a href="#">Orders Tracking</a></li>
                                        <li><a href="#">Size Guide</a></li>
                                        <li><a href="#">Shopping Rates</a></li>
                                        <li><a href="#">Contact Us</a></li>
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
                                <p>&copy; 2022 <b>Juan</b> Made with <i class="fa fa-heart text-danger"></i> by <a
                                        href="https://hasthemes.com/"><b>HasThemes</b></a></p>
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

        <!-- offcanvas search form start -->
        <div class="offcanvas-search-wrapper">
            <div class="offcanvas-search-inner">
                <div class="offcanvas-close">
                    <i class="ion-android-close"></i>
                </div>
                <div class="container">
                    <div class="offcanvas-search-box">
                        <form class="d-flex bdr-bottom w-100">
                            <input type="text" placeholder="Search entire storage here...">
                            <button class="search-btn"><i class="ion-ios-search-strong"></i>search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- offcanvas search form end -->

        <!-- offcanvas mini cart start -->
        <div class="offcanvas-minicart-wrapper">
            <div class="minicart-inner">
                <div class="offcanvas-overlay"></div>
                <div class="minicart-inner-content">
                    <div class="minicart-close">
                        <i class="ion-android-close"></i>
                    </div>
                    <div class="minicart-content-box">
                        <div class="minicart-item-wrapper">
                            <ul>
                                <li class="minicart-item">
                                    <div class="minicart-thumb">
                                        <a href="product-details.html">
                                            <img src="assets/img/cart/cart-1.jpg" alt="product">
                                        </a>
                                    </div>
                                    <div class="minicart-content">
                                        <h3 class="product-name">
                                            <a href="product-details.html">Flowers bouquet pink for all flower
                                                lovers</a>
                                        </h3>
                                        <p>
                                            <span class="cart-quantity">1 <strong>&times;</strong></span>
                                            <span class="cart-price">$100.00</span>
                                        </p>
                                    </div>
                                    <button class="minicart-remove"><i class="ion-android-close"></i></button>
                                </li>
                                <li class="minicart-item">
                                    <div class="minicart-thumb">
                                        <a href="product-details.html">
                                            <img src="assets/img/cart/cart-2.jpg" alt="product">
                                        </a>
                                    </div>
                                    <div class="minicart-content">
                                        <h3 class="product-name">
                                            <a href="product-details.html">Jasmine flowers white for all flower
                                                lovers</a>
                                        </h3>
                                        <p>
                                            <span class="cart-quantity">1 <strong>&times;</strong></span>
                                            <span class="cart-price">$80.00</span>
                                        </p>
                                    </div>
                                    <button class="minicart-remove"><i class="ion-android-close"></i></button>
                                </li>
                            </ul>
                        </div>

                        <div class="minicart-pricing-box">
                            <ul>
                                <li>
                                    <span>sub-total</span>
                                    <span><strong>$300.00</strong></span>
                                </li>
                                <li>
                                    <span>Eco Tax (-2.00)</span>
                                    <span><strong>$10.00</strong></span>
                                </li>
                                <li>
                                    <span>VAT (20%)</span>
                                    <span><strong>$60.00</strong></span>
                                </li>
                                <li class="total">
                                    <span>total</span>
                                    <span><strong>$370.00</strong></span>
                                </li>
                            </ul>
                        </div>

                        <div class="minicart-button">
                            <a href="cart.html"><i class="fa fa-shopping-cart"></i> view cart</a>
                            <a href="cart.html"><i class="fa fa-share"></i> checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- offcanvas mini cart end -->

        <!-- Scroll to top start -->
        <div class="scroll-top not-visible">
            <i class="fa fa-angle-up"></i>
        </div>
        <!-- Scroll to Top End -->

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

</body>

</html>
