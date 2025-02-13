@extends('layouts.email')

@section('content')
    <div style="padding: 0px 30px;">
        <div>
            <div>
                <p style="text-align: center; font-weight: 700; font-size: 30px; margin-top: 10px;">New Order</p>
            </div>


            <table cellpadding="10" cellspacing="0" align="center" border="0" style="border:none;">
                <tr>
                    <td align="center" style="border-right:1px solid #DDD; padding: 10px 15px; ">
                        <big><strong>Order Status <br />{!! $order->status ? '<span style="color:Green;">PENDING' : '<span style="color:Red;">FAILED' !!}</span></strong></big>
                    </td>
                    <td align="center" style="padding: 10px 15px;">
                        <big><strong>Invoice# <br /><span
                                    style="color:#df9b19;">{{ $order->invoice_id }}</span></strong></big>
                    </td>
                </tr>
                <tr align="center">
                    <td align="center" colspan="2" style="padding: 10px 15px;border-top:1px solid #DDD;">
                        <big><strong>Order Amount <br /><span
                                    style="color:#df9b19;">{{ getPrice($order->grandtotal) }}</span></strong></big>
                    </td>
                </tr>
            </table>

            <table cellpadding="10" cellspacing="0" border="0" align="center"
                style="margin:15px auto; border:1px solid #DDD; border-radius:10px;" width="500">
                <tr>
                    {{-- <td align="center">
                        Order ID#:<br /><span style="text-decoration:underline;">{{ $order->id }}</span>
                    </td> --}}
                    <td align="center">
                        Payment Method:<br /><span style="text-decoration:underline;">{{ $order->payment_method }}</span>
                    </td>
                    <td align="center">
                        Trans. ID:<br /><span
                            style="text-decoration:underline;">{{ $order->payments ? $order->payments->transaction_id : '---' }}</span>
                    </td>
                    <td align="center">
                        Reference Id#:<br /><span
                            style="text-decoration:underline;">{{ $order->payments ? $order->payments->reference_id : '---' }}</span>
                    </td>

                </tr>

            </table>

            {{-- @if ($billing_address = $order->address->where('type', 'billing')->first())
                <table width="100%" cellpadding="5" cellspacing="0" align="center"
                    style="background:#EEE; border-radius: 10px; margin:15px auto;width:500px; ">
                    <tr>
                        <th style="text-align:center;text-decoration:underline;">CUSTOMER INFORMATION</th>
                    </tr>
                    <tr>
                        <td style="padding-left: 15px; padding-right:15px; text-align:center;" valign="top">
                            <p style="margin: 0 0 10px 0;">
                                {{ strtoupper($billing_address->firstname . ' ' . $billing_address->lastname) }}<br />{{ $billing_address->address }}<br />
                                {{ strtoupper($billing_address->postalcode) }}
                                <strong>{{ $billing_address->city }}</strong> {{ $billing_address->province }}.</p>
                            <p>
                                Phone: <strong>{{ $billing_address->phone }}</strong><br />
                                Email: <strong>{{ $billing_address->email }}</strong><br />
                            </p>
                        </td>
                    </tr>
                </table>
            @endif --}}


            <!-- Customer Information Table -->

            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;" cellpadding="10" cellspacing="0"
                border="0">
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: center; padding: 20px; background: #f3f3f3;">
                            <span style="font-weight: 800;">Customer Information</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding: 10px; background: #f3f3f3;">
                            <span style="font-weight: 800;">Billing Details</span>
                        </td>
                        <td style="text-align: left; padding: 10px; background: #f3f3f3;">
                            <span style="font-weight: 800;">Delivery Details</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left; padding: 10px; vertical-align: top; width: 50%;">
                            @if ($order->billingAddress)
                                <strong>{{ $order->billingAddress->name }}</strong><br />
                                {{ $order->billingAddress->address }}<br />
                                Building No/Name: #{{ $order->billingAddress->house_no }},
                                {{ $order->billingAddress->house_name }}<br />
                                Landmark: {{ $order->billingAddress->landmark }}<br>
                                {{ $order->billingAddress->pincode }}, {{ $order->billingAddress->locality }},
                                {{ $order->billingAddress->state }}<br>
                                <span style="font-weight: bold;">Phone: <a href="tel:{{ $order->billingAddress->mobile }}"
                                        style="color: #333; text-decoration: none;">{{ $order->billingAddress->mobile }}</a></span><br />
                                <span style="font-weight: bold;">Email: {{ $order->billingAddress->email }}</span>
                            @else
                                No billing address available.
                            @endif
                        </td>
                        <td style="text-align: left; padding: 10px; vertical-align: top; width: 50%;">
                            @if ($order->deliveryAddress)
                                <strong>{{ $order->deliveryAddress->name }}</strong><br />
                                {{ $order->deliveryAddress->address }}<br />
                                House No/Name: #{{ $order->deliveryAddress->house_no }},
                                {{ $order->deliveryAddress->house_name }}<br />
                                Landmark: {{ $order->deliveryAddress->landmark }}<br>
                                {{ $order->deliveryAddress->locality }}, {{ $order->deliveryAddress->pincode }},
                                {{ $order->deliveryAddress->state }}<br>
                                <span style="font-weight: bold;">Phone: <a href="tel:{{ $order->deliveryAddress->mobile }}"
                                        style="color: #333; text-decoration: none;">{{ $order->deliveryAddress->mobile }}</a></span><br />
                                <span style="font-weight: bold;">Email: {{ $order->deliveryAddress->email }}</span>
                            @else
                                No delivery address available.
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Order Items Table -->
            <br>
            <div>
                <table style="width: 100%; border-collapse: collapse;" cellpadding="7" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th style="background: #f3f3f3; text-align: left; padding: 10px;">ITEM</th>
                            <th style="background: #f3f3f3; text-align: left; padding: 10px;">Price</th>
                            <th style="background: #f3f3f3; text-align: center; padding: 10px;">QTY</th>
                            <th style="background: #f3f3f3; text-align: right; padding: 10px;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->basket->items as $item)
                            <tr>
                                <td style="text-align: left; padding: 10px;">
                                    <img src="{{ asset('images/products/' . $item->picture) }}"
                                        style="width: 100px; height: auto;"
                                        onerror="this.onerror=null;this.src='/images/default.jpg';" alt=""><br>
                                    <strong class="text-capitalize">{{ $item->variation }}</strong><br>
                                    <sub class="my-2">{{ $item->product_name }}</sub><br>
                                    <sub class="my-2">SKU: {{ $item->product_sku }}</sub><br>
                                    <sub class="my-2 text-capitalize">{{ $item->special_note }}</sub>
                                </td>
                                <td style="text-align: left; padding: 10px;">{{ number_format($item->price_amount, 2) }}
                                </td>
                                <td style="text-align: center; padding: 10px;">{{ $item->quantity }}</td>
                                <td style="text-align: right; padding: 10px;">
                                    {{ number_format($item->quantity * $item->price_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Grand Total Table -->
            <table cellpadding="7" cellspacing="0" align="right">
                <tr>
                    <th style="text-align: left; padding: 10px;">Subtotal</th>
                    <td style="text-align: right; padding: 10px;">{{ getPrice($order->subtotal) }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 10px;">Discount</th>
                    <td style="text-align: right; padding: 10px;">{{ getPrice($order->discount) }}</td>
                </tr>
                <tr>
                    <th style="text-align: left; padding: 10px;">Shipping</th>
                    <td style="text-align: right; padding: 10px;">{{ getPrice($order->shipping_charge) }}</td>
                </tr>
                @if ($order->grandtotal > 0)
                    <tr>
                        <th style="text-align: left; padding: 10px;"><strong>Grand Total</strong></th>
                        <td style="text-align: right; padding: 10px;"><strong
                                style="color:#df9b19;">{{ getPrice($order->grandtotal) }}</strong></td>
                    </tr>
                @endif
            </table>


            <div style="clear:both;float:none;"></div>
            <div class=""></div>
        </div>
    </div>


    <div style="text-align:center">
   
    </div>
@endsection
