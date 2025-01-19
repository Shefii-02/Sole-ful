@foreach ($products ?? [] as $product)
    <div class="col-12 my-2 wishlist-item">
        <div class="row">
            <div class="col-4">
                {{-- <a target="_blank" href="{{ route('public.product', , ['uid' => $product->unique_value, 'slug' => $product->slug]) }}"> --}}
                    <img class="rounded-5" src="{{ asset('images/products/' . ($product->MainThumbImage->image ?? '')) }}"
                        alt="{{ $product->product_name }}">
                {{-- </a> --}}
            </div>
            <div class="col-8">
                <div class="col-12 h-5 mb-2">
                    <h5 class="product-name">
                        <a target="_blank"
                            href="{{ route('public.product', ['uid' => $product->unique_value, 'slug' => $product->slug]) }}">{{ $product->product_name }}</a>
                    </h5>
                </div>
                <div class="col-11 h-5 mb-2">
                    <span class="price-regular small fw-semibold">
                        ₹ {{ number_format($product->minPrice) }}</span>
                </div>
                <div class="d-flex gap-2  mt-3">
                    <a href="#" id="wishlist-btn-{{ $product->id }}"
                        class="wishlist-btn-remove btn rounded-5 bg-body-secondary border-0"
                        data-product-id="{{ $product->id }}" title="Add To Wishlist"><i
                            class="bi bi-heart-fill"></i></a>
                    <a target="_blank" href="{{ route('public.product', ['uid' => $product->unique_value, 'slug' => $product->slug]) }}" class="btn rounded-5 bg-body-secondary border-0"
                        data-bs-target="#quick_view">
                        <span title="Detail View">
                            <i class="ion-ios-eye-outline"></i>
                        </span>
                    </a>
                    <a  data-bs-toggle="modal"  data-product-id="{{ $product->id }}"  data-bs-target="#quick_view" title="Add To Cart" class="btn rounded-5 bg-body-secondary border-0 quick_view-btn">
                        <i class="bi bi-bag-check-fill"></i>
                    </a> 
                </div>
            </div>
        </div>
        @if (!$loop->last)
            <hr class="my-1"/>
        @endif
    </div>
 
@endforeach
