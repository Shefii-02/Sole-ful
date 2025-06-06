@extends('admin.layouts.master')

@section('content')
    <!-- Font-awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity= "sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="py-4">
        <div
            class="rounded-md border border-stroke bg-whiter p-4 py-3 dark:border-strokedark dark:bg-meta-4 sm:px-6 sm:py-5.5 xl:px-7.5">
            <nav>
                <ol class="flex flex-wrap items-center gap-2">
                    <li>
                        <a class="flex items-center gap-2 font-medium text-black hover:text-primary dark:text-white dark:hover:text-primary"
                            href="{{ route('admin.dashboard') }}">
                            <svg class="fill-current" width="15" height="15" viewBox="0 0 15 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.3503 14.6504H10.2162C9.51976 14.6504 8.93937 14.0698 8.93937 13.373V10.8183C8.93937 10.5629 8.73043 10.3538 8.47505 10.3538H6.54816C6.29279 10.3538 6.08385 10.5629 6.08385 10.8183V13.3498C6.08385 14.0465 5.50346 14.6272 4.80699 14.6272H1.62646C0.929989 14.6272 0.349599 14.0465 0.349599 13.3498V5.24444C0.349599 4.89607 0.535324 4.57092 0.837127 4.38513L6.96604 0.506623C7.29106 0.297602 7.73216 0.297602 8.05717 0.506623L14.1861 4.38513C14.4879 4.57092 14.6504 4.89607 14.6504 5.24444V13.3266C14.6504 14.0698 14.07 14.6504 13.3503 14.6504ZM6.52495 9.54098H8.45184C9.14831 9.54098 9.7287 10.1216 9.7287 10.8183V13.3498C9.7287 13.6053 9.93764 13.8143 10.193 13.8143H13.3503C13.6057 13.8143 13.8146 13.6053 13.8146 13.3498V5.26766C13.8146 5.19799 13.7682 5.12831 13.7218 5.08186L7.61608 1.20336C7.54643 1.15691 7.45357 1.15691 7.40714 1.20336L1.27822 5.08186C1.20858 5.12831 1.18536 5.19799 1.18536 5.26766V13.373C1.18536 13.6285 1.3943 13.8375 1.64967 13.8375H4.80699C5.06236 13.8375 5.2713 13.6285 5.2713 13.373V10.8183C5.24809 10.1216 5.82848 9.54098 6.52495 9.54098Z"
                                    fill=""></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.51145 1.55118L13.465 5.33306V13.3498C13.465 13.4121 13.4126 13.4646 13.3503 13.4646H10.193C10.1307 13.4646 10.0783 13.4121 10.0783 13.3498V10.8183C10.0783 9.92844 9.34138 9.19125 8.45184 9.19125H6.52495C5.63986 9.19125 4.89529 9.92534 4.9217 10.8238V13.373C4.9217 13.4354 4.86929 13.4878 4.80699 13.4878H1.64967C1.58738 13.4878 1.53496 13.4354 1.53496 13.373V5.33323L7.51145 1.55118ZM1.27822 5.08186L7.40714 1.20336C7.45357 1.15691 7.54643 1.15691 7.61608 1.20336L13.7218 5.08186C13.7682 5.12831 13.8146 5.19799 13.8146 5.26766V13.3498C13.8146 13.6053 13.6057 13.8143 13.3503 13.8143H10.193C9.93764 13.8143 9.7287 13.6053 9.7287 13.3498V10.8183C9.7287 10.1216 9.14831 9.54098 8.45184 9.54098H6.52495C5.82848 9.54098 5.24809 10.1216 5.2713 10.8183V13.373C5.2713 13.6285 5.06236 13.8375 4.80699 13.8375H1.64967C1.3943 13.8375 1.18536 13.6285 1.18536 13.373V5.26766C1.18536 5.19799 1.20858 5.12831 1.27822 5.08186ZM13.3503 15.0001H10.2162C9.32668 15.0001 8.58977 14.2629 8.58977 13.373V10.8183C8.58977 10.756 8.53735 10.7036 8.47505 10.7036H6.54816C6.48587 10.7036 6.43345 10.756 6.43345 10.8183V13.3498C6.43345 14.2397 5.69654 14.9769 4.80699 14.9769H1.62646C0.736911 14.9769 0 14.2397 0 13.3498V5.24444C0 4.77143 0.251303 4.33603 0.651944 4.08848L6.77814 0.211698C7.21781 -0.0704034 7.80541 -0.0704031 8.24508 0.211698C8.24546 0.211943 8.24584 0.212188 8.24622 0.212433L14.3713 4.08851C14.7853 4.34436 15 4.78771 15 5.24444V13.3266C15 14.2589 14.2671 15.0001 13.3503 15.0001ZM14.1861 4.38513L8.05717 0.506623C7.73216 0.297602 7.29106 0.297602 6.96604 0.506623L0.837127 4.38513C0.535324 4.57092 0.349599 4.89607 0.349599 5.24444V13.3498C0.349599 14.0465 0.929989 14.6272 1.62646 14.6272H4.80699C5.50346 14.6272 6.08385 14.0465 6.08385 13.3498V10.8183C6.08385 10.5629 6.29279 10.3538 6.54816 10.3538H8.47505C8.73043 10.3538 8.93937 10.5629 8.93937 10.8183V13.373C8.93937 14.0698 9.51976 14.6504 10.2162 14.6504H13.3503C14.07 14.6504 14.6504 14.0698 14.6504 13.3266V5.24444C14.6504 4.89607 14.4879 4.57092 14.1861 4.38513Z"
                                    fill=""></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-2 font-medium text-black hover:text-primary dark:text-white dark:hover:text-primary"
                            href="{{ route('admin.orders.index') }}">
                            <svg class="fill-current" width="18" height="7" viewBox="0 0 18 7" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.5704 2.58734L14.8227 0.510459C14.6708 0.333165 14.3922 0.307837 14.1896 0.459804C14.0123 0.61177 13.9869 0.890376 14.1389 1.093L15.7852 3.04324H1.75361C1.50033 3.04324 1.29771 3.24586 1.29771 3.49914C1.29771 3.75241 1.50033 3.95504 1.75361 3.95504H15.7852L14.1389 5.90528C13.9869 6.08257 14.0123 6.36118 14.1896 6.53847C14.2655 6.61445 14.3668 6.63978 14.4682 6.63978C14.5948 6.63978 14.7214 6.58913 14.7974 6.48782L16.545 4.41094C17.0009 3.85373 17.0009 3.09389 16.5704 2.58734Z"
                                    fill=""></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.1896 0.459804C14.3922 0.307837 14.6708 0.333165 14.8227 0.510459L16.5704 2.58734C17.0009 3.09389 17.0009 3.85373 16.545 4.41094L14.7974 6.48782C14.7214 6.58913 14.5948 6.63978 14.4682 6.63978C14.3668 6.63978 14.2655 6.61445 14.1896 6.53847C14.0123 6.36118 13.9869 6.08257 14.1389 5.90528L15.7852 3.95504H1.75361C1.50033 3.95504 1.29771 3.75241 1.29771 3.49914C1.29771 3.24586 1.50033 3.04324 1.75361 3.04324H15.7852L14.1389 1.093C13.9869 0.890376 14.0123 0.61177 14.1896 0.459804ZM15.0097 2.68302H1.75362C1.3014 2.68302 0.9375 3.04692 0.9375 3.49914C0.9375 3.95136 1.3014 4.31525 1.75362 4.31525H15.0097L13.8654 5.67085C13.8651 5.67123 13.8648 5.67161 13.8644 5.67199C13.5725 6.01385 13.646 6.50432 13.9348 6.79318C14.1022 6.96055 14.3113 7 14.4682 7C14.6795 7 14.9203 6.91713 15.0784 6.71335L16.8207 4.64286L16.8238 4.63904C17.382 3.95682 17.3958 3.00293 16.8455 2.35478C16.8453 2.35453 16.845 2.35429 16.8448 2.35404L15.0984 0.278534L15.0962 0.276033C14.8097 -0.0583053 14.3139 -0.0837548 13.9734 0.17163L13.964 0.17867L13.9551 0.186306C13.6208 0.472882 13.5953 0.968616 13.8507 1.30913L13.857 1.31743L15.0097 2.68302Z"
                                    fill=""></path>
                            </svg>
                            Orders
                        </a>

                    </li>
                    <li class="flex items-center gap-2 font-medium">
                        <svg class="fill-current" width="18" height="7" viewBox="0 0 18 7" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.5704 2.58734L14.8227 0.510459C14.6708 0.333165 14.3922 0.307837 14.1896 0.459804C14.0123 0.61177 13.9869 0.890376 14.1389 1.093L15.7852 3.04324H1.75361C1.50033 3.04324 1.29771 3.24586 1.29771 3.49914C1.29771 3.75241 1.50033 3.95504 1.75361 3.95504H15.7852L14.1389 5.90528C13.9869 6.08257 14.0123 6.36118 14.1896 6.53847C14.2655 6.61445 14.3668 6.63978 14.4682 6.63978C14.5948 6.63978 14.7214 6.58913 14.7974 6.48782L16.545 4.41094C17.0009 3.85373 17.0009 3.09389 16.5704 2.58734Z"
                                fill=""></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.1896 0.459804C14.3922 0.307837 14.6708 0.333165 14.8227 0.510459L16.5704 2.58734C17.0009 3.09389 17.0009 3.85373 16.545 4.41094L14.7974 6.48782C14.7214 6.58913 14.5948 6.63978 14.4682 6.63978C14.3668 6.63978 14.2655 6.61445 14.1896 6.53847C14.0123 6.36118 13.9869 6.08257 14.1389 5.90528L15.7852 3.95504H1.75361C1.50033 3.95504 1.29771 3.75241 1.29771 3.49914C1.29771 3.24586 1.50033 3.04324 1.75361 3.04324H15.7852L14.1389 1.093C13.9869 0.890376 14.0123 0.61177 14.1896 0.459804ZM15.0097 2.68302H1.75362C1.3014 2.68302 0.9375 3.04692 0.9375 3.49914C0.9375 3.95136 1.3014 4.31525 1.75362 4.31525H15.0097L13.8654 5.67085C13.8651 5.67123 13.8648 5.67161 13.8644 5.67199C13.5725 6.01385 13.646 6.50432 13.9348 6.79318C14.1022 6.96055 14.3113 7 14.4682 7C14.6795 7 14.9203 6.91713 15.0784 6.71335L16.8207 4.64286L16.8238 4.63904C17.382 3.95682 17.3958 3.00293 16.8455 2.35478C16.8453 2.35453 16.845 2.35429 16.8448 2.35404L15.0984 0.278534L15.0962 0.276033C14.8097 -0.0583053 14.3139 -0.0837548 13.9734 0.17163L13.964 0.17867L13.9551 0.186306C13.6208 0.472882 13.5953 0.968616 13.8507 1.30913L13.857 1.31743L15.0097 2.68302Z"
                                fill=""></path>
                        </svg>
                        Invoice Id : {{ $order->invoice_id }}
                    </li>
                </ol>
                
                <div class="text-end ">
                    <a href="{{ route('admin.orders.print', $order->invoice_id) }}" target="_new"
                        class="btn btn-theme button-1 text-white ctm-border-radius p-1 cursor-pointer mr-2">
                        Print Invoice</a>
                </div>
                <div class="text-end mt-3">
                    <a href="{{ route('admin.orders.print-shipping-label', $order->invoice_id) }}" target="_new"
                        class="btn btn-theme button-1 text-white ctm-border-radius p-1 cursor-pointer mr-2">
                        Print Shipping Label</a>
                </div>
            </nav>
        </div>
    </div>


    <div class="col-span-12">


        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-4 pb-2 dark:border-strokedark md:px-6 xl:px-7.5">

                <div class="col-lg-12 py-3">
                    <div class="table-back employee-office-table">
                        <div class="table-responsive">
                            <!-- Invoice Table -->
                            <table class="table table-hover table-striped table-bordered" align="center" cellpadding="10">
                                <thead>
                                    <tr>
                                        <td style="text-align:center;" colspan="2">
                                            <strong><big>INVOICE</big></strong><br />
                                            <p style="color:#333;">No: <strong
                                                    class="invoiceNo">{{ $order->invoice_id }}</strong></p>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <!-- Order Details Table -->
                            <table class="table table-hover table-striped table-bordered" align="center" cellpadding="7"
                                style="margin:15px 0;">
                                <tr>
                                    <td align="left" valign="top" width="50%">
                                        Order#: {{ $order->id }}<br />
                                        Order At:
                                        {{ dateFormat($order->billed_at) . ' ' . TimeFormat($order->billed_at) }}</br>
                                        Client Id: {{ $order->user_id }}
                                    </td>
                                    <td align="left" valign="top" width="50%">
                                        Delivery Date:
                                        <strong>{{ $order->delivery_at ? dateFormat($order->delivery_at) : 'N/A' }}</strong><br>
                                        Transaction#:
                                        <strong>{{ $order->payments?->transaction_id ?? 'N/A' }}</strong><br />
                                        Reference#: <strong>{{ $order->payments?->reference_id ?? 'N/A' }}</strong>
                                    </td>
                                </tr>
                            </table>
                            <!-- Customer Information Table -->
                            <table class="table table-hover table-striped table-bordered" align="center">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><span class="fw-bold fs-4">Customer Information</span></td>
                                    </tr>
                                    <tr>
                                        <td class="bg-grey"><span class="fw-bold fs-6">Billing Details</span></td>
                                        <td><span class="fw-bold fs-6">Delivery Details</span></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:left;" valign="top" width="50%">
                                            @if ($order->billingAddress)
                                                <strong>{{ $order->billingAddress->name }}</strong><br />
                                                {{ $order->billingAddress->address }}<br />
                                                House No/Name: #{{ $order->billingAddress->house_no }},
                                                {{ $order->billingAddress->house_name }}<br />
                                                Landmark: {{ $order->billingAddress->landmark }}<br>
                                                {{ $order->billingAddress->pincode }},
                                                {{ $order->billingAddress->locality }},
                                                {{ $order->billingAddress->state }}<br>
                                                <span class="fw-bold">Phone: <a
                                                        href="tel:{{ $order->billingAddress->mobile }}">{{ $order->billingAddress->mobile }}</a></span><br />
                                                <span class="fw-bold">Email: {{ $order->billingAddress->email }}</span>
                                            @else
                                                No billing address available.
                                            @endif
                                        </td>
                                        <td style="text-align:left;" valign="top" width="50%">
                                            @if ($order->deliveryAddress)
                                                <strong>{{ $order->deliveryAddress->name }}</strong><br />
                                                {{ $order->deliveryAddress->address }}<br />
                                                House No/Name: #{{ $order->deliveryAddress->house_no }},
                                                {{ $order->deliveryAddress->house_name }}<br />
                                                Landmark: {{ $order->deliveryAddress->landmark }},<br />
                                                {{ $order->deliveryAddress->locality }},
                                                {{ $order->deliveryAddress->pincode }},
                                                {{ $order->deliveryAddress->state }}<br>
                                                <span class="fw-bold">Phone: <a
                                                        href="tel:{{ $order->deliveryAddress->mobile }}">{{ $order->deliveryAddress->mobile }}</a></span><br />
                                                <span class="fw-bold">Email: {{ $order->deliveryAddress->email }}</span>
                                            @else
                                                No delivery address available.
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Order Items Table -->
                            <center><big><strong class="my-3">Order Items</strong></big></center>
                            <table class="table table-hover table-striped table-bordered mt-2" align="center">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Rate</th>
                                        <th style="text-align:center;">Qty</th>
                                        <th align="right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->basket->items as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('images/products/' . $item->picture) }}"
                                                    class="rounded-3 w-20"
                                                    onerror="this.onerror=null;this.src='/images/default.jpg';"
                                                    alt="">
                                                <strong class="text-capitalize">{{ $item->variation }} </strong><br>
                                                <sub class="my-2">{{ $item->product_name }}</sub><br>
                                                <sub class="my-2">SKU : {{ $item->product_sku }}</sub><br>
                                                <sub class="my-2 text-capitalize">{{ $item->special_note }}</sub>

                                            </td>
                                            <td>{{ number_format($item->price_amount, 2) }}</td>
                                            <td style="text-align:center;">{{ $item->quantity }}</td>
                                            <td style="text-align:right;">
                                                {{ number_format($item->quantity * $item->price_amount, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- Order Summary Table -->
                            <table class="table table-hover table-striped table-bordered" align="center">
                                <tbody class="border-bottom">
                                    <tr>
                                        <td style="text-align:right;">
                                            Subtotal: {{ getPrice($order->subtotal, 2) }}<br />
                                            Shipping Charge: {{ getPrice($order->shipping_charge, 2) }}<br />
                                            Discount: {{ getPrice($order->discount, 2) }}<br />
                                            <br />
                                            <strong class="fw-bold">Total:
                                                {{ getPrice($order->grandtotal, 2) }}</strong><br />
                                        </td>
                                    </tr>
                                    @if ($order->basket->remarks)
                                        <tr>
                                            <td>
                                                <center><big><strong>Notes</strong></big></center>
                                                <p class="text-left" style="font-size: 18px;">
                                                    {{ $order->basket->remarks }}</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @csrf
                        <h3 class="fw-bold text-capitalize">
                            Order Status : {!! str_replace('_', ' ', strtolower($order->delivery_status != '' ? $order->delivery_status : $order->status)) !!}
                        </h3>
                        @if ($order->verified_at)
                            <br>
                            <h6> Order Verified at :
                                {{ dateFormat($order->verified_at) . ' ' . TimeFormat($order->verified_at) }}</h6>
                        @endif
                        @if ($order->status == 'pending')
                            <div class="col-lg-12 my-3 d-flex flex-col gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" {{ $order->verified_at ? '' : 'checked' }}
                                        type="radio" name="status" id="notVerified" value="cancelled">
                                    <label class="form-check-label" for="notVerified">
                                        Not Verified / Order Cancellation <small class="text-danger small">(once time
                                            cancelled can't retrieve)</small>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" {{ $order->verified_at ? 'checked' : '' }}
                                        type="radio" name="status" id="Verified" value="confirmed">
                                    <label class="form-check-label" for="Verified">
                                        Verified / Order Confirmed
                                    </label>
                                </div>
                            </div>
                        @elseif($order->status == 'confirmed' && ($order->delivery_status == '' || $order->delivery_status == null))
                            <div class="col-lg-12 my-3 d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" {{ $order->status == 'confirmed' ? 'checked' : '' }}
                                        @disabled(true) type="radio" name="status" id="confirmed"
                                        value="confirmed">
                                    <label class="form-check-label" for="confirmed">
                                        Order Confirmed
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status"
                                        id="READY_FOR_DISPATCH" value="READY_FOR_DISPATCH">
                                    <label class="form-check-label" for="READY_FOR_DISPATCH">
                                        READY FOR DISPATCH
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="mt-3 d-flex gap-3">
                            @if (
                                $order->status == 'pending' ||
                                    ($order->status == 'confirmed' && ($order->delivery_status == '' || $order->delivery_status == null)))
                                <input type="submit" class="btn bg-primary text-light" value="Update">
                            @endif

                        </div>

                    </form>


                    @php
                        // Define order status steps with numerical order
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

                    <!-- 🌟 Custom Styling -->
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



                </div>
            </div>
        </div>
    </div>
@endsection
