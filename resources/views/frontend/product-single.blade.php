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

        .color-tab label.active img,
        .size-button.active {
            border: 5px solid #df9b19;
        }

        .color-tab label img {
            border: 1px solid #a1a1a1;
            border-radius: 100%;
        }
    </style>
@endpush
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
                                @php
                                    $images = product_images($product->id);
                                @endphp
                                <div class="product-large-slider mb-4">
                                    @foreach ($images as $key => $variaion_slider)
                                        <!--  img-showcase --> @php $x = 0; @endphp
                                        @foreach ($variaion_slider as $vari_images)
                                            <div class="pro-large-img img-zoom" data-category="{{ $key }}">
                                                <img src="{{ asset('images/products/' . $vari_images) }}"
                                                    onerror="this.onerror=null;this.src='/images/default.png';"
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
                                    <div class="pro-review d-none">
                                        <span><a href="#">0 Review(s)</a></span>
                                    </div>   
                                    <div class="price-box">
                                        <span class="regular-price">{{ min_price($product->id) }}</span>
                                    </div>
                                    <div class="price-box small">
                                        <small>SKU</small> : <span class="text-theme  productSku"></span>
                                    </div>   
                                    <div class="price-box">
                                        <span class="text-success small">Inclusive of all taxes</span>
                                    </div>
                                    <p>{{ $product->care_instruction }}</p>
                                    <div class="product__variations">
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
                                            <h5 class="cat-title mb-3 fw-bolder">Colors :</h5>
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

                                <div class="accordion accordion-flush mt-3" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-ProductDetails">
                                            <button class="accordion-button collapsed text-dark fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-ProductDetails"
                                                aria-expanded="false" aria-controls="flush-ProductDetails">
                                                Product Details
                                            </button>
                                        </h2>
                                        <div id="flush-ProductDetails" class="collapse collapse-horizontal"
                                            aria-labelledby="flush-ProductDetails" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Placeholder content for this accordion, which is
                                                intended to demonstrate the <code>.accordion-flush</code> class. This is the
                                                first item's accordion body.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-CareInstruction">
                                            <button class="accordion-button collapsed text-dark fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-CareInstruction"
                                                aria-expanded="false" aria-controls="flush-CareInstruction">
                                                Care Instruction
                                            </button>
                                        </h2>
                                        <div id="flush-CareInstruction" class="collapse collapse-horizontal"
                                            aria-labelledby="flush-CareInstruction" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Placeholder content for this accordion, which is
                                                intended to demonstrate the <code>.accordion-flush</code> class. This is the
                                                second item's accordion body. Let's imagine this being filled with some
                                                actual content.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-OtherDetails">
                                            <button class="accordion-button collapsed text-dark fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-OtherDetails"
                                                aria-expanded="false" aria-controls="flush-OtherDetails">
                                                Other Details
                                            </button>
                                        </h2>
                                        <div id="flush-OtherDetails" class="collapse collapse-horizontal"
                                            aria-labelledby="flush-OtherDetails" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Placeholder content for this accordion, which is
                                                intended to demonstrate the <code>.accordion-flush</code> class. This is the
                                                third item's accordion body. Nothing more exciting happening here in terms
                                                of content, but just filling up the space to make it look, at least at first
                                                glance, a bit more representative of how this would look in a real-world
                                                application.</div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-ConsumerComplaintContact">
                                            <button class="accordion-button collapsed text-dark fw-bold" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-ConsumerComplaintContact"
                                                aria-expanded="false" aria-controls="flush-ConsumerComplaintContact">
                                                Consumer Complaint Contact
                                            </button>
                                        </h2>
                                        <div id="flush-ConsumerComplaintContact" class="collapse collapse-horizontal"
                                            aria-labelledby="flush-ConsumerComplaintContact" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">Placeholder content for this accordion, which is
                                                intended to demonstrate the <code>.accordion-flush</code> class. This is the
                                                third item's accordion body. Nothing more exciting happening here in terms
                                                of content, but just filling up the space to make it look, at least at first
                                                glance, a bit more representative of how this would look in a real-world
                                                application.</div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- product details reviews start -->
                    <div class="product-details-reviews section-padding d-none">
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
                    <section class="Related-product mt-20">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="section-title text-center">
                                        <h2 class="title">Related Product</h2>
                                        <p class="sub-title">you may also like</p>
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
                                                    <h5 class="product-name">
                                                        <a target="_blank"
                                                            href="{{ route('public.product', ['uid' => $similarProduct->unique_value, 'slug' => $similarProduct->slug]) }}">{{ $similarProduct->product_name }}</a>
                                                    </h5>
                                                    <div class="price-box">
                                                        <span class="price-regular small fw-semibold">
                                                            ₹ {{ number_format($similarProduct->minPrice) }}</span>
                                                    </div>
                                                    <div class="product-action-link">
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

{{-- 
@push('footer')
    <script>
        $(document).ready(function() {
            $('.size-tab .size-button').not('.disabled').first().find('input[type="radio"]').prop('checked', true);
            // Function to handle active class toggle
            $('.variSize_checkbox').on('change', function() {
                // Remove 'active' class from all labels
                $('.size-button').removeClass('active');

                // Add 'active' class to the parent label of the checked input
                if ($(this).is(':checked')) {
                    $(this).closest('.size-button').addClass('active');
                }
                var size = $(this).val();
                var product = $(this).data('product');

                $.ajax({
                    url: '/get-variation-details',
                    method: 'GET',
                    data: {
                        product_id: product,
                        size: size,
                    },
                    success: function(response) {
                        $('.color-tab').html(response);
                        $('.color-tab .color-button').not('.disabled').first().find('input[type="radio"]').prop('checked', true);

                    }
                });


            });

            // Trigger change event on the initially checked radio input
            $('.variSize_checkbox:checked').trigger('change');
        });
    </script>
@endpush --}}

@push('footer')
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
        });

        // Function to handle color change
        $('body').on('change', '.variColor_checkbox', function(e) {
            // Remove 'active' class from all labels
            $('.color-button').removeClass('active');

            // Add 'active' class to the parent label of the checked input
            if ($(this).is(':checked')) {
                $(this).closest('.color-button').addClass('active');
            }

            var color = $(this).val();
            var sku = $(this).data('sku');
            var price = $(this).data('price');
            var stock = $(this).data('stock');
            var pName = $(this).data('productname');
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
        });

        $(document).ready(function() {
            $('#addToCartBtn').on('click', function() {
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
@endpush
