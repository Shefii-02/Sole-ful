@extends('layouts.app')
@section('content')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area bg-img pt-12" data-bg="assets/img/breadcrumb-banner.webp">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <nav aria-label="breadcrumb">
                            <h1 class="breadcrumb-title">shop</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">shop</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding">
        <div class="container">
            <div class="row">
                <!-- sidebar area start -->
                <div class="col-lg-3 order-2 order-lg-1">
                    <div class="sidebar-wrapper">
                        <!-- single sidebar start -->
                        <div class="sidebar-single">
                            <div class="sidebar-title">
                                <h3 class="text-theme">Categories</h3>
                            </div>
                            <div class="sidebar-body">
                                <ul class="color-list">

                                    @foreach ($categories ?? [] as $item)
                                        <li role="button" class="d-flex justify-between">
                                            <label for="{{ 'category-' . $item->id }}">

                                                <span class="text-capitalize">{{ $item->name }}
                                                    <span>({{ $item->products_count }})</span></span></label>
                                            <input
                                                {{ in_array(trim($item->name), request()->categories ?? []) ? 'checked' : '' }}
                                                form="filter" type="checkbox" name="categories[]"
                                                value="{{ trim($item->name) }}" class="checkbox"
                                                id="{{ 'category-' . $item->id }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- single sidebar end -->
                        <!-- single sidebar start -->
                        <div class="sidebar-single">
                            <div class="sidebar-title">
                                <h3 class="text-theme">Shoe Type</h3>
                            </div>
                            <div class="sidebar-body">
                                <ul class="color-list">
                                    <li role="button" class="d-flex justify-between">
                                        <label for="CasualSlides"><span class="text-capitalize">Casual Slides</span></label>
                                        <input
                                            {{ in_array(trim('Casual Slides'), request()->shoe_type ?? []) ? 'checked' : '' }}
                                            form="filter" type="checkbox" name="shoe_type[]"
                                            value="Casual Slides" class="checkbox"
                                            id="CasualSlides">
                                    </li>
                                    <li role="button" class="d-flex justify-between">
                                        <label for="EthnicSlides">
                                            <span class="text-capitalize">Ethnic Slides</span></label>
                                        <input
                                            {{ in_array(trim('Ethnic Slides'), request()->shoe_type ?? []) ? 'checked' : '' }}
                                            form="filter" type="checkbox" name="shoe_type[]"
                                            value="{{ trim('Ethnic Slides') }}" class="checkbox"
                                            id="EthnicSlides">
                                    </li>
                                    <li role="button" class="d-flex justify-between">
                                        <label for="CasualSlipons">

                                            <span class="text-capitalize">{{ $item->name }}</label>
                                        <input {{ in_array(trim('Casual Slipons'), request()->shoe_type ?? []) ? 'checked' : '' }}
                                            form="filter" type="checkbox" name="shoe_type[]"
                                            value="Casual Slipons" class="checkbox"
                                            id="CasualSlipons">
                                    </li>
                             
                                </ul>
                            </div>
                        </div>
                        <!-- single sidebar end -->

                        <!-- single sidebar start -->
                        <div class="sidebar-single">
                            <div class="sidebar-title">
                                <h3>Filter by Price</h3>
                            </div>
                            <div class="sidebar-body">
                                <div class="price-range-wrap">
                                    <div class="price-range" data-min="500" data-max="5000"></div>
                                    <div class="range-slider">
                                        <form action="" id="filter"> </form>
                                        <div class="price-input">
                                            <label for="amount">Price: </label>
                                            <input type="text" id="amount" name="amount"
                                                value="{{ request('amount') }}">
                                            <input form="filter" type="hidden" id="minAmount" name="price_min"
                                                value="{{ request('price_min') ?? '500' }}">
                                            <input form="filter" type="hidden" id="maxAmount" name="price_max"
                                                value="{{ request('price_max') ?? '5000' }}">
                                        </div>
                                        <button form="filter" class="filter-btn">Filter</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- single sidebar end -->

                        <!-- single sidebar start -->
                        <div class="sidebar-single">
                            <div class="sidebar-title">
                                <h3>Available Colors</h3>
                            </div>
                            <div class="sidebar-body">
                                <ul class="color-list">
                                    @foreach ($available_colors->unique('value') ?? [] as $key => $color)
                                        <li role="button" class="d-flex justify-between">
                                            <label for="{{ 'color-' . $key }}">
                                                <span class="text-capitalize">{{ $color->value }}
                                                    <span>({{ $color->product_count }})</span></span></label>
                                            <input {{ in_array($color->value, request()->colors ?? []) ? 'checked' : '' }}
                                                form="filter" type="checkbox" name="colors[]" value="{{ $color->value }}"
                                                class="checkbox" id="{{ 'color-' . $key }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- single sidebar end -->

                        <!-- single sidebar start -->
                        <div class="sidebar-single">
                            <div class="sidebar-title">
                                <h3>Size</h3>
                            </div>
                            <div class="sidebar-body">
                                <ul class="size-list">

                                    @foreach ($available_sizes->unique('value') ?? [] as $key => $size)
                                        <li role="button" class="d-flex justify-between">
                                            <label for="{{ 'size-' . $key }}">
                                                <span class="text-capitalize">{{ $size->value }}
                                                    <span>({{ $size->product_count }})</span></span></label>
                                            <input {{ in_array($size->value, request()->sizes ?? []) ? 'checked' : '' }}
                                                form="filter" type="checkbox" name="sizes[]" value="{{ $size->value }}"
                                                class="checkbox" id="{{ 'size-' . $key }}">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <!-- single sidebar end -->

                        <!-- single sidebar start -->
                        <div class="sidebar-single">
                            <div class="sidebar-banner">
                                @if($productOffer)
                                <a href="{{ $productOffer->redirection }}" target="_blank">
                                    <img src="{{ asset('images/' . $productOffer->image) }}" alt="product banner">
                                </a>
                                @endif
                            </div>
                        </div>
                        <!-- single sidebar end -->
                    </div>

                </div>
                <!-- sidebar area end -->

                <!-- shop main wrapper start -->
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="shop-product-wrapper">
                        <!-- shop product top wrap start -->
                        <div class="shop-top-bar">
                            <div class="row">
                                <div class="col-xl-5 col-lg-4 col-md-3 order-2 order-md-1">
                                    <div class="top-bar-left">
                                        <div class="product-view-mode">
                                            <a class="active" href="#" data-target="grid-view"><i
                                                    class="fa fa-th"></i></a>
                                            <a href="#" data-target="list-view"><i class="fa fa-list"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- shop product top wrap start -->

                        <!-- product item list start -->
                        <div class="shop-product-wrap grid-view row mbn-50">

                            @include('frontend.product_list', compact('products'))

                        </div>
                        <!-- product item list end -->

                    </div>
                </div>
                <!-- shop main wrapper end -->
            </div>
        </div>
    </div>
    <!-- page main wrapper end -->
