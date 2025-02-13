@extends('layouts.app')

@section('content')
    <!-- Breadcrumb Area -->
    <div class="breadcrumb-area bg-img" data-bg="/assets/img/breadcrumb-banner.webp">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <nav aria-label="breadcrumb">
                            <h1 class="breadcrumb-title">Order Completed</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('account.home') }}">My Account</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Order Completed</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Confirmation Section -->
    <section class="d-flex justify-content-center align-items-center min-vh-80 py-5">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body text-center p-4">
                    <div class="d-flex justify-content-center align-items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor"
                            class="bi bi-check-circle text-success" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                        </svg>
                    </div>
                    <h2 class="font-weight-bold text-dark">Thank You!</h2>
                    <p class="text-muted">
                        Your order has been placed successfully.
                        <br> A confirmation email has been sent to your email.
                        <br> <strong>Invoice Number:</strong> #{{ $order->invoice_id }}
                        <br> <strong>Payment Method:</strong> #{{ $order->payment_method }}
                        <br> <strong>Transaction ID:</strong>
                        #{{ $order->payments ? $order->payments->transaction_id : '---' }}
                        <br> <strong>Reference ID:</strong> #{{ $order->payments ? $order->payments->reference_id : '---' }}
                    </p>
                    <div class="mt-4">
                        @auth
                            <a href="{{ route('account.home') }}" class="btn btn-primary px-4 py-2 rounded-pill">
                                Back to My Account
                            </a>
                        @else
                            <a href="/" class="btn btn-outline-dark px-4 py-2 rounded-pill">
                                Back to Home
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
