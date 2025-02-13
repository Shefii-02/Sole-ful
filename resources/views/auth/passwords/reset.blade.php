@extends('layouts.app')
@push('header')
    <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet">
@endpush
@section('content')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area bg-img pt-12" data-bg="/assets/img/breadcrumb-banner.webp">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <nav aria-label="breadcrumb">
                            <h1 class="breadcrumb-title">Reset Password your Account</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Reset Password</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->
    <div class="container" style="padding-top: 5.5rem;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div
                    class="rounded-sm rounded-r-full border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="flex flex-wrap items-center">

                        <div class="w-full border-stroke dark:border-strokedark xl:border-l-2">
                            <div class="w-full p-4 sm:p-12.5 xl:p-17.5">
                                <div class="container">

                                    <div class="row justify-content-start">
                                        <div class="col-md-10">
                                            <div class="container">
                                                <div class="row justify-content-center">
                                                    <div class="col-md-8">
                                                        <form method="POST" action="{{ route('password.update') }}">
                                                            @csrf

                                                            <input type="hidden" name="token"
                                                                value="{{ $token }}">

                                                            <div class="row mb-3">
                                                                <label for="email"
                                                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                                <div class="col-md-6">
                                                                    <input id="email" type="email"
                                                                        class="form-control @error('email') is-invalid @enderror"
                                                                        name="email" value="{{ $email ?? old('email') }}"
                                                                        required autocomplete="email" autofocus>

                                                                    @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label for="password"
                                                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                                                <div class="col-md-6">
                                                                    <input id="password" type="password"
                                                                        class="form-control @error('password') is-invalid @enderror"
                                                                        name="password" required
                                                                        autocomplete="new-password">

                                                                    @error('password')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label for="password-confirm"
                                                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                                                <div class="col-md-6">
                                                                    <input id="password-confirm" type="password"
                                                                        class="form-control" name="password_confirmation"
                                                                        required autocomplete="new-password">
                                                                </div>
                                                            </div>

                                                            <div class="row mb-0">
                                                                <div class="col-md-6 offset-md-4">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        {{ __('Reset Password') }}
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
