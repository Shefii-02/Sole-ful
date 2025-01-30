@extends('layouts.app')
@push('header')
    <style>
        .element-error::after {
            width: 100% !important;
        }

        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }


        .hidden-div::before {
            left: 20% !important;
            top: -20px !important;
        }

        @media only screen and (max-width: 768px) {
            .hidden-div {
                left: 0px !important;
                transform: translateX(-5%) !important;
            }
        }

        .cart-bale tbody th .t-h {
            display: flex;
            align-items: center;
        }

        .cart-bale tbody th div {
            padding: 0 10px;
        }

        @media (min-width: 768px) {
            #responsive-cart {
                padding: 0px;
            }
        }

        #responsive-cart {
            margin: 15px 0;
            padding: 0px 25px;
        }

        #responsive-cart .row.title-row {
            background: #EEE;
            padding: 5px 15px;
            box-shadow: none;
        }

        #responsive-cart .row {
            margin-bottom: 15px;
            border-bottom: 1px solid #EEE;
            border: 1px solid #EEE;
            border-radius: 15px;
            box-shadow: #EEE 0px 0px 5px 2px;
            padding: 15px;
        }

        #responsive-cart .row.title-row .column {
            padding: 10px;
        }

        #responsive-cart .row .column {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        #responsive-cart .row .column {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (min-width: 768px) {
            .cart-action {
                justify-content: start;
            }
        }

        .cart-action {
            font-size: 90%;
            white-space: nowrap;
            display: flex;
            flex-direction: row;
            margin: 10px 0;
            justify-content: start;
        }

        .cart-action a {
            margin: 0px 7px;
        }

        @media (min-width: 768px) {

            .product-quantity,
            .product-subtotal {
                padding: 5px;
                background: transparent;
            }
        }

        .input-group {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            width: 100%;
        }

        @media (min-width: 768px) {

            .product-quantity,
            .product-subtotal {
                padding: 5px;
                background: transparent;
            }
        }
    </style>
@endpush

