
<!-- Start Header Area -->
<header class="header-area">
    <div class="container bg-white rounded-5">
        <div class="row">
            <div class="col-12 header-first-col shadow" style="position: relative;">
                <div class="first-li-div position-relative">
                    <ul class="first-ul d-flex justify-between">
                        <li>
                            <a class="mobile-menu" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                                aria-controls="offcanvasExample">
                                <i class="bi bi-filter-left"></i>
                            </a>
                            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                                aria-labelledby="offcanvasExampleLabel">
                                <div class="offcanvas-header">
                                    <img src="{{ url('assets/img/logo/logo.png') }}" class="w-20" />
                                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                    @guest
                                        @if (Route::has('login'))
                                            <a href="{{ route('login') }}" class="offcanvas-title mx-3"
                                                id="offcanvasExampleLabel">
                                                Sign In
                                            </a>
                                        @else
                                        @endif
                                    @endguest
                                </div>

                                <div class="offcanvas-body">
                                    <div class="for-sup">
                                        <div class="f-msp">
                                            <ul id="header-wr" class="menu">

                                                <li class="mb-2">
                                                    <a class="dropdown-item" href="/">Home</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('public.shop') }}">Shop</a>
                                                </li>
                                                <hr class="border-2 mb-2" />
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('public.shop', ['shoe_type[]' => 'Casual Slides']) }}">Casual
                                                        Slides</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('public.shop', ['shoe_type[]' => 'Ethnic Slides']) }}">Ethnic
                                                        Slides</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('public.shop', ['shoe_type[]' => 'Casual Slipons']) }}">Casual
                                                        Slipons</a>
                                                </li>

                                                <li class="mb-2">
                                                    <a class="dropdown-item" ttarget="_blank"
                                                        href="{{ route('public.shop', ['categories[]' => 'Party Wear']) }}">Party
                                                        Wear</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('public.shop', ['categories[]' => 'Casual Wear']) }}">Casual
                                                        Wear</a>
                                                </li>
                                                <hr class="border-2 mb-2" />
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('t-c') }}">Terms and Conditions</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('refund_policy') }}">Refund Policy</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('return_policy') }}">Returns & Exchanges</a>
                                                </li>

                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('shipping_policy') }}">Shipping & Delivery</a>
                                                </li>
                                                <li class="mb-2">
                                                    <a class="dropdown-item" target="_blank"
                                                        href="{{ route('privacy_policy') }}">Privacy Policy</a>
                                                </li>

                                            </ul>

                                        </div>


                                    </div>
                                    <div class="social-links">
                                        <div class="footer-social-link text-center text-md-end">
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-twitter"></i></a>
                                            <a href="#"><i class="fa fa-linkedin"></i></a>
                                            <a href="#"><i class="fa fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="logo">
                                <a href="/">
                                    <img src="{{ url('assets/img/logo/logo.png') }}" alt="">
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="px-4">
                    <ul class="d-flex gap-4 align-items-end align-content-end m-1">
                        <li class="position-relative">
                            <div class="search" id="search-bar" x-data="{
                                placeholders: ['Type something...','Just type if you want Shoe type', 'Just type if you want Category', 'Just type if you want Color', 'Just type if you want Size', 'Just type if you want Product name'],
                                currentIndex: 0,
                                init() {
                                    this.cyclePlaceholders();
                                },
                                cyclePlaceholders() {
                                    setInterval(() => {
                                        this.$refs.inputElement.placeholder = this.placeholders[this.currentIndex];
                                        this.currentIndex = (this.currentIndex + 1) % this.placeholders.length;
                                    }, 2000); // Change placeholder every 2 seconds
                                }
                            }"
                            x-init="init()">
                                <input type="text" x-ref="inputElement"  autocomplete="off" placeholder="Type something..." name="q"
                                    class="search__input" id="search-input">
                                <div class="search__button" id="search-button">
                                    <i class="ri-search-2-line bi bi-search text-theme"></i>
                                    <i class="ri-close-line bi bi-x"></i>
                                </div>
                            </div>
                            <div class="bg-light shadow-lg position-absolute rounded-2xl w-100">
                                <ul id="suggestions-ul-search"
                                    class="list-none p-0 m-0 max-h-75 overflow-auto rounded-2xl">
                                </ul>
                            </div>
                        </li>
                        <li class="cursor-pointer d-none d-md-block ">
                            <a href="{{ route('public.shop') }}" class="btn btn-theme btn-sm rounded-5 fw-bold">Order
                                Now</a>
                        </li>
                        <li class="cursor-pointer d-none d-md-block">
                            <a href="{{ route('account.orders.show') }}" class="btn btn-theme btn-sm rounded-5 fw-bold">Track Order</a>
                        </li>
                        <li class="d-none d-md-block">
                            <a href="#" id="cartList-btn-view" data-bs-toggle="offcanvas"
                                data-bs-target="#CartList" aria-controls="CartList">
                                <div class="cart-icon text-center text-theme">
                                    <i class="bi bi-cart fs-5 fw-bold"></i>
                                    <span class="cart-count absolute count-rounded">{{ basketItems() }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="me-0 ms-2 wishlist-section " style="display: none">
                            <a href="#" class="d-inline d-none d-md-block" id="wishlist-btn-view" data-bs-toggle="offcanvas"
                                data-bs-target="#Wishlist" aria-controls="Wishlist">
                                <div class="cart-icon text-center text-theme relative">
                                    <i class="bi bi-heart-fill fs-5"></i>
                                    <span style="top: -15px;" class="wishlist-count absolute count-rounded">0</span>
                                </div>
                            </a>
                        </li>
                        {{-- <li class="d-md-none d-flex me-0 ms-2">
                            <a href="/cart" class="d-md-none d-inline">
                                <div class="cart-icon text-theme">
                                    <i class="bi bi-cart fs-5"></i>
                                    <span class="cart-count">0</span>
                                </div>
                            </a>
                        </li> --}}
                        @guest
                            @if (Route::has('login'))
                                <li class="last-one d-none d-md-block">
                                    <a href="{{ route('login') }}">
                                        <i class="bi bi-person fs-5 text-theme"></i>
                                    </a>
                                </li>
                            @endif
                        @endguest
                        @auth
                            <li class="last-one d-none d-md-block" x-data="{ open: false }" @click.away="open = false">
                                <a href="#" @click="open = !open">
                                    <i class="bi bi-person fs-5 text-theme"></i>
                                </a>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="dropdown-menu show"
                                    style="width: auto; padding: 10px; position: absolute; z-index: 1000;">
                                    @if (auth()->user()->type == 'superadmin')
                                        <a class="dropdown-item float-start fs-6 fw-medium text-theme"
                                            href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-person"></i> Dashboard
                                        </a>
                                    @else
                                        <a class="dropdown-item float-start fs-6 fw-medium text-theme" href="{{ route('account.home') }}">
                                            <i class="bi bi-person"></i> My Account
                                        </a>
                                    @endif
                                    <form action="{{ route('logout') }}" id="logout-form" method="POST">
                                        @method('POST') @csrf </form>
                                    <button type="submit" form="logout-form"
                                        class="dropdown-item float-start fs-6 fw-medium">
                                        <i class="bi bi-box-arrow-in-left"></i>
                                        Log Out
                                    </button>

                                </div>
                            </li>
                        @endauth


                        <li class="d-none d-md-block">
                            <a href="tel:+917996666225" class="text-theme" title="+91 79966 66225">
                                <i class="bi bi-telephone-outbound fs-5" style="font-size: 19px;"></i>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>


        </div>
    </div>
   
</header>
<!-- end Header Area -->


@push('footer')
    <script>
        $(document).ready(function() {
            $('body').on('input','#search-input', function() {
                const $suggestionList = $('#suggestions-ul-search');
                const query = $(this).val();
                if (query.length >= 2) {
                    // Perform AJAX request
                    $.ajax({
                        url: `/search`,
                        method: 'GET',
                        data: {
                            q: query
                        },
                        success: function(data) {
                           
                            $suggestionList.empty(); // Clear existing suggestions

                            $suggestionList.html(data)
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching search results:', error);
                        }
                    });
                }
                else{
                    $suggestionList.empty();
                }
            });

            $('body').on('click','.ri-close-line,.ri-search-2-line', function() {
                $('#suggestions-ul-search').empty(); 
                $('.search-input').val(''); 
            });

        });
    </script>
      
@endpush
