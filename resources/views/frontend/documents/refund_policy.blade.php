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
                            <h1 class="breadcrumb-title">Refund Policy</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Refund Policy</li>
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
                    <li>For any reason, if you cancel an order within two hours of placing it or before it moves to procurement, a full refund of online credit will be credited to your wallet within 3-5 business days.</li>
                    <li>In cases where orders cannot be processed, procured, or shipped due to unforeseen circumstances or reasons beyond our control, the order will be cancelled, and the full amount will be refunded without any liability to either party.</li>
                    <li>Online credit will only be issued if the delivered order is subject to manufacturing defects.</li>
                    <li>No refund or exchange will be provided if the product is delivered in the correct size and colors as selected during the order placement.</li>
                </ul>
        
                <h3>Refund Timelines</h3>
                <ul>
                    <li><strong>Cash on Delivery (COD):</strong> Refunds will reflect in your online credit account within 5 to 7 business days after initiation.</li>
                    <li><strong>Prepaid Orders:</strong> Refunds will reflect as online credit within 5 to 7 business days, depending on the bank partner.</li>
                </ul>
                <p>Refunds are initiated only after the returned item passes the condition checks. The timeline for refund initiation depends on the courier partner's return delivery to the Soleful warehouse.</p>
        
                <h2 class="mt-4">Warranty/Guarantee Policy</h2>
                <ul>
                    <li>No warranty, guarantee, exchange, or repairs are available for products purchased at discounted prices on the website.</li>
                </ul>
        
                <h2 class="mt-4">Quality Check</h2>
                <ul>
                    <li>Each product is shipped with a seal tag to ensure seamless returns. The seal tag must remain attached and intact. Returns or exchanges will not be accepted if the seal tag is removed, damaged, or tampered with.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
