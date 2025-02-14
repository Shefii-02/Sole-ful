@extends('admin.layouts.master')

@section('content')
    <div class="py-4">
        <div
            class="rounded-md border border-stroke bg-white p-4 py-3 dark:border-strokedark dark:bg-meta-4 sm:px-6 sm:py-5.5 xl:px-7.5">
            <nav>
                <ol class="flex flex-wrap items-center gap-2">
                    <li>
                        <a class="flex items-center gap-2 small text-black hover:text-primary dark:text-white dark:hover:text-primary"
                            href="{{ route('admin.dashboard') }}">
                            <svg class="fill-current" width="15" height="15" viewBox="0 0 15 15"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.35 14.65H10.22c-.7 0-1.28-.58-1.28-1.28V10.82c0-.26-.21-.47-.47-.47H6.55c-.26 0-.47.21-.47.47v2.53c0 .7-.58 1.28-1.28 1.28H1.63c-.7 0-1.28-.58-1.28-1.28V5.24c0-.35.19-.66.49-.83l6.13-3.88c.33-.21.77-.21 1.1 0l6.13 3.88c.3.17.49.48.49.83v8.08c0 .7-.58 1.28-1.28 1.28Zm-6.83-5.11h1.93c.7 0 1.28.58 1.28 1.28v2.53c0 .26.21.47.47.47h3.16c.26 0 .47-.21.47-.47V5.27c0-.07-.04-.14-.1-.18L7.62 1.2a.2.2 0 0 0-.21 0L1.28 5.08a.2.2 0 0 0-.1.18v8.08c0 .26.21.47.47.47h3.16c.26 0 .47-.21.47-.47V10.82c0-.7.58-1.28 1.28-1.28Z">
                                </path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li class="flex items-center gap-2 small">
                        <svg class="fill-current" width="18" height="7" viewBox="0 0 18 7"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.57 2.59L14.82.51a.45.45 0 0 0-.63.05c-.18.15-.2.43-.05.64l1.65 1.95H1.75a.45.45 0 0 0-.45.45c0 .25.2.45.45.45h13.99L14.14 5.91c-.18.17-.15.46.05.64a.45.45 0 0 0 .63-.05l1.75-2.08c.46-.56.46-1.32 0-1.83Z">
                            </path>
                        </svg>
                        Product Stocks
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">

        <div class="p-4 md:p-6 xl:p-7.5">
            <div class="flex flex-wrap gap-3 items-start justify-between">
                <h2 class="text-title-sm2 font-bold text-black dark:text-black">
                    Product Stocks
                </h2>
                <form>
                    <div class="relative flex flex-1 flex-wrap space-x-2">
                        <label class="me-4 fw-bold mb-2 ">Product ID</label>
                        <!-- Search by Product ID -->
                        <input type="text"  autocomplete="off" name="product_id" value="{{ request()->get('product_id') }}" placeholder=""
                            class="border border-gray-300 px-3 py-1 mb-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="mx-4 text-primary fw-bold mb-2 ">or</span>
                        <label class="me-4 fw-bold mb-2 ">Product SKU</label>
                        <!-- Search by Product SKU -->
                        <input type="text"  autocomplete="off" name="sku" placeholder="" value="{{ request()->get('sku') }}"
                            class="border border-gray-300 px-3 py-1 mb-2  rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button class="btn btn-info mx-4" type="submit">Search</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="p-6">
            <div class="border-b border-stroke px-4 pb-2 dark:border-strokedark md:px-6 xl:px-7.5">
                <div class="flex justify-between items-center gap-x-6">
                    <div class="w-1/12 text-left"><span class="small fw-bold">Product No</span></div>
                    <div class="w-3/12 text-center"><span class="small fw-bold">Product</span></div>
                    <div class="w-1/12 text-center"><span class="small fw-bold">ART Code</span></div>
                    <div class="w-2/12 text-center"><span class="small fw-bold">Variation Count</span></div>
                    <div class="w-2/12 text-center"><span class="small fw-bold">Total Stock</span></div>
                    <div class="w-1/12 text-center"><span class="small fw-bold">Status</span></div>
                    <div class="w-2/12 text-end"><span class="small fw-bold">Actions</span></div>
                </div>
            </div>
            <div class="p-4 md:p-6 xl:p-7.5">
                <div class="flex flex-col gap-y-4">
                    @forelse ($products ?? [] as $product)
                        <div class="flex justify-between items-center gap-x-6">
                            <div class="w-1/12 text-left small">{{ $product->product_no }}</div>
                            <div class="w-3/12 text-center small">
                                <img src="{{ isset($product->MainThumbImage) && $product->MainThumbImage->image ? asset('images/products/' . $product->MainThumbImage->image) : asset('images/default.jpg') }}"
                                    class="w-20 mx-auto" />
                                {{ $product->product_name }}
                            </div>
                            <div class="w-1/12 text-center small">{{ $product->art_code ?? '-' }}</div>
                            <div class="w-2/12 text-center small">{{ count($product->product_variation) }}</div>
                            <div class="w-2/12 text-center small">{{ $product->product_variation->sum('in_stock') }}</div>
                            <div class="w-1/12 text-center small">{!! $product->status_text !!}</div>
                            <div class="w-2/12 text-end">
                                <button class="btn btn-theme btn-sm" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ $product->id }}" aria-expanded="false"
                                    aria-controls="collapse-{{ $product->id }}">
                                    View Variants
                                </button>
                            </div>
                        </div>
                        <div class="collapse" id="collapse-{{ $product->id }}">
                            <div class="p-4 border rounded">
                                <form action="{{ route('admin.stock.update', $product->id) }}" method="POST">
                                    @csrf
                                    <h4 class="fw-bold text-theme mb-3">Variants</h4>
                                    @foreach ($product->product_variation ?? [] as $key => $variant)
                                        @if ($key == 0)
                                            <div class="flex justify-between items-center mb-3">
                                                <div class="w-1/4 fw-bold">
                                                    Variation Name
                                                </div>
                                                <div class="w-1/4 text-center fw-bold">
                                                    SKU
                                                </div>
                                                <div class="w-1/4 text-center fw-bold">
                                                    Current Stock
                                                </div>
                                                <div class="w-1/4 fw-bold">
                                                    New Stock
                                                </div>
                                            </div>
                                            <hr class="mb-3">
                                        @endif
                                        <div class="flex justify-between items-center mb-3">
                                            <div class="w-1/4">{{ $variant->variation_name }}</div>
                                            <div class="w-1/4 text-center">{{ $variant->sku }}</div>
                                            <div class="w-1/4 text-center">{{ $variant->in_stock }}</div>
                                            <div class="w-1/4">
                                                <input type="number" name="variants[{{ $variant->id }}]"
                                                    class="form-control" value="{{ $variant->in_stock }}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-end">
                                        <button type="submit" class="btn text-light bg-success">Update Stock</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <h2>Products No Found..</h2>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