@section('content')

    <section class="product-listing-banner">
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area bg-img" data-bg="assets/img/breadcrumb-banner.webp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h1 class="breadcrumb-title">Cart</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
    </section>
    @php
        $totalAmount = 0;
    @endphp


    <section class="py-5">
        <div class="container">
            <div class="entry-content">
                <div class="woocommerce">
                    @if (isset($items) && $items->count() > 0)
                        <div id="responsive-cart">
                            <div class="d-none d-md-block">
                                <div class="row title-row">
                                    <div class="col-md-2 column">
                                        Item
                                    </div>
                                    <div class="col-md-5 column">
                                        Details
                                    </div>
                                    <div class="col-md-2 column text-center">
                                        Price
                                    </div>
                                    <div class="col-md-2 column">
                                        Quantity
                                    </div>
                                    <div class="col-md-1 column text-end">
                                        Amount
                                    </div>
                                </div>
                            </div>
                            @foreach ($items ?? [] as $listing)
                                <div class="row cart-item shadow-sm">
                                    <div class="col-md-2 column product_image">
                                        <img src="{{ asset('images/products/' . $listing->picture) }}" class="rounded-3"
                                            onerror="this.onerror=null;this.src='/images/default.jpg';" alt="">

                                    </div>
                                    <div class="col-md-5 column product_name text-start">
                                        <a href="#" class="fw-semibold d-flex flex-column gap-1">
                                            <strong class="text-capitalize">{{ $listing->variation }} </strong>
                                            <sub class="my-2">{{ $listing->product_name }}</sub>
                                            <sub class="my-2">SKU : {{ $listing->product_sku }}</sub>
                                            <sub class="my-2 text-capitalize">{{ $listing->special_note }}</sub>
                                        </a>


                                        <div class="cart-action">
                                            <a
                                                href="{{ route('public.product', ['uid' => $listing->product->unique_value, 'slug' => $listing->product->slug]) }}"><i
                                                    class="bi bi-eye"></i> View</a> |
                                            <a href="#" class="item_remove" data-pname="{{ $listing->variation }}"
                                                data-psku="{{ $listing->product_sku }}"
                                                data-pid="{{ $listing->product_variation_id }}"
                                                data-id="{{ $listing->id }}" data-price="{{ $listing->price_amount }}"><i
                                                    class="bi bi-trash"></i> Remove</a>
                                        </div>

                                    </div>
                                    <div class="col-md-2 column product_price text-center">
                                        <div class="price product-price" data-title="Price">
                                            <input class="item-amount" type="hidden" value="{{ $listing->price_amount }}">
                                            {{ getPrice($listing->price_amount) }}
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-8 column product-quantity " data-title="Quantity">
                                        <div class="input-group quantity qty-input">
                                            <span id="basic-addon1" class="input-group-text qty-count qty-count--minus"
                                                data-action="minus" type="button">-</span>
                                            <input readonly="" value="{{ $listing->quantity }}" inputmode="numeric"
                                                class="input-text px-0 product-qty text-center item-quantity w-25 border "
                                                data-pname="{{ $listing->variation }}"
                                                data-psku="{{ $listing->product_sku }}"
                                                data-pid="{{ $listing->product_variation_id }}"
                                                data-id="{{ $listing->id }}" data-price="{{ $listing->price_amount }}"
                                                type="number" name="product-qty" min="0">
                                            <span class="input-group-text qty-count qty-count--add" data-action="add"
                                                type="button" id="basic-addon1">+</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-4 column text-end product-subtotal" data-title="Total">
                                        <div class="woocommerce-Price-amount amount"> <span
                                                class="Item_total fw-bold">{{ getPrice($listing->price_amount * $listing->quantity) }}</span>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $totalAmount = $totalAmount + ($listing->price_amount * $listing->quantity);
                                @endphp
                            @endforeach
                        </div>
                        <div class="col-lg-12 text-end px-2">
                            <div class="fs-2 fw-bold " id="total-amount">Total: {{ getPrice($totalAmount) }}</div>
                        </div>

                        <section class="allergies pb-3 pb-md-5">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                                        <p>
                                            Declimer here
                                        </p>
                                        <textarea class="a-textarea" name="remark" id="remark" form="goto_checkout"></textarea>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="for-checkout mt-4 d-flex gap-2 ">


                                            <a href="{{ route('public.shop') }}"
                                                class="btn btn-dark text-white secondary-btn w-50 px-3"
                                            >Continue Shopping
                                            </a>
                                            <a href="{{ route('public.checkout') }}" class="btn primary-btn btn-theme px-3  w-50 checkout_btn"
                                                >Checkout</a>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </section>
                    @else
                        <section class="page_section">
                            <div class="d-flex justify-content-center align-items-center for-vertical-height">
                                <div class="col-md-6">
                                    <div class=""></div>
                                    <div class=" bg-white p-5">
                                        <div class="text-center">
                                            <h1 class="fs-1 fw-bold gap-3 d-flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                    fill="currentColor" class="bi bi-cart-check-fill"
                                                    viewBox="0 0 16 16">
                                                    <path
                                                        d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z" />
                                                </svg> Your cart is empty !
                                            </h1>
                                            <p class="my-2">Please add an item to the cart</p>
                                            <a href="/shop" class="btn  btn-sm btn-theme text-light my-3">Continue
                                                shopping</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h3></h3>
                            </div>
                        </section>
                    @endif

                </div>
            </div>
        </div>
    </section>

@endsection

