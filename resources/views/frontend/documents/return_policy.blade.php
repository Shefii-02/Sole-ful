@extends('layouts.app')

@push('header')
    <style>
        .documents h1,
        .documents h2 {
            font-size: 1.5rem;
        }

        .documents h3 {
            font-size: 1.2rem;
        }

        .documents p,
        .documents ul,
        .documents h1,
        .documents h2,
        .documents h3 {
            margin-bottom: 20px;
        }

        .documents ul {
            padding-left: 30px;
        }

        .documents ul li {
            list-style: disc !important;

        }
    </style>
@endpush

@section('content')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area bg-img pt-12" data-bg="assets/img/breadcrumb-banner.webp">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <nav aria-label="breadcrumb">
                            <h1 class="breadcrumb-title">Return Policy</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Return Policy</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <!-- page main wrapper start -->
    <div class="shop-main-wrapper section-padding documents">
        <div class="container">
            <div class="container py-4">
                <h1 class="text-center mb-3">Return Policy</h1>

                <p class="effective-date"><span class="highlight">Effective Date:</span> 1st Jan 2025</p>

                <ul>
                    <li>Returns are accepted against manufacturing defects only within <span class="highlight">7 days</span>
                        from the day of delivery of the order.</li>
                    <li>The return process will be completed within <span class="highlight">7 to 10 business days</span>.
                    </li>
                    <li>Replacement of the product will be completed in <span class="highlight">7 to 10 business
                            days</span>.</li>
                    <li>Items eligible for return and refund must be unused, intact, and in their original packaging
                        (including labels, tags, boxes, and plastic wrap).</li>
                    <li>To initiate a return, log in to the website <a href="https://www.soleful.in"
                            target="_blank">www.soleful.in</a> and raise a return request from the "My Orders" section. Our
                        team will gladly look into the concerns and resolve them.</li>
                </ul>
            </div>
        </div>
    @endsection
