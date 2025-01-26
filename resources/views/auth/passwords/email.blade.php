@extends('layouts.app')
@push('header')
    <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet">
@endpush
@section('content')
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
                                            <h4 class="mb-3 text-lg font-bold text-black dark:text-white sm:text-title-xl2">
                                                {{ __('Reset Password') }}
                                            </h4>
                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf

                                                <div class="row mb-3">
                                                    <label for="email"
                                                        class="col-md-4 col-form-label text-md-start">{{ __('Email Address') }}</label>

                                                    <div class="col-md-8">
                                                        <input id="email" type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email') }}" required
                                                            autocomplete="email" autofocus>

                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-md-6 offset-md-4">
                                                        <button type="submit" class="btn btn-theme">
                                                            {{ __('Send Password Reset Link') }}
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
@endsection
