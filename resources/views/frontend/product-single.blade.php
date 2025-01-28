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
                                @php
                                    $images = product_images($product->id);
                                @endphp
                                <div class="product-large-slider mb-4">
                                    {{-- @foreach ($images as $key => $variaion_slider)
                                        <!--  img-showcase --> @php $x = 0; @endphp
                                        @foreach ($variaion_slider as $vari_images)
                                            <div class="pro-large-img  img-zoom imgshowing"
                                                data-variation="{{ $key }}">
                                                <img src="{{ asset('images/products/' . $vari_images) }}"
                                                    onerror="this.onerror=null;this.src='/images/default.png';"
                                                    alt="{{ $product->product_name }}">
                                            </div>
                                        @endforeach
                                    @endforeach --}}
                                </div>

                                <div class="pro-nav slick-row-5">
                                    {{-- @foreach ($images as $key => $variaion_slider)
                                        <!--  img-showcase --> @php $x = 0; @endphp
                                        @foreach ($variaion_slider as $vari_images)
                                            <div style="display: none" class="pro-nav-thumb imgshowing"
                                                data-variation="{{ $key }}">
                                                <img src="{{ asset('images/products/' . $vari_images) }}"
                                                    onerror="this.onerror=null;this.src='/assets/images/dummy-product.jpg';"
                                                    alt="{{ $product->product_name }}" />
                                            </div>
                                        @endforeach
                                    @endforeach --}}
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

                                                    <div class="col-lg-6">
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
                                        <div id="flush-OtherDetails" class="accordion-collapse collapse"
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


@push('footer')
    {{-- <script>
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

            var images = JSON.parse($(this).attr('data-image')); // Get the image array from the selected color
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
    </script> --}}
@endpush
