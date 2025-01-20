@foreach ($images as $image)
    <div class="pro-nav-thumb">
        <img src="{{ $image->url }}" alt="Product Thumbnail">
    </div>
@endforeach
