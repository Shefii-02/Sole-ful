@php
    $calculations = json_decode($calculations);
@endphp

<div class="sub-total p-2">
    <p class="f-h">Subtotal</p>
    <p class="f-p sub_total">{{ getPrice($calculations->subTotal) }}
    </p>
</div>
<div class="sub-total p-2">
    <p class="f-h">Discount</p>
    <p class="f-p discount_amount">-{{ getPrice($calculations->Discount) }}</p>
</div>
<div class="sub-total p-2">

        <p class="f-h">Shipping Charge</p>
        <p class="f-p ">Free</p>
   
</div>


<hr>
<div class="cart-product-total p-2">
    <p class="f-h">Total</p>
    <p class="f-p total_price">
        {{ getPrice($calculations->grandTotal) }}
    </p>
</div>