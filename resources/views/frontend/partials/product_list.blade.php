@forelse ($products ?? [] as $product)
{{-- @dump($product->variationkey) --}}
    <div class="col-lg-4 col-sm-6">
        <!-- product grid item start -->
        <div class="product-item mb-53">
            <div class="product-thumb">
                <a target="_blank"
                    href="{{ route('public.product', ['uid' => $product->product->unique_value, 'slug' => $product->product->slug,'color' => $product->color_name]) }}">
                    <img src="{{ isset($product->MainThumbImage) && $product->MainThumbImage->image ? asset('images/products/' . $product->MainThumbImage->image) : asset('images/default.jpg') }}"
                        alt=""> </a>
            </div>
            <div class="product-content">
                <a target="_blank"
                    href="{{ route('public.product', ['uid' => $product->product->unique_value, 'slug' => $product->product->slug,'color' => $product->color_name]) }}">
                    <h5 class="product-name">
                        {{ $product->v_name }}
                    </h5>
                    <div class="price-box">
                        <div class="">
                            <small>Sizes :
                                @foreach ($product->product->variationSizes->unique('value')->pluck('value') ?? [] as $abSize)
                                    <i class="text-grey">{{ $abSize }},</i>
                                @endforeach
                            </small>
                        </div>
                        <div class="my-2">
                            <small>Colors :
                                @foreach ($product->product->variationColors->unique('value')->pluck('value') ?? [] as $abColor)
                                    <i class="text-grey">{{ $abColor }},</i>
                                @endforeach
                            </small>
                        </div>
                        <span class="price-regular">
                            {{ getPrice($product->price) }}</span>
                    </div>
                </a>
                <div class="product-action-link">
                    <a href="#" id="wishlist-btn-{{ $product->product->id }}" class="wishlist-btn"
                        data-product-id="{{ $product->product->id }}" title="Add To Wishlist"><i
                            class="bi bi-heart"></i></a>
                    <a href="#" data-bs-toggle="modal" data-product-id="{{ $product->product->id }}"
                        data-bs-target="#quick_view" class="quick_view-btn" title="Add To Cart"><i
                            class="bi bi-bag-check"></i></a>
                    <a target="_blank"
                        href="{{ route('public.product', ['uid' => $product->product->unique_value, 'slug' => $product->product->slug,'color' => $product->color_name]) }}">
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
                    href="{{ route('public.product', ['uid' => $product->product->unique_value, 'slug' => $product->product->slug,'color' => $product->color_name]) }}">
                    <img src="{{ isset($product->MainThumbImage) && $product->MainThumbImage->image ? asset('images/products/' . $product->MainThumbImage->image) : asset('images/default.jpg') }}"
                        alt="product thumb">
                </a>
            </div>
            <div class="product-content-list">
                <a target="_blank" href="{{ route('public.product', ['uid' => $product->product->unique_value, 'slug' => $product->product->slug,'color' => $product->color_name]) }}">
                    <h5 class="product-name">
                        {{ $product->v_name }}
                    </h5>
                    <div class="price-box">
                        <span class="price-regular">
                            {{ getPrice($product->price) }}</span>
                    </div>
                </a>
                    <p>{{ $product->product->description }}</p>
                    <div class="product-link-2 position-static">
                        <a href="#" id="wishlist-btn-{{ $product->product->id }}" class="wishlist-btn"
                            data-product-id="{{ $product->product->id }}" title="Add To Wishlist"><i
                                class="bi bi-heart"></i></a>
                        <a href="#" data-bs-toggle="modal" data-product-id="{{ $product->product->id }}"
                            data-bs-target="#quick_view" class="quick_view-btn" title="Add To Cart"><i
                                class="bi bi-bag-check"></i></a>
                        <a target="_blank"
                            href="{{ route('public.product', ['uid' => $product->product->unique_value, 'slug' => $product->product->slug,'color' => $product->color_name]) }}">
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
            No Product Found
        </p>
    </div>
@endforelse
