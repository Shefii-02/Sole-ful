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
                                            {{ __('Please confirm your password before continuing.') }}

                                            <form method="POST" action="{{ route('password.confirm') }}">
                                                @csrf

                                                <div class="row mb-3">
                                                    <label for="password"
                                                        class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                                    <div class="col-md-6">
                                                        <input id="password" type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" required autocomplete="current-password">

                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-md-8 offset-md-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('Confirm Password') }}
                                                        </button>

                                                        @if (Route::has('password.request'))
                                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                                {{ __('Forgot Your Password?') }}
                                                            </a>
                                                        @endif
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
