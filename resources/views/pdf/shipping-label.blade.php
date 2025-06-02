<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shipping Label</title>
    <style>
        @page {
            size: 4in 6in; /* Specify exact size */
            margin: 0; /* Remove default margin */
        }

        body {
            width: 4in;
            height: 6in;
            margin: 0;
            padding: 10px; /* Adjust padding as needed */
            font-family: Arial, sans-serif;
            line-height: 1.4;
            box-sizing: border-box;
        }

        h2 {
            font-size: 14pt;
            margin-bottom: 5px;
        }

        p {
            font-size: 10pt;
            margin: 0 0 4px 0;
        }

        .separator {
            border-top: 1px solid black;
            margin: 8px 0;
        }

        @media print {
            body {
                width: 4in;
                height: 6in;
            }
        }
    </style>
</head>
<body>

    <h2>Ship To:</h2>
    @if ($order->deliveryAddress)
        <p>{{ $order->deliveryAddress->name }}<br>
           {{ $order->deliveryAddress->address }}<br>
           #{{ $order->deliveryAddress->house_no }},{{ $order->deliveryAddress->house_name }}<br>
           {{ $order->deliveryAddress->landmark }}<br>
           {{ $order->deliveryAddress->pincode }}, {{ $order->deliveryAddress->locality }}, {{ $order->deliveryAddress->state }}<br>
        </p>
    @else
        <p>No delivery address available.</p>
    @endif

    <p>Phone: 919886008064 / 9901711315</p>

    <div class="separator"></div>

    <h2>From:</h2>
    <p>Soleful Ahdhia,<br>
       #5, 1st floor, Geddalahalli,<br>
       Hennur Bagalur Main Road, Bangalore - 560077.</p>
    <p>Website: <a href="http://www.soleful.in">www.soleful.in</a><br>
       Email: <a href="mailto:relationship@soleful.in">relationship@soleful.in</a><br>
       Phone: +91 79966 66225</p>

    <div class="separator"></div>

    <h2>Mode of Payment:</h2>
    <p>Prepaid</p>
  <script>
        window.print();
    </script>
</body>
</html>