@push('footer')
    <script>
        var QtyInput = (function() {
            var $qtyInputs = $(".qty-input");

            if (!$qtyInputs.length) {
                return;
            }

            var $inputs = $qtyInputs.find(".product-qty");
            var $countBtn = $qtyInputs.find(".qty-count");
            var qtyMin = parseInt($inputs.attr("min"));
            var qtyMax = parseInt($inputs.attr("max"));

            $inputs.change(function() {
                var $this = $(this);
                var $minusBtn = $this.siblings(".qty-count--minus");
                var $addBtn = $this.siblings(".qty-count--add");
                var qty = parseInt($this.val());

                if (isNaN(qty) || qty <= qtyMin) {
                    $this.val(qtyMin);
                    $minusBtn.attr("disabled", true);
                } else {
                    $minusBtn.attr("disabled", false);

                    if (qty >= qtyMax) {
                        $this.val(qtyMax);
                        $addBtn.attr('disabled', true);
                    } else {
                        $this.val(qty);
                        $addBtn.attr('disabled', false);
                    }
                }
            });

            $countBtn.click(function() {
                var operator = this.dataset.action;
                var $this = $(this);
                var $input = $this.siblings(".product-qty");
                var qty = parseInt($input.val());

                if (operator == "add") {
                    qty += 1;
                    if (qty >= qtyMin + 1) {
                        $this.siblings(".qty-count--minus").attr("disabled", false);
                    }

                    if (qty >= qtyMax) {
                        $this.attr("disabled", true);
                    }
                } else {
                    qty = qty <= qtyMin ? qtyMin : (qty -= 1);

                    if (qty == qtyMin) {
                        $this.attr("disabled", true);
                    }

                    if (qty < qtyMax) {
                        $this.siblings(".qty-count--add").attr("disabled", false);
                    }
                }

                $input.val(qty);
                $('.item-quantity').trigger('change');
            });
        })();



        $(window).on("load", function() {
            $("#loader-overlay").fadeOut("slow");
        });

        $('body').on('change', '.item-quantity', async function() {

            var item = $(this).closest('.cart-item');
            var quantity = $(this).val();
            var product_sku = $(this).data('psku');
            var product_id = $(this).data('pid');
            var product_price = $(this).data('price');

            await update_products(product_sku, product_id, product_price, quantity);

            var price = parseFloat(item.find('.item-amount').val());
            var amount = price * quantity;


            item.find('.Item_total').text('₹' + amount.toFixed(2));
            if (quantity <= 0) {
                item.remove();
                if ($('.cart-item').length === 0) {
                    location.reload();
                }
            }
            var totalAmount = 0;
            $('.Item_total').each(function() {
                totalAmount += parseFloat($(this).text().replace('₹', ''));
            });
            $('#total-amount').text('Total: ₹' + totalAmount.toFixed(2));
            $('.addon_grandtotal').text('₹' + totalAmount.toFixed(2))

        });


        $('body').on('click', '.item_remove', async function() {
            var item = $(this).closest('.cart-item');
            var quantity = $(this).val();
            var product_sku = $(this).data('psku');
            var product_id = $(this).data('pid');
            var product_price = $(this).data('price');
            var preorder = $(this).data('preorder')

            item.remove();

            await update_products(product_sku, product_id, product_price, 0);

            var totalAmount = 0;

            $('.Item_total').each(function() {
                totalAmount += parseFloat($(this).text().replace('₹', ''));
            });

            $('#total-amount').text('Total: ₹' + totalAmount.toFixed(2));
            $('.addon_grandtotal').text('₹' + totalAmount.toFixed(2));

            if ($('.cart-item').length === 0 || preorder == 1) {
                location.reload();
            }
        });


        const body = $('body');
        async function update_products(product_sku, product_id, product_price, quantity) {
            body.append(`<div class="product-loading"><i class="bi bi-arrow-clockwise"></i></div>`);
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
                    'quantity': quantity,
                    'price': product_price
                },
                success: function(response) {

                    $('.cart-icon .cart-count').html(response.cart_count)
                    body.find('.product-loading').remove();


                    var addToCartData = response.addToCartData;
               
                  
                },
                error: function(xhr, status, error) {

                    alertJsFunction(status, 'error');
                    //  alert('something went wrong please try again')
                    // body.find('.product-loading').remove();
                }
            });
            return true;
        }


    </script>

@endpush
