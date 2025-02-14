@extends('layouts.app')
@push('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity= "sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        ol i {
            font-size: 10px;
            font-weight: 800;
        }
    </style>
    <style>
        .icon-box {
            width: 55px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
        }

        hr {
            border: none;
            height: 3px;
            margin-top: 5px;
        }

        hr.bg-success {
            background: green !important;
            color: green;
            opacity: inherit;
        }
    </style>
@endpush
@section('content')
    <section class="product-listing-banner">
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area bg-img" data-bg="/assets/img/breadcrumb-banner.webp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h1 class="breadcrumb-title">My Orders</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('account.home') }}">My Account</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Orders</li>
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
        $orderStates = [
            'PENDING' => 1,
            'CONFIRMED' => 2,
            'READY_FOR_DISPATCH' => 3,
            'OUT_FOR_PICKUP' => 4,
            'PICKED_UP' => 5,
            'IN_TRANSIT' => 6,
            'OUT_FOR_DELIVERY' => 7,
            'DELIVERED' => 8,
            'UNDELIVERED' => 9,
        ];

    @endphp
    <section class="py-10">
        <div class="container mx-auto max-w-4xl">
            @if ($orders->count() > 0)
                @foreach ($orders as $order)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                        <div class="p-4 bg-gray-100 cursor-pointer" data-bs-toggle="collapse"
                            data-bs-target="#order-{{ $order->id }}">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-600">Order Placed</p>
                                    <p class="font-semibold text-sm ">{{ dateFormat($order->created_at) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 text-sm ">Expecting Delivery</p>
                                    <p class="font-semibold text-sm ">{{ dateFormat($order->created_at) }}</p>
                                </div>
                                <div class="font-semibold text-lg text-sm ">
                                    <p class="text-sm text-gray-600 text-sm ">Amount</p>
                                    <p class="font-semibold text-sm ">{{ getPrice($order->grandtotal) }}</p>
                                </div>
                                <div class="text-sm font-semibold text-sm ">
                                    <p class="text-sm text-gray-600 text-sm ">Order No:</p>
                                    <p class="font-semibold text-sm ">#{{ $order->invoice_id }}</p>

                                </div>
                            </div>
                            {{-- <div class=" mt-3">
                                <!-- Add class 'active' to progress -->
                                <ol
                                    class="flex items-center w-full text-sm font-medium text-center text-gray-500 dark:text-gray-400 sm:text-base">
                                    <li
                                        class="flex md:w-full items-center text-blue-600 dark:text-blue-500 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-blue after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 dark:after:border-gray-700">
                                        <span
                                            class="flex flex-column items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                            <img class="mx-auto w-50"
                                                src="{{ asset('assets/img/icon/order-processed.png') }}">
                                            <i>Processing</i>
                                        </span>
                                    </li>
                                    <li
                                        class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 ">
                                        <span
                                            class="flex flex-column items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                            <span class="me-2">
                                                <img class="mx-auto w-50"
                                                    src="{{ asset('assets/img/icon/order-shipped.png') }}">
                                                <i>Shipped</i>

                                            </span>
                                        </span>
                                    </li>
                                    <li
                                        class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10 ">
                                        <span
                                            class="flex flex-column items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 dark:after:text-gray-500">
                                            <img class="mx-auto w-50"
                                                src="{{ asset('assets/img/icon/order-en-route.gif') }}">
                                            <i>InRoute</i>
                                        </span>
                                    </li>
                                    <li class="flex items-center">
                                        <span class="me-2">
                                            <img class="mx-auto w-50"
                                                src="{{ asset('assets/img/icon/order-arrived.png') }}">
                                            <i> Delivered</i>
                                        </span>
                                    </li>
                                </ol>

                            </div> --}}
                        </div>

                        <div class="collapse" id="order-{{ $order->id }}">
                            <div class="p-5">
                                <h2 class="text-lg font-semibold mb-3">Order Details</h2>
                                @foreach ($order->basket->items as $listing_item)
                                    <div class="flex items-center gap-4 border-b pb-3 mb-3">
                                        <img src="{{ asset('images/products/' . $listing_item->picture) }}"
                                            class="h-16 object-cover rounded-md w-20"
                                            onerror="this.onerror=null;this.src='/assets/images/dummy-product.jpg';">
                                        <div>
                                            <h3 class="text-sm font-semibold">{{ $listing_item->product_name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $listing_item->variation }}</p>
                                            <p class="font-semibold">
                                                {{ getPrice($listing_item->price_amount * $listing_item->quantity) }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="grid grid-cols-2 gap-6 mt-5">
                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <h3 class="text-md font-semibold">Billing Address</h3>
                                        @if ($order->billingAddress)
                                            <p class="text-sm text-gray-700">
                                                <strong>{{ $order->billingAddress->name }}</strong><br>
                                                {{ $order->billingAddress->address }}<br>
                                                {{ $order->billingAddress->locality }},
                                                {{ $order->billingAddress->state }},
                                                {{ $order->billingAddress->pincode }}<br>
                                                Phone: <a href="tel:{{ $order->billingAddress->mobile }}"
                                                    class="text-blue-600">{{ $order->billingAddress->mobile }}</a><br>
                                                Email: {{ $order->billingAddress->email }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-500">No billing address available.</p>
                                        @endif
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <h3 class="text-md font-semibold">Delivery Address</h3>
                                        @if ($order->deliveryAddress)
                                            <p class="text-sm text-gray-700">
                                                <strong>{{ $order->deliveryAddress->name }}</strong><br>
                                                {{ $order->deliveryAddress->address }}<br>
                                                {{ $order->deliveryAddress->locality }},
                                                {{ $order->deliveryAddress->state }},
                                                {{ $order->deliveryAddress->pincode }}<br>
                                                Phone: <a href="tel:{{ $order->deliveryAddress->mobile }}"
                                                    class="text-blue-600">{{ $order->deliveryAddress->mobile }}</a><br>
                                                Email: {{ $order->deliveryAddress->email }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-500">No delivery address available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @php
                                // Define order status steps with numerical order

                                // Format order state keys to uppercase for comparison
                                $orderStatesFormatted = [];
                                foreach ($orderStates as $state => $step) {
                                    $orderStatesFormatted[strtoupper($state)] = $step;
                                }

                                // Get current order status from DeliveryPartnerResponse (a single string)
                                $currentStatus = strtoupper($order->delivery_status ?? $order->status);
                                $currentStep = $orderStatesFormatted[$currentStatus] ?? 1;
                            @endphp

                            <div class="container my-2">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card bg-light shadow-lg border rounded-lg py-4 px-5">
                                            <!-- Order Tracking Title -->
                                            <h5 class="text-center mb-4 text-primary fw-bold">Order Tracking</h5>
                                            <div class="row">
                                                @foreach ($orderStates as $state => $step)
                                                    <div class="col-md-3">
                                                        <div class="d-flex align-items-center mb-4">
                                                            <div
                                                                class="icon-box rounded-circle {{ $currentStep >= $step ? 'bg-success text-white' : 'bg-secondary text-light' }}">
                                                                <i class="fa-solid fa-{{ getIcon($state) }}"></i>
                                                            </div>
                                                            <span
                                                                class="mb-0 text-sm text-capitalize text-center w-100 ms-3 d-flex flex-column">
                                                                {!! str_replace('_', ' ', strtolower($state)) !!}
                                                                <hr size="2"
                                                                    class="w-100 h-1 {{ $currentStep >= $step ? 'bg-success' : 'bg-secondary' }}">
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                @endforeach
            @else
                <div class="mt-5 d-flex justify-content-center align-items-center">
                    <div class="col-md-6">
                        <div class="border border-3 border-dark"></div>
                        <div class="card  bg-white shadow p-5">
                            <div class="mb-4 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
                                    <circle cx="60" cy="60" r="52" fill="#F5F6F8" stroke="#E2E4E8"
                                        stroke-width="4" />
                                    <path d="M32 40L88 40" stroke="#A0AEC0" stroke-width="8" stroke-linecap="round" />
                                    <path d="M32 60L88 60" stroke="#A0AEC0" stroke-width="8" stroke-linecap="round" />
                                    <path d="M32 80L88 80" stroke="#A0AEC0" stroke-width="8" stroke-linecap="round" />
                                    <circle cx="60" cy="60" r="10" fill="#A0AEC0" />
                                </svg>


                            </div>
                            <div class="text-center">
                                <h1 class="fs-2 fw-bold">No Orders Found !</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    @php
        /**
         * Return a Font Awesome icon class based on the order state.
         */
        function getIcon($state)
        {
            $icons = [
                'PENDING' => 'spinner',
                'CONFIRMED' => 'clipboard-check',
                'READY_FOR_DISPATCH' => 'boxes-packing',
                'OUT_FOR_PICKUP' => 'truck-loading',
                'PICKED_UP' => 'truck-moving',
                'IN_TRANSIT' => 'truck-fast',
                'OUT_FOR_DELIVERY' => 'truck-arrow-right',
                'DELIVERED' => 'house-chimney',
                'UNDELIVERED' => 'exclamation-triangle',
            ];
            return $icons[$state] ?? 'question-circle';
        }
    @endphp
@endsection
