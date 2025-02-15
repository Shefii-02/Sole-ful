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
                        Best Selling Products
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="p-4 md:p-6 xl:p-7.5">
            <div class="flex items-start justify-between">
                <h2 class="text-title-sm2 font-bold text-black dark:text-black">
                    Best Selling Products
                </h2>
                <div class="relative"></div>
            </div>
        </div>
        <form action="{{ route('admin.best-selling.update') }}" method="POST">
            @csrf
            <div class="p-6 col-lg-12">
                <div class="row">
                    @foreach ($products ?? [] as $key => $item)
                        <div class="col-lg-3 mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="bestSell[]" type="checkbox" role="switch"
                                    value="{{ $item->id }}" id="product-{{ $key }}"
                                    {{ in_array($item->id, $bestSell ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="product-{{ $key }}">{{ $item->product_name }}</label>
                                    <small>({{ $item->unique_value }})</small>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn text-light bg-success">Update Best Selling Products</button>
                </div>
            </div>
        </form>
    </div>
@endsection
