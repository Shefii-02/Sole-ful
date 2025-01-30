@extends('admin.layouts.print-only')


@section('title', 'Invoice-' . $order->invoice_id)
@section('content')


    <div class="col-span-12">
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-4 pb-2 dark:border-strokedark md:px-6 xl:px-7.5">
                <div class="col-lg-12 py-3">
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
                                    Order At: {{ dateFormat($order->billed_at) . ' ' . TimeFormat($order->billed_at) }}</br>
                                    Client Id: {{ $order->user_id }}
                                </td>
                                <td align="left" valign="top" width="50%">
                                    Delivery Date:
                                    <strong>{{ $order->delivery_at ? dateFormat($order->delivery_at) : 'N/A' }}</strong><br>
                                    Transaction#: <strong>{{ $order->payments?->transaction_id ?? 'N/A' }}</strong><br />
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
                                            {{ $order->billingAddress->pincode }}, {{ $order->billingAddress->locality }},
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
                                        <strong class="fw-bold">Total: {{ getPrice($order->grandtotal, 2) }}</strong><br />
                                    </td>
                                </tr>
                                @if ($order->basket->remarks)
                                    <tr>
                                        <td>
                                            <center><big><strong>Notes</strong></big></center>
                                            <p class="text-left" style="font-size: 18px;">{{ $order->basket->remarks }}</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection




@push('footer')
    <script>
        window.print();

        // Listen for the 'afterprint' event, which is triggered after the print dialog is closed
        window.addEventListener('afterprint', function() {
            // Close the window if the user completed the print action
            window.close();
        });

        // Listen for the 'beforeprint' event, which is triggered before the print dialog opens
        window.addEventListener('beforeprint', function() {
            // Prevent the window from closing if the user cancels the print action
            window.onbeforeunload = function() {
                return "You have canceled the print action. Do you want to leave this page?";
            };
        });
    </script>
@endpush
