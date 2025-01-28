@forelse ($products ?? [] as $product)
    <div class="col-lg-4 col-sm-6">
        <!-- product grid item start -->
        <div class="product-item mb-53">
            <div class="product-thumb">
                <a target="_blank"
                    href="{{ route('public.product', ['uid' => $product->unique_value, 'slug' => $product->slug]) }}">
                    <img src="{{ isset($product->MainThumbImage) && $product->MainThumbImage->image ? asset('images/products/' . $product->MainThumbImage->image) : asset('images/default.jpg') }}"
                        alt=""> </a>
            </div>
            <div class="product-content">
                <h5 class="product-name">
                    <a target="_blank"
                        href="{{ route('public.product', ['uid' => $product->unique_value, 'slug' => $product->slug]) }}">{{ $product->product_name }}</a>
                </h5>
                <div class="price-box">
                    <span class="price-regular">₹
                        {{ number_format($product->minPrice) }}</span>
                </div>
                <div class="product-action-link">
                    <a href="#" id="wishlist-btn-{{ $product->id }}" class="wishlist-btn"
                        data-product-id="{{ $product->id }}" title="Add To Wishlist"><i class="bi bi-heart"></i></a>
                    <a href="#" data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                        data-bs-target="#quick_view" class="quick_view-btn" title="Add To Cart"><i
                            class="bi bi-bag-check"></i></a>
                    <a target="_blank"
                        href="{{ route('public.product', ['uid' => $product->unique_value, 'slug' => $product->slug]) }}">
                        <span title="Detail View">
                            <i class="ion-ios-eye-outline"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- product grid item end -->

        <!-- product list item start -->
        <div class="product-list-item mb-30">
            <div class="product-thumb">
                <a target="_blank"
                    href="{{ route('public.product', ['uid' => $product->unique_value, 'slug' => $product->slug]) }}">
                    <img src="{{ asset('images/products/' . ($product->MainThumbImage->image ?? '')) }}"
                        alt="product thumb">
                </a>
            </div>
            <div class="product-content-list">
                <h5 class="product-name">
                    <a target="_blank"
                        href="{{ route('public.product', ['uid' => $product->unique_value, 'slug' => $product->slug]) }}">{{ $product->product_name }}</a>
                </h5>
                <div class="price-box">
                    <span class="price-regular">₹
                        {{ number_format($product->minPrice) }}</span>
                </div>
                <p>{{ $product->care_instruction }}</p>
                <div class="product-link-2 position-static">
                    <a href="#" id="wishlist-btn-{{ $product->id }}" class="wishlist-btn"
                        data-product-id="{{ $product->id }}" title="Add To Wishlist"><i class="bi bi-heart"></i></a>
                    <a href="#" data-bs-toggle="modal" data-product-id="{{ $product->id }}"
                        data-bs-target="#quick_view" class="quick_view-btn" title="Add To Cart"><i
                            class="bi bi-bag-check"></i></a>
                    <a target="_blank"
                        href="{{ route('public.product', ['uid' => $product->unique_value, 'slug' => $product->slug]) }}">
                        <span title="Detail View">
                            <i class="ion-ios-eye-outline"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <!-- product list item start -->
    </div>
@empty
    <div class="text-center">
        <h2 class="my-3 fs-2">Sorry !</h2>
        <p>
            no product found
        </p>
    </div>
@endforelse
