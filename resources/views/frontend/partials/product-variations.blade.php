@foreach ($variations as $variation)
    @php
        $color = $variation->variationkey->where('type','color')->first(); 
        $product= $variation->images->first();
        
    @endphp

    <label class="color-button" data-color="{{ $color }}">
        <img src="{{ asset('images/products/') }}"
            alt="{{ $color->value }}">
            <span>{{ $color->value }}</span>
    </label>
@endforeach