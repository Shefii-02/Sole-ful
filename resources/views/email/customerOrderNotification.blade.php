@extends('layouts.email')

@section('content')
    <div style="padding: 0px 30px;">
        <div>
            <div>
                <p style="text-align: center; font-weight: 700; font-size: 30px; margin-top: 10px;">Your order is on its way</p>
            </div>

            <!-- Order Status and Invoice Details -->
            <table cellpadding="10" cellspacing="0" align="center" border="0" style="border:none; width: 100%;">
                <tr>
                    <td align="center">
                        <big><strong>Order Status: <span style="color:Green;">Processing</span></strong></big>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <big><strong>Invoice#: <span style="color:#df9b19;">{{ $order->invoice_id }}</span></strong></big>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <big><strong>Order Amount:</strong> <span style="color:#df9b19;">{{ getPrice($order->grandtotal) }}</span></big>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <img style="width: 100px;" src="https://cdn.dribbble.com/users/3670719/screenshots/11315097/media/cea1ccb72bd93e291c398f6b40313c64.gif" alt="">
                    </td>
                </tr>
            </table>

            <!-- Order Inquiry Button -->
            <div style="text-align:center; margin:15px;">
                <a target="_new" href="{{ url('order-inquiry?token='.$order->basket->session.'&invoiceId='.$order->invoice_id.'&activatedSession='.md5($order->basket->session)) }}" style="margin:15px auto; padding:7px 10px; border-radius:5px;background-color:#df9b19;color:#fff;opacity: 1;text-decoration:none;">Track order</a>
            </div>

            <!-- Customer Information Table -->
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;" cellpadding="10" cellspacing="0" border="0">
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
                                Building No/Name: #{{ $order->billingAddress->house_no }}, {{ $order->billingAddress->house_name }}<br />
                                Landmark: {{ $order->billingAddress->landmark }}<br>
                                {{ $order->billingAddress->pincode }}, {{ $order->billingAddress->locality }}, {{ $order->billingAddress->state }}<br>
                                <span style="font-weight: bold;">Phone: <a href="tel:{{ $order->billingAddress->mobile }}" style="color: #333; text-decoration: none;">{{ $order->billingAddress->mobile }}</a></span><br />
                                <span style="font-weight: bold;">Email: {{ $order->billingAddress->email }}</span>
                            @else
                                No billing address available.
                            @endif
                        </td>
                        <td style="text-align: left; padding: 10px; vertical-align: top; width: 50%;">
                            @if ($order->deliveryAddress)
                                <strong>{{ $order->deliveryAddress->name }}</strong><br />
                                {{ $order->deliveryAddress->address }}<br />
                                House No/Name: #{{ $order->deliveryAddress->house_no }}, {{ $order->deliveryAddress->house_name }}<br />
                                Landmark: {{ $order->deliveryAddress->landmark }}<br>
                                {{ $order->deliveryAddress->locality }}, {{ $order->deliveryAddress->pincode }}, {{ $order->deliveryAddress->state }}<br>
                                <span style="font-weight: bold;">Phone: <a href="tel:{{ $order->deliveryAddress->mobile }}" style="color: #333; text-decoration: none;">{{ $order->deliveryAddress->mobile }}</a></span><br />
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
                                    <img src="{{ asset('images/products/' . $item->picture) }}" style="width: 100px; height: auto;" onerror="this.onerror=null;this.src='/images/default.jpg';" alt=""><br>
                                    <strong class="text-capitalize">{{ $item->variation }}</strong><br>
                                    <sub class="my-2">{{ $item->product_name }}</sub><br>
                                    <sub class="my-2">SKU: {{ $item->product_sku }}</sub><br>
                                    <sub class="my-2 text-capitalize">{{ $item->special_note }}</sub>
                                </td>
                                <td style="text-align: left; padding: 10px;">{{ number_format($item->price_amount, 2) }}</td>
                                <td style="text-align: center; padding: 10px;">{{ $item->quantity }}</td>
                                <td style="text-align: right; padding: 10px;">{{ number_format($item->quantity * $item->price_amount, 2) }}</td>
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
@endsection