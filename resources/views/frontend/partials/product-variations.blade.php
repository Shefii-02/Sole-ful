{{-- @foreach ($variations as $variation)
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
        <label class="color-button text-center" data-color="{{ $color }}">
            <img class="w-20" src="{{ asset('images/products/' . $productImage->image) }}"
                alt="{{ $color->value }}">
            <span class="small">{{ $color->value }}</span>
            <input type="radio" class="hidden variColor_checkbox"
                data-product="{{ $productImage->id }}" name="color" data-productName="{{ productVariationName($variation->product->product_name,$color->value)}}"
                value="{{ $color->value }}" data-sku="{{ $productImage->sku }}" data-variation="{{ $variation->id }}">
        </label>
    @endif
@endforeach --}}

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
                alt="{{ $color->value }}">
            <span class="small">{{ $color->value }}</span>
            <input type="radio" class="hidden variColor_checkbox"
                data-product="{{ $productImage->id }}" name="color" data-productName="{{ productVariationName($variation->product->product_name, $color->value)}}"
                value="{{ $color->value }}" data-sku="{{ $variation->sku }}" data-variation="{{ $variation->id }}">
        </label>
    @endif
@endforeach
