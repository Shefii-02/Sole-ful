@extends('layouts.app')
@push('header')
    <style>
        ol i {
            font-size: 10px;
            font-weight: 800;
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
                            <div class=" mt-3">
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

                            </div>
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
@endsection
