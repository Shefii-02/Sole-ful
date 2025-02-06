@extends('layouts.app')
@push('header')
    <style>
        .guestEmail.element-error::after {
            content: attr(data-error);
            font-size: small;
            color: red;
            text-align: center;
            display: block;
            /* or display: inline-block; */
            margin: 4px auto;
            /* Adjust the margin for spacing */
            padding: 4px;
            /* Adjust the padding for spacing */
        }

        #loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .cart-purchased {
            padding: 20px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .products-checkout {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px
        }

        .products-checkout .p-c {
            display: flex;
            align-items: center;
        }

        .cart-purchased .gift-apply {
            padding: 20px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-purchased .gift-apply input {
            border: 1px solid rgba(0, 0, 0, 0.1);
            width: 70%;
            padding: 7px 10px;
            border-radius: 5px;
        }

        .cart-purchased .gift-apply button {
            width: 28%;
            border: 1px solid #000;
            color: #fff;
            font-size: 12px;
            padding: 9px;
            background: #000;
            border-radius: 5px;
        }

        .calculation_part .sub-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .calculation_part .cart-product-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .products-checkout img {
            border-radius: 20px;
            width: 80px;
            height: 60px;
            object-fit: cover;
        }
    </style>
@endpush


@section('content')

    <div id="loader-overlay" style="display: none;">
        <div class="loader"></div>
    </div>

    <section class="product-listing-banner">
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area bg-img" data-bg="assets/img/breadcrumb-banner.webp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h1 class="breadcrumb-title">Checkout</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('/shop') }}">Shop</a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('/cart') }}">Cart</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
    </section>


    <section class="page_section checkout-overlay  py-5">

        <div class="container-lg">
            <div class="main-content checkout-main-content">

                @if (auth()->check() || !empty($basket->email))
                @else
                    <div class="overlay"></div>
                @endif
                <div class="row billing">

                    <div class="col-md-8">

                        <form action="{{ url('place-order') }}" method="POST" id="place__order" novalidate>
                            @if (auth()->check())
                                @csrf()
                            @else
                            @endif
                            <div class="card">
                                <div class="card-header " id="billingHeading">
                                    <div class="row">
                                        <div class="col-12">
                                            <h2 class="mb-0 fw-bolder">Billing Address</h2>
                                        </div>
                                    </div>
                                </div>
                                <div id="billingCollapse">
                                    <div class="card-body">
                                        @if (auth()->check())
                                            <div class="py-2">
                                                <div class="pt-1">
                                                    <h6 class="mb-0 small">My Addresses</h6>
                                                </div>
                                                <div class="pt-2">
                                                    <ul class="list-group  list-group-flush px-0">
                                                        @php
                                                            $nonBase = 0;
                                                        @endphp

                                                        @foreach (App\Models\Myaddress::whereUserId(auth()->user()->id)->orderBy('base', 'DESC')->get() as $item)
                                                            @php
                                                                if ($item->base == 1 && $nonBase == 0) {
                                                                    $defaultChecked = true;
                                                                    $nonBase = 1;
                                                                }
                                                            @endphp
                                                            <li class="list-group-item border py-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input BillingAdress"
                                                                        type="radio" data-name="{{ $item->name }}"
                                                                        data-address="{{ $item->address }}"
                                                                        data-locality="{{ $item->locality }}"
                                                                        data-landmark="{{ $item->landmark }}"
                                                                        data-house_name="{{ $item->house_name }}"
                                                                        data-state="{{ $item->state }}"
                                                                        data-postal="{{ $item->pincode }}"
                                                                        data-emailval="{{ $item->email }}"
                                                                        data-phone="{{ auth()->user()->mobile }}"
                                                                        name="billing_address" value="{{ $item->id }}"
                                                                        id="BillingRadioaddress{{ $item->id }}"
                                                                        @if ($item->base == 1) checked @endif>
                                                                    <p class="form-check-label"
                                                                        for="BillingRadioaddress{{ $item->id }}">
                                                                        <small
                                                                            class="fw-bolder h6 text-capitalize">{{ $item->name }}</small><br>
                                                                        <small class="fw-bolder h6 ">{{ $item->email }} /
                                                                            {{ $item->mobile }}</small><br>

                                                                        <small
                                                                            class="fw-bolder h6 text-capitalize">{{ $item->address }},{{ $item->landmark }}
                                                                            {{ $item->house_name . ',' }}
                                                                            {{ $item->pincode . ', ' . $item->locality . ', ' . $item->state }}.
                                                                        </small>
                                                                    </p>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                        <li class="list-group-item px-0 text-end"><a href="#"
                                                                data-bs-toggle="modal" class="btn"
                                                                data-bs-target="#newAddressModal"><i
                                                                    class="fa fa-plus me-2"></i>
                                                                Add a new address</a></li>
                                                    </ul>
                                                    @error('billing_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>



                            <div class="form-check form-switch py-4" role="button">
                                <input class="form-check-input" role="button" type="checkbox" id="same_billing"
                                    name="same_billing" value="1">
                                <label class="form-check-label" role="button" for="same_billing">Shipping same as
                                    billing address?</label>
                            </div>
                          
                            <div id="shipping-address-div" class="mb-2" style="">
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-header" id="shippingHeading">
                                            <h2 class="mb-0 fw-bold">Delivery Address</h2>
                                        </div>
                                        <div class="card-body">
                                            <div id="shippingCollapse">
                                                <div class="row address-form">
                                                    <div class="col-lg-4 form-group mb-2">
                                                        <label for="">Full name</label>
                                                        <input class="form-control @error('s_name') is-invalid @enderror"
                                                            autocomplete="off" value="{{ old('s_name') }}" type="text" id="s_name" name="s_name"
                                                            placeholder="">
                                                        @error('s_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 form-group mb-2">
                                                        <label for="">Email</label>
                                                        <input class="form-control @error('s_email') is-invalid @enderror"
                                                            autocomplete="off" value="{{ old('s_email') }}"type="email" name="s_email"
                                                            id="s_email" placeholder="">
                                                        @error('s_email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-4 form-group mb-2">
                                                        <label for="">Phone Number</label>
                                                        <input
                                                            class="form-control phone_field @error('s_phone') is-invalid @enderror"
                                                            autocomplete="off"  value="{{ old('s_phone') }}" type="text" name="s_phone"
                                                            id="s_phone" minlength="10" maxlength="10" placeholder="">
                                                        @error('s_phone')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-12 form-group mb-2">
                                                        <label for="">Address</label>
                                                        <input
                                                            class="form-control address_fill @error('s_address') is-invalid @enderror"
                                                            autocomplete="off" value="{{ old('s_address') }}" type="text" name="s_address"
                                                            id="s_address" placeholder="">
                                                        @error('s_address')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>


                                                    <div class="col-lg-6 form-group mb-2">
                                                        <label for="">Building/Flat Name/No</label>
                                                        <input
                                                            class="form-control @error('s_house_name') is-invalid @enderror"
                                                            autocomplete="off" value="{{ old('s_house_name') }}"  type="text" name="s_house_name"
                                                            id="s_house_name" placeholder="">
                                                        @error('s_house_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div class="col-lg-6 form-group mb-2">
                                                        <label for="">Landmark</label>
                                                        <input
                                                            class="form-control address_fill @error('s_landmark') is-invalid @enderror"
                                                            autocomplete="off" value="{{ old('s_landmark') }}" type="text" name="s_landmark"
                                                            id="s_landmark" placeholder="">
                                                        @error('s_landmark')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 form-group mb-2">
                                                        <label for="">Postal Code</label>
                                                        <input data-state="s_state" data-city="s_locality"
                                                            data-msg="s_msg"
                                                            class="form-control postal_fill postal mb-2 @error('s_postal') is-invalid @enderror"
                                                            autocomplete="off" value="{{ old('s_postal') }}" type="text" name="s_postal"
                                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"
                                                            id="s_postal" maxlength="6" placeholder="">
                                                        <span class="" id="s_msg"></span>
                                                        @error('s_postal')
                                                            <span class="text-danger" id="s_postalErro">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 form-group mb-2">
                                                        <label for="">Locality/City</label>
                                                        <input
                                                            class="form-control locality_fill @error('s_locality') is-invalid @enderror"
                                                            autocomplete="off" value="{{ old('s_locality') }}" type="text" name="s_locality"
                                                            id="s_locality" placeholder="">
                                                        @error('s_locality')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-4 form-group mb-2">
                                                        <label>State</label>
                                                        <input
                                                            class="form-control state_fill @error('s_state') is-invalid @enderror"
                                                            autocomplete="off" value="{{ old('s_state') }}"  type="text" name="s_state"
                                                            id="s_state" placeholder="" required>
                                                        @error('s_state')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 ps-md-0">
                        @if (isset($items) && $items->count() > 0)
                            <div class="cart-purchased mt-3 mt-md-0">
                                <h2 class="fw-bolder pb-2 fs-5">Order Summary</h2>
                                <hr>
                                @foreach ($items as $listing)
                                    @php
                                        if ($listing->has_special_price == 1) {
                                            $checkSpecialPrice =
                                                $listing->product->has_special_price == 1 &&
                                                $listing->product->special_price_from <= date('Y-m-d') &&
                                                $listing->product->special_price_to >= date('Y-m-d');
                                            if (!$checkSpecialPrice && $listing->product->has_special_price == 1) {
                                                \App\Models\Item::where('id', $listing->id)->update([
                                                    'has_special_price' => 0,
                                                    'price_amount' => $listing->product_variation->price,
                                                    'special_price_from' => null,
                                                    'special_price_to' => null,
                                                ]);
                                            }
                                            $listing->refresh();
                                        } else {
                                            $checkSpecialPrice = false;
                                        }

                                    @endphp

                                    <div class="products-checkout col-12 mb-2 products-cart">
                                        <div class="p-c">
                                            <img src="{{ asset('images/products/' . $listing->picture) }}"
                                                onerror="this.onerror=null;this.src='/assets/images/dummy-product.jpg';"
                                                class="h-100" alt="">
                                            <div class="i-content" style="padding-left: 5px">
                                                <p class="f-h">{{ $listing->product_name }}</p>
                                                <p>Qty: {{ $listing->quantity }} </p>
                                                <div class="d-flex">
                                                    <p class="text-theme fw-bold">
                                                        {{ getPrice($listing->price_amount) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="val">
                                            <p>{{ getPrice($listing->price_amount * $listing->quantity) }}</p>
                                        </div>
                                    </div>
                                @endforeach

                                @php
                                    if ($basket->coupon != null) {
                                        $coupon_details = App\Models\Coupon::where('id', $basket->coupon)->first();
                                    }
                                @endphp

                                <div class="gift-apply">
                                    <input type="text" name="gift_code"
                                        value="{{ isset($coupon_details) ? $coupon_details->code : '' }}"
                                        form="place__order" id="coupon_code" placeholder="Coupon code">
                                    <button class="coupon_card_apply">Apply Coupon</button>
                                </div>
                                <div class='w-100 card-alert'
                                    style="border: 1px solid rgba(0, 0, 0, 0.1);padding: 7px 10px;border-radius: 5px;display:none;margin-bottom:5px;font-weight:800">
                                </div>
                                <div class="calculation_part">

                                </div>

                            </div>
                        @else
                            <div class="col-md-12 text-center">
                                <h6 class="font-bold">The cart is empty</h6>
                            </div>
                        @endif
                        <div class="col-md-8 mt-2">

                            <div class="text-start mb-2 mt-3 text-end">
                                <span class="col-lg-12 p-0 g-captcha-error text-danger small"></span><br>
                                <button class="g-recaptcha btn  btn-sm btn-theme py-2"
                                    data-sitekey="{{ config('services.recaptcha_v3.siteKey') }}" data-callback="onSubmit"
                                    data-action="submitORder" form="place__order" type="submit">COMPLETE
                                    PURCHASE</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @if (auth()->check() || !empty($basket->email))
        <!-- Modal -->
        <div class="modal fade checkout-modal" id="newAddressModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header justify-content-between">
                        <h5 class="modal-title fs-4 fw-bold my-2" id="new_ModalLabel">Add Address</h5>
                        <i class="fa fa-times text-dark fa-2x" role="button" data-bs-dismiss="modal"
                            aria-label="Close"></i>
                    </div>

                    <div class="modal-body">
                        <form action="{{ route('account.address.add') }}" method="POST" id="add_address"
                            class="row address-form">
                            @csrf()
                            <div class="col-lg-12 form-group mb-2">
                                <label class="mb-2" for="">Full Name</label>
                                <input type="text" required autocomplete="off" form="add_address"
                                    class="form-control" name="name">
                            </div>
                            <div class="col-lg-6 form-group mb-2">
                                <label class="mb-2" for="email">Email Id</label>
                                <input type="text" autocomplete="off" placeholder="" id="email"
                                    class="form-control address_fill" form="add_address" name="email">
                            </div>
                            <div class="col-lg-6 form-group mb-2">
                                <label class="mb-2" for="mobile">Mobile No</label>
                                <input type="text" autocomplete="off" placeholder="" id="mobile"
                                    class="form-control address_fill" form="add_address" name="mobile">
                            </div>
                            <div class="col-lg-12 form-group mb-2">
                                <label class="mb-2" for="address">Address</label>
                                <input type="text" autocomplete="off" placeholder="" id="newAddress"
                                    class="form-control address_fill" form="add_address" name="address">
                            </div>

                            <div class="col-lg-12 form-group mb-2">
                                <label class="mb-2" for="house_name">Building/Flat Name/No</label>
                                <input type="text" required autocomplete="off" id="house_name" form="add_address"
                                    class="form-control house_name_fill" name="house_name">
                            </div>
                            <div class="col-lg-6 form-group mb-2">
                                <label class="mb-2" for="landmark">Landmark</label>
                                <input type="text" autocomplete="off" id="landmark" placeholder=""
                                    class="form-control landmark_fill" form="add_address" name="landmark">
                            </div>

                            <div class="col-lg-6 form-group mb-2">
                                <label class="mb-2" for="pincode">Postal Code</label>
                                <input type="text" required autocomplete="off" id="pincode" form="add_address"
                                    class="form-control pincode_fill" name="pincode"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');">
                            </div>


                            <div class="col-lg-6 form-group mb-2">
                                <label class="mb-2" for="locality">Locality/City</label>
                                <input type="text" autocomplete="off" placeholder="" id="locality"
                                    class="form-control localityfill" form="add_address" name="locality">
                            </div>

                            <div class="col-lg-6 form-group mb-2">
                                <label class="mb-2" for="state">State</label>
                                <input class="form-control state_fill" form="add_address" autocomplete="off"
                                    type="text" name="state" id="state" placeholder="" required>
                            </div>
                            <div class="col-lg-12 form-group mb-2">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" form="add_address" type="checkbox" name="base"
                                        id="flexSwitchbase">
                                    <label class="form-check-label" for="flexSwitchbase">Default</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="add_address" class="btn btn-theme">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade checkout-modal" id="loginModal" data-bs-backdrop="static" tabindex="-1"
            aria-labelledby="loginModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-lg-12 text-center">
                            <h2 class="fw-bold modal-title fs-1 my-2" id="loginModalLabel">Welcome back!</h2>
                            <p class="h6"> Please log in to continue</p>
                        </div>
                    </div>
                    <div class="modal-body bg-secondary-subtle">

                        <form method="post" id="existingCustomer" action="{{ route('public.signIn') }}" novalidate>
                            @csrf()
                            <!-- Existing Customer Login Form -->
                            <div class="mb-2">
                                <label for="username" class="form-label">Email</label>
                                <input type="email" required class="form-control rounded-pill" id="email"
                                    name="email">
                            </div>
                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" required autocomplete="new-password"
                                    class="form-control rounded-pill" id="password" name="password">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check d-flex justify-content-left mb-2 mb-md-4">
                                        <input class="form-check-input me-2" type="checkbox" value="1"
                                            id="remember" name="remember" aria-describedby="registerCheckHelpText">
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 text-end f-g-pass">
                                    <a target="_blank" href="{{ route('password.request') }}">Forgot password?</a>
                                </div>
                            </div>
                            <div class="text-center ">
                                <button type="submit"
                                    class="btn text-white btn-theme rounded-pill mt-3 mb-2 pe-4 ps-4">Sign In</button>
                            </div>

                            <div class="text-center mt-3">
                                Don't have an account? <a
                                    href="{{ route('register', ['redirection_url' => route('public.checkout')]) }}">Create
                                    new
                                    account</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@push('footer')
    <script>
        $('body').on('change', '#same_billing', function(e) {

            @if (auth()->check())
                var databilling = $("input[name='billing_address']:checked");

                $('#s_name').val(databilling.data('name'));
                $('#s_address').val(databilling.data('address'));
                $('#s_locality').val(databilling.data('locality'));
                $('#s_landmark').val(databilling.data('landmark'));
                $('#s_house_name').val(databilling.data('house_name'));
                $('#s_state').val(databilling.data('state'));
                $('#s_postal').val(databilling.data('postal'));
                $('#s_email').val(databilling.data('emailval'));
                $('#s_phone').val(databilling.data('phone'));
            @endif

        });

        checkAtLeastOneAddressChecked();

        function checkAtLeastOneAddressChecked() {
            var radioGroup = $('input[name="pickup_store"]');
            var checkedCount = radioGroup.filter(':checked').length;

            if (checkedCount === 0) {
                radioGroup.first().prop('checked', true);
            }

            $('.pickuploc').removeClass('selected');
            $('input[name="pickup_store"]:checked').closest('.pickuploc').addClass('selected');
        }


        @if (auth()->check() || !empty($basket->email))
        @else
            $(document).ready(function() {
                // Show the modal after the page has finished loading
                $('#loginModal').modal('show');
            });
        @endif

        function createAccountSwitch() {
            $("#create-account-wrapper").css("display", $("#create_account").is(":checked") ? "block" : "none");
        }

        $(document).ready(function() {
            createAccountSwitch();
        });


        $('body').on('input', '.postal', function() {
            var pin_code = $(this).val();
            var Idstate = $(this).data('state');
            var Idcity = $(this).data('city');
            var Idmsg = $(this).data('msg')
            $('#s_postalErro').text('');

            if (pin_code.length == 6) {
                $.ajax({
                    url: "{{ route('public.pincode.check') }}",
                    cache: false,
                    type: "GET",
                    data: {
                        pin_code: pin_code
                    },
                    success: function(response) {
                        $('#' + Idmsg).attr('class', '');
                        if (response.result) {
                            $('#' + Idmsg).addClass('text-success');
                        } else {
                            $('#' + Idmsg).addClass('text-danger');
                        }

                        $('#' + Idstate).val(response.state)
                        $('#' + Idcity).val(response.city)
                        $('#' + Idmsg).text(response.message)
                    }
                });
            }
        });

        calculationPart();

        function calculationPart() {
            $('.calculation_part').html('');
            $.ajax({
                url: "{{ route('public.checkout.calculation') }}",
                cache: false,
                type: "GET",
                success: function(response) {
                    $('.calculation_part').html(response)
                }
            });
        }

        $('body').on('click', '.coupon_card_apply', function() {
            var gift_code = $('#coupon_code').val();
            $('.card-alert').show();
            $('.card-alert').html('');
            if (gift_code.length > 1) {
                $.ajax({
                    url: "{{ route('public.gift-code-apply') }}",
                    cache: false,
                    type: "GET",
                    data: {
                        gift_code: gift_code
                    },
                    success: function(response) {
                        $('.card-alert').html(response.msg);
                        calculationPart();
                    }
                });
            } else {
                $('.card-alert').html('');
            }
        });

        @if ($basket->coupon != null)
            jQuery('.coupon_card_apply').trigger('click');
        @endif
    </script>
    <script>
        function calculate_ttl() {
            var sub_ttl = $('.sub_total').text().replace('$', '');
            var shipping_charge = $('.shipping_pickup_charge').text().replace('$', '');

            var tax_amount = $('.tax_amount').text().replace('$', '');
            var discount_amount = $('.discount_amount').text().replace('-$', '');


            var ttl_prices = ((parseFloat(sub_ttl) + parseFloat(shipping_charge) + parseFloat(tax_amount)) - parseFloat(
                discount_amount)).toFixed(2);;
            $('.total_price').text('$' + ttl_prices)

        }
    </script>

    {{-- <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=initAutocomplete&libraries=places,geometry&v=weekly"
        defer loading=async></script>

    <script>
        function initAutocomplete() {
            const input = document.getElementById("newAddress");
            const options = {
                strictBounds: false,
                types: ['establishment'],
                componentRestrictions: {
                    country: 'IN', // Restrict to India
                }
            };

            const autocomplete = new google.maps.places.Autocomplete(input, options);

            autocomplete.addListener("place_changed", () => {

                const place = autocomplete.getPlace();

                if (!place.geometry || !place.geometry.location) {

                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }
               
              
            });
        }

    </script> --}}
@endpush
