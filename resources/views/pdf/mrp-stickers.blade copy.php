<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MRP Label (3x1.25 inches)</title>
    <style>
        @page {
            size: 3in 1.25in;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            width: 3in;
            height: 1.25in;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .label {
            padding: 4px;
            border: 1px solid #000;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
        }

        .left,
        .right {
            width: 48%;
        }

        h4 {
            margin: 2px 0;
            font-size: 6.5pt;
            font-weight: bold;
            color: #333;
        }

        p {
            margin: 2px 0;
            font-size: 5.5pt;
            color: #555;
        }

        .mrp-highlight {
            color: #D32F2F;
            font-weight: bold;
            font-size: 6.5pt;
        }

        .product-image {
            width: 18px;
            height: auto;
            margin-top: 2px;
        }

        @media print {
            .label {
                border: none !important;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    @foreach ($variations as $variation)
        @for ($i = 0; $i < $variation->in_stock; $i++)
            <div class="label">
                <div class="left">
                    <h4>Packed & Marketed By:</h4>
                    <p>Voche The Interior Studio<br>
                        #5, 1st floor, Geddalahalli,<br>
                        Hennur Bagalur Main Road, Bangalore</p>
                    <p><strong>MFG By:</strong><br>
                        Universal Exports,<br>
                        Gala No 101 to 108,<br>
                        Arihant Commercial Complex,<br>
                        Koper Bus Stop, Purna Village, Bhiwandi,<br>
                        Dist-Thane 421302</p>
                </div>
                <div class="right">
                    <p>
                        Article No: {{ $variation->product->art_code }}<br>
                        Colour:
                        {{ $variation->variationkey ? $variation->variationkey->where('type', 'color')->first()->value ?? '-' : '-' }}<br>
                        Size:
                        {{ $variation->variationkey ? $variation->variationkey->where('type', 'size')->first()->value ?? '-' : '-' }}<br>
                        Month & Year: 03/2025<br>
                        Origin: India<br>
                        Qty: 1 Pair
                    </p>
                    <p>
                        MRP: <span class="mrp-highlight">Rs.{{ $variation->price }}</span><br>
                        <small>(Incl. taxes)</small>
                    </p>
                    <img src="{{ asset('images/products/' . ($variation->main_thumb_image->image ?? 'default.jpg')) }}"
                        alt="Product" class="product-image">
                </div>
            </div>
        @endfor
    @endforeach

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>

</html>
