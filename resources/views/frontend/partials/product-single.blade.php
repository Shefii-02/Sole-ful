


<!-- product details wrapper start -->
<div class="product-details-wrapper ">
    <div class="container custom-container">
        <div class="row">
            <div class="col-12">
                <!-- product details inner end -->
                <div class="product-details-inner">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="pro-nav slick-row-5 slick-arrow-style d-none">

                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="product-large-slider slick-arrow-style mb-4">

                                    </div>
                                    
                                </div>
                            </div>
                            @php
                                $images = product_images($product->id);
                            @endphp
                            

                            

                        </div>
                        <div class="col-lg-7">
                            <div class="product-details-des">
                                <h3 class="pro-det-title product-title">{{ $product->product_name }}</h3>
                                <small> {{ $product->description }}</small>
                                <div class="price-box">
                                    <span class="regular-price">{{ min_price($product->id) }}</span>
                                </div>
                                <div class="price-box small">
                                    <small>SKU</small> : <span class="text-theme  productSku"></span>
                                </div>
                                <div class="price-box my-3">
                                    <span class="text-success small">Inclusive of all taxes</span>
                                </div>
                           
                                <div class="product__variations">
                                    <h5 class="cat-title mb-3 fw-bolder">Available Sizes :</h5>
                                    <div class="size-tab round-radio">
                                        @foreach ($all_sizes as $size)
                                            <label
                                                class="size-button {{ $sizes->contains('value', $size) ? '' : 'disabled' }}"
                                                data-size-id="{{ $size }}">
                                                <input type="radio" class="hidden {{ $sizes->contains('value', $size) ? 'variSize_checkbox' : 'disabled' }}"
                                                    data-product="{{ $product->id }}" name="size"
                                                    value="{{ $size }}">
                                                <span>{{ $size }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="size-chart mb-2">
                                        <a href="#" class="text-theme" data-bs-toggle="modal"
                                            data-bs-target="#sizeChart">Size Guide</a>
                                    </div>

                                    <div class="color-option1 mb-4">
                                        <h5 class="cat-title mb-3 fw-bolder">Available Colors :</h5>
                                        <div class="color-tab">

                                        </div>
                                    </div>

                                </div>
                                <div class="quantity-cart-box d-flex align-items-center mb-4">
                                    <div class="quantity" x-data="{ quantity: 1 }">
                                        <div class="pro-qty">
                                            <button class="dec qtybtn"
                                                @click="quantity > 1 ? quantity-- : quantity">-</button>
                                            <input id="quantity" type="text" x-model="quantity" readonly>
                                            <button class="inc qtybtn" @click="quantity++">+</button>
                                        </div>
                                    </div>
                                    <button id="addToCartBtn" class="btn btn-dark add-to-cart">Add To Cart</button>
                                </div>
                                {{-- <div class="availability mb-4">
                                    <h5 class="cat-title">Availability:</h5>
                                    <span class="stockStatus text-capitalize">In Stock</span>
                                </div> --}}
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product details wrapper end -->

