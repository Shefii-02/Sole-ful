<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice {
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        .details {
            display: flex;
            justify-content: space-between;
        }

        .details div {
            width: 30%;
        }

        .items {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items th {
            border: 1px solid #000;
        }

        .items td {
            border-right: 1px solid #000;
            border-bottom: none;
        }

        .items th,
        .items td {
            /* border: 1px solid #000; */
            padding: 5px;
            text-align: left;
        }

        footer .payment-info {

            padding: 5px;
            /* border: 1px solid black; */
        }

        footer .company-signature {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <header>
            <div style="display:flex;justify-content:between">
                <div style="width:50%;text-align:left">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" style="width:50px">
                </div>
                <div style="width:50%;text-align:">
                    <div style="line-height: 0.3">
                        <h4>Tax Invoice/Bill of Supply/Cash Memo</h4>
                        <span>(Original for Recipient)</span>
                    </div>
                </div>
            </div>
        </header>
        <section class="details">
            <div class="sold-by">
                <h4>Sold By:</h4>
                <p>VOCHE THE INTERIOR STUDIO</p>
                <p># 5, Ground & 1st Floor, Geddalahalli, Hennur<br>
                    Bagalur Main Road, Kothanur Post,<br>
                    Bangalore, Karnataka<br>
                    India - 560077</p>
            </div>

            <div class="billing-address">
                <h4>Billing Address:</h4>
                @if ($order->billingAddress)
                    <p>{{ $order->billingAddress->name }}<br>
                        {{ $order->billingAddress->address }}<br />
                        #{{ $order->billingAddress->house_no }},{{ $order->billingAddress->house_name }}
                        {{ $order->billingAddress->landmark }}<br>
                        {{ $order->billingAddress->locality }},{{ $order->billingAddress->pincode }}.

                    </p>
                @else
                    No billing address available.
                @endif
            </div>
        </section>
        <hr>
        <section class="details">

            <div class="invoice-info">
                <p>PAN No: AARPK5605J</p>
                <p>GST Registration No: 29AARPK5605J1Z8</p>

            </div>
            <div class="shipping-address">
                <h4>Shipping Address:</h4>
                @if ($order->deliveryAddress)
                    <p>{{ $order->deliveryAddress->name }}<br>
                        {{ $order->deliveryAddress->address }}<br />
                        #{{ $order->deliveryAddress->house_no }},{{ $order->deliveryAddress->house_name }}<br />
                        {{ $order->deliveryAddress->landmark }},<br />
                       {{ $order->deliveryAddress->locality }},{{ $order->deliveryAddress->pincode }}.
                    </p>
                    Place of supply: KARNATAKA<br>
                    Place of Delivery: {{ $order->deliveryAddress->state }}
                @else
                    No delivery address available.
                @endif
            </div>
        </section>
        <section class="details">
            <div class="invoice-info">
                <p>Invoice Number: {{ $order->invoice_id }}</p>
                <p>Invoice Date: {{ dateFormat($order->billed_at) }}</p>

            </div>
            <div class="shipping-address">

                <p> Transation No: {{ $order->payments?->transaction_id ?? 'N/A' }}<br>
                    Reference#: {{ $order->payments?->reference_id ?? 'N/A' }}<br>
                    Order Date: {{ dateFormat($order->billed_at) }}</p>
            </div>
        </section>

        <table class="items">

            <tr>
                <th>Sl. No.</th>
                <th>Description</th>
                <th>HSN</th>
                <th>Quantity</th>
                <th>Rate (₹)</th>
                {{-- <th>Discount</th> --}}
                <th>Amount (₹)</th>
                <th style="text-align:center;padding:0;">
                    IGST
                    <div style="width:100%;display:flex;">
                        <div
                            style="width: 30%;border-right:0.5px solid #000;border-top:1px solid #000;height:40px;padding:3px;">
                            Rate (%)
                        </div>
                        <div style="width: 70%;padding:5px;height:40px;border-top:1px solid #000;">Amt. (₹)</div>
                    </div>
                </th>
                <th style="text-align:center;padding:0;">
                    CGST
                    <div style="width:100%;display:flex;">
                        <div
                            style="width: 30%;border-right:1px solid #000;border-top:1px solid #000;height:40px;padding:3px;">
                            Rate (%)</div>
                        <div style="width: 70%;padding:5px;height:40px;border-top:1px solid #000;">Amt. (₹)</div>
                    </div>
                </th>
                <th style="text-align:center;padding:0;">
                    SGST/UTGST
                    <div style="width:100%;display:flex;">
                        <div
                            style="width: 30%;border-right:1px solid #000;border-top:1px solid #000;height:40px;padding:3px;">
                            Rate (%)</div>
                        <div style="width: 70%;padding:5px;height:40px;border-top:1px solid #000;">Amt. (₹)</div>
                    </div>
                </th>
            </tr>

            <tbody>
                @foreach ($order->basket->items as $key => $item)
                    @php
                        $totalAmount = $item->quantity * $item->price_amount;
                        if ($totalAmount < 1000) {
                            $cgstRate = 6;
                            $sgstRate = 6;
                        } else {
                            $cgstRate = 9;
                            $sgstRate = 9;
                        }
                        $cgstAmount = ($cgstRate / 100) * $totalAmount;
                        $sgstAmount = ($sgstRate / 100) * $totalAmount;
                    @endphp
                    <tr>
                        <td style="text-align: center">{{ $key + 1 }}</td>
                        <td>{{ $item->product_name }}<br>SKU : {{ $item->product_sku }}</td>
                        <td>64059000</td>
                        <td style="text-align:center">{{ $item->quantity }}</td>
                        <td style="text-align:right">{{ number_format($item->price_amount, 2) }}</td>
                        <td style="text-align:right">{{ number_format($totalAmount, 2) }}</td>
                        {{-- IGST (If needed, but in your example it's blank) --}}
                        <td style="text-align:center;padding:0;">
                            <div style="width:100%;display:flex;">
                                <div
                                    style="width:30%;border-right:1px solid #000;height:110px;padding:5px;display:flex;align-items:center;justify-content:center;">
                                    -
                                </div>
                                <div
                                    style="width:70%;padding:5px;height:110px;display:flex;align-items:center;justify-content:center;">
                                    -
                                </div>
                            </div>
                        </td>
                        {{-- CGST --}}
                        <td style="text-align:center;padding:0;">
                            <div style="width:100%;display:flex;">
                                <div
                                    style="width:30%;border-right:1px solid #000;height:110px;padding:5px;display:flex;align-items:center;justify-content:center;">
                                    {{ $cgstRate }}%
                                </div>
                                <div
                                    style="width:70%;padding:5px;height:110px;display:flex;align-items:center;justify-content:center;">
                                    {{ number_format($cgstAmount, 2) }}
                                </div>
                            </div>
                        </td>
                        {{-- SGST --}}
                        <td style="text-align:center;padding:0;">
                            <div style="width:100%;display:flex;">
                                <div
                                    style="width:30%;border-right:1px solid #000;height:110px;padding:5px;display:flex;align-items:center;justify-content:center;">
                                    {{ $sgstRate }}%
                                </div>
                                <div
                                    style="width:70%;padding:5px;height:110px;display:flex;align-items:center;justify-content:center;">
                                    {{ number_format($sgstAmount, 2) }}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach



                <tr>
                    <th colspan="10">
                        <div style="display:flex;justify-content: space-between;">
                            <p>
                                Discount : <br>
                                TOTAL:
                                <br>
                                Total invoice value (In words):
                            </p>
                            <p style="text-align:right">
                                {{ getPrice($order->discount, 2) }}
                                <br>
                                {{ getPrice($order->grandtotal, 2) }}/- <br>
                                Rupees {{ convertNumberToWords($order->grandtotal) }}
                            </p>
                        </div>
                    </th>
                </tr>

            </tbody>

        </table>

        <footer>
            <div class="payment-info">
                <span>
                    Mode of Payment: Prepaid
                </span>

            </div>
            <div class="company-signature">

                <p>for VOCHE THE INTERIOR STUDIO</p><br><br>
                <p>Authorised Signatory</p>
                <br><br><br>
            </div>
        </footer>
        <div style="text-align:center">
            <p>Declaration: We declare that this invoice shows the actual price of the goods described and that all
                particulars are true and correct.</p>
            <p>This is a Computer Generated Invoice</p>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
