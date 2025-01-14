@foreach ($products ?? [] as $product)
<div class="col-lg-4 col-sm-6">
    <!-- product grid item start -->
    <div class="product-item mb-53">
        <div class="product-thumb">
            <a target="_blank" href="{{ route('public.product', $product->slug) }}">
                <img src="{{ asset('images/products/' . ($product->MainThumbImage->image ?? '')) }}"
                    alt="">
            </a>
        </div>
        <div class="product-content">
            <h5 class="product-name">
                <a target="_blank"
                    href="{{ route('public.product', $product->slug) }}">{{ $product->product_name }}</a>
            </h5>
            <div class="price-box">
                <span class="price-regular">₹
                    {{ number_format($product->minPrice) }}</span>
            </div>
            <div class="product-action-link">
                <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                        class="ion-android-favorite-outline"></i></a>
                <a href="#" data-bs-toggle="tooltip" title="Add To Cart"><i
                        class="ion-bag"></i></a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#quick_view">
                    <span data-bs-toggle="tooltip" title="Quick View"><i
                            class="ion-ios-eye-outline"></i></span> </a>
            </div>
        </div>
    </div>
    <!-- product grid item end -->

    <!-- product list item start -->
    <div class="product-list-item mb-30">
        <div class="product-thumb">
            <a target="_blank" href="{{ route('public.product', $product->slug) }}">
                <img src="{{ asset('images/products/' . ($product->MainThumbImage->image ?? '')) }}"
                    alt="product thumb">
            </a>
        </div>
        <div class="product-content-list">
            <h5 class="product-name">
                <a target="_blank"
                    href="{{ route('public.product', $product->slug) }}">{{ $product->product_name }}</a>
            </h5>
            <div class="price-box">
                <span class="price-regular">₹
                    {{ number_format($product->minPrice) }}</span>
            </div>
            <p>{{ $product->care_instruction }}</p>
            <div class="product-link-2 position-static">
                <a href="#" data-bs-toggle="tooltip" title="Wishlist"><i
                        class="ion-android-favorite-outline"></i></a>
                <a href="#" data-bs-toggle="tooltip" title="Add To Cart"><i
                        class="ion-bag"></i></a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#quick_view">
                    <span data-bs-toggle="tooltip" title="Quick View"><i
                            class="ion-ios-eye-outline"></i></span> </a>
            </div>
        </div>
    </div>
    <!-- product list item start -->
</div>
@endforeach