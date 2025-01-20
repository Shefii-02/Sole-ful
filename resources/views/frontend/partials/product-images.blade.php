@foreach ($images as $image)
    <div class="pro-large-img img-zoom">
        <img src="{{ $image->url }}" alt="Product Image">
    </div>
@endforeach
