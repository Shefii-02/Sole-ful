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
    <div class="breadcrumb-area bg-img pt-12" data-bg="assets/img/banner/breadcrumb-banner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <nav aria-label="breadcrumb">
                            <h1 class="breadcrumb-title">Shipping Policy</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Shipping Policy</li>
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
            <div class="row">
                <p><strong>Effective Date:</strong> 1st Jan 2025</p>
                <ul>
                    <li>All confirmed orders will be dispatched within 2 to 3 business days. Delivery timelines may vary depending on the courier partner's schedule.</li>
                    <li>Shipping is free of charge.</li>
                    <li>Once an order has been shipped from our warehouse, it cannot be cancelled. If you wish to cancel, you may refuse delivery when the courier partner attempts to deliver.</li>
                    <li>If you accept the delivery but are unsatisfied with your order, you can raise an exchange request.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