@endsection


@push('footer')
    <script>
        // pricing filter
        var rangeSlider = $(".price-range"),
            amount = $("#amount"),
            minAmount = $("#minAmount"),
            maxAmount = $("#maxAmount"),
            minPrice = rangeSlider.data('min'),
            maxPrice = rangeSlider.data('max'),
            defaultMin = "{{ request('price_min', 500) }}",
            defaultMax = "{{ request('price_max', 5000) }}";
        rangeSlider.slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [defaultMin, defaultMax],
            slide: function(event, ui) {
                amount.val("₹" + ui.values[0] + " - ₹" + ui.values[1]);
                minAmount.val(ui.values[0])
                maxAmount.val(ui.values[1]);
            }
        });
        amount.val(" ₹" + rangeSlider.slider("values", 0) +
            " - ₹" + rangeSlider.slider("values", 1));
    </script>

    <script>
        $(document).ready(function() {
            const filterForm = $('#filter');
            const productContainer = $('.shop-product-wrap');

            // Function to fetch filtered products
            function fetchFilteredProducts(event) {
                event.preventDefault();

                // Serialize form data
                const queryString = filterForm.serialize();

                history.pushState({}, '', `{{ route('public.shop') }}?${queryString}`);


                // AJAX request
                $.ajax({
                    url: '{{ route('public.shop') }}', // Replace with your actual route
                    method: 'GET',
                    data: queryString,
                    success: function(response) {
                        // if (response.html) {
                        productContainer.html(response.html); // Update product list dynamically
                        // }
                        $('html, body').animate({
                            scrollTop: 0
                        }, 300);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Listen for changes in checkboxes
            $('body').on('change', '.checkbox', function(event) {
                fetchFilteredProducts(event);
            });

            // Listen for the filter button click
            $('.filter-btn').on('click', function(event) {
                fetchFilteredProducts(event);
            });
        });
    </script>
@endpush
