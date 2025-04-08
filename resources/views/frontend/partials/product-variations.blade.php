

@foreach ($variations as $index => $variation)
    @php
        // Get the color variation key
        $color = $variation->variationkey->where('type', 'color')->first();

        // Find the product image based on type priority and pivot variation ID
        $productImage = $variation->images->where('pivot.variation_id', $variation->id)
            ->where('type', 'Main Image')->first()
            ?? $variation->images->where('pivot.variation_id', $variation->id)
                ->where('type', 'Thumbnail')->first()
            ?? $variation->images->where('pivot.variation_id', $variation->id)
                ->where('type', 'Extra Image')->first();
    @endphp

    @if ($color && $productImage)
        <label class="color-button text-center {{ $index === 0 ? 'active' : '' }}" data-color="{{ $color->value }}">
            <img class="w-20" src="{{ asset('images/products/' . $productImage->image) }}"
                alt="{{ strtolower($color->value) }}">
            <span class="small text-capitalize">{{ strtolower($color->value) }}</span>
            <input type="radio" class="hidden variColor_checkbox" data-stock="{{ $variation->in_stock > 0  ? 'in-stock' : 'out-of-stock' }}"
                data-product="{{ $productImage->id }}" name="color" data-productname="{{ productVariationName($variation->product->product_name, $color->value)}}"
                data-image={{ $variation->images->pluck('image') }}
                value="{{ $color->value }}" data-sku="{{ $variation->sku }}" data-variation="{{ $variation->id }}" data-price="{{ getPrice($variation->price )}}">
        </label>
    @endif
@endforeach
