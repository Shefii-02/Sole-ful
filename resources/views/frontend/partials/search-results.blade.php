    @forelse ($products ?? [] as $product)
        <li class="px-4 {{ $loop->first ? "mt-10" : '' }} py-2 hover:bg-gray-200 cursor-pointer rounded-2xl text-capitalize">
            <a target="_blank"
                href="{{ route('public.product', ['uid' => $product->product->unique_value, 'slug' => $product->product->slug, 'color' =>$product->color_name ]) }}">
                <div class="row">
                    <div class="col-2 d-flex align-items-center">
                        <img onerror="this.onerror=null;this.src='/images/default.jpg';"
                            src="{{ asset('images/products/' . ($product->product->MainThumbImage->image ?? '')) }}"
                            class="w-20 rounded-2">
                    </div>
                    <div class="col-10">
                        <span>{{ $product->v_name }}</span><br>
                        <small>{{ getPrice($product->product->minPrice) }}</small>
                    </div>
                </div>
            </a>
        </li>
    @empty
        <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer rounded-2xl">
            <div class="row">
                <div class="col-12 d-flex align-items-center">
                    No Products Found..
                </div>
            </div>
        </li>
    @endforelse

    @if (isset($products) && $products->isNotEmpty())
        <li class="w-full px-4 py-2 position-absolute top-0 text-center bg-gray-100 border-top rounded-2xl">
            <small class="text-muted fw-bold">{{ $products->count() }} Results Found</small>
        </li>
    @endif

