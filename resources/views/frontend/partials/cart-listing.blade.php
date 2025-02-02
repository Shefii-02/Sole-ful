@if (isset($products))
    @php
        $totalAmount = 0;
    @endphp
    <div class="side-cart-product">
        @foreach ($products ?? [] as $cItem)
            <div class="cart-item ps-1 pe-1 mb-3">
                <div class="row">
                    <div class="col-2 cart-item-image position-relative d-flex align-items-center">
                        <img src="{{ asset('images/products/' . $cItem->picture) }}" class="rounded-3 w-20"
                            onerror="this.onerror=null;this.src='/images/default.jpg';" alt="">
                        <span
                            style="position: absolute; top: 0px; right: -10px; background-color: #f591c1; color: white; border-radius: 50%; width: 20px; height: 20px; text-align: center; font-size: 12px;">
                            {{ $cItem->quantity }}
                        </span>
                    </div>
                    <div class="col-8">
                        <div class="cart-item-details ps-2 text-truncate">
                            <h4 class="p_name cart-item-title">{{ $cItem->variation }}</h4>
                            <sub class="my-2">SKU : {{ $cItem->product_sku }}</sub><br>
                            <sub class="my-2 text-capitalize">{{ $cItem->special_note }}</sub><br>
                            <span
                                class="cart-item-price Item_total fw-bold">{{ getPrice($cItem->price_amount * $cItem->quantity) }}</span>
                        </div>
                    </div>
                    <div class="col-2">
                        <button class="delete-btn" data-pname="{{ $cItem->variation }}"
                            data-psku="{{ $cItem->product_sku }}" data-pid="{{ $cItem->product_variation_id }}"
                            data-id="{{ $cItem->id }}" data-price="{{ $cItem->price_amount }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @php
                $totalAmount += $cItem->price_amount * $cItem->quantity;
            @endphp
        @endforeach
    </div>

    <!-- Fixed Bottom Subtotal and Buttons -->
    <div class="bg-white bottom-0 position-fixed p-3 shadow-lg w-100">
        <div class="d-flex gap-3 flex-column ">
            <div class="float-end">
                <span class="fw-bold">Subtotal:</span>
                <span id="total-amount" class="fw-bold">{{ getPrice($totalAmount) }}</span>
            </div>
            <a class="btn-theme w-25 flot-end btn" href="{{ route('public.cart-list') }}">View Cart</a>
         
        </div>
    </div>
@else
    <div class="text-center">
        <h1 class="fs-4 fw-bold gap-3 d-flex mt-5">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                <path
                    d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708z">
                </path>
            </svg> Your cart is empty !
        </h1>
        <p class="my-2">Please add an item to the cart</p>
        <a href="{{ route('public.shop') }}" class="btn btn-sm btn-theme text-light my-3">
            Continue shopping
        </a>
    </div>
@endif
