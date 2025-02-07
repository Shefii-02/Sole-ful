@extends('layouts.app')
@push('header')
    {{-- <link href="{{ asset('assets/admin/style.css') }}" rel="stylesheet"> --}}
@endpush
@section('content')
    <div class="container" style="padding-top: 5.5rem;">
        <div class="row justify-content-center">
            @if ($errors->any())
                <div class="alert alert-danger">
                    There were some errors with your request.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-lg-8">
                <div
                    class="rounded-sm rounded-r-full border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
                    <div class="flex flex-wrap items-center">

                        <div class="w-full border-stroke dark:border-strokedark xl:border-l-2">
                            <div class="w-full p-4 sm:p-12.5 xl:p-17.5">
                                <h4 class="mb-3 text-lg font-bold text-black dark:text-white sm:text-title-xl2">
                                    Signup after Explore..
                                </h4>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-lg-6">
                                            <label class="mb-2.5 block fs-6 text-black dark:text-white">Full name</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-3.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                                                    </svg>
                                                </span>
                                                <input type="text" @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" autocomplete="name" autofocus
                                                    placeholder="Enter your full name"
                                                    class="w-10/12 rounded-lg border border-stroke bg-transparent py-2 pl-10 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            </div>
                                            @error('name')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-lg-6">
                                            <label class="mb-2.5 block fs-6 text-black dark:text-white">Mobile
                                                Number</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-3.5">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                                    </svg>
                                                </span>
                                                <input type="text" @error('mobile') is-invalid @enderror" name="mobile"
                                                    value="{{ old('mobile') }}" autocomplete="off" autofocus
                                                    placeholder="Enter your number" maxlength="12"
                                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"
                                                    class="w-10/12 rounded-lg border border-stroke bg-transparent py-2 pl-10 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            </div>
                                            @error('mobile')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-lg-6">
                                            <label class="mb-2.5 block fs-6 text-black dark:text-white">Email</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-3.5">
                                                    <svg class="fill-current" width="15" height="15"
                                                        viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M19.2516 3.30005H2.75156C1.58281 3.30005 0.585938 4.26255 0.585938 5.46567V16.6032C0.585938 17.7719 1.54844 18.7688 2.75156 18.7688H19.2516C20.4203 18.7688 21.4172 17.8063 21.4172 16.6032V5.4313C21.4172 4.26255 20.4203 3.30005 19.2516 3.30005ZM19.2516 4.84692C19.2859 4.84692 19.3203 4.84692 19.3547 4.84692L11.0016 10.2094L2.64844 4.84692C2.68281 4.84692 2.71719 4.84692 2.75156 4.84692H19.2516ZM19.2516 17.1532H2.75156C2.40781 17.1532 2.13281 16.8782 2.13281 16.5344V6.35942L10.1766 11.5157C10.4172 11.6875 10.6922 11.7563 10.9672 11.7563C11.2422 11.7563 11.5172 11.6875 11.7578 11.5157L19.8016 6.35942V16.5688C19.8703 16.9125 19.5953 17.1532 19.2516 17.1532Z"
                                                                fill=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="email" @error('email') is-invalid @enderror" name="email"
                                                    value="{{ old('email') }}" autocomplete="off" autofocus
                                                    placeholder="Enter your email"
                                                    class="w-10/12 rounded-lg border border-stroke bg-transparent py-2 pl-10 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            </div>
                                            @error('email')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-lg-6">
                                            <label class="mb-2.5 block fs-6 text-black dark:text-white">Password</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-3.5">
                                                    <svg class="fill-current" width="15" height="15"
                                                        viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M19.2516 3.30005H2.75156C1.58281 3.30005 0.585938 4.26255 0.585938 5.46567V16.6032C0.585938 17.7719 1.54844 18.7688 2.75156 18.7688H19.2516C20.4203 18.7688 21.4172 17.8063 21.4172 16.6032V5.4313C21.4172 4.26255 20.4203 3.30005 19.2516 3.30005ZM19.2516 4.84692C19.2859 4.84692 19.3203 4.84692 19.3547 4.84692L11.0016 10.2094L2.64844 4.84692C2.68281 4.84692 2.71719 4.84692 2.75156 4.84692H19.2516ZM19.2516 17.1532H2.75156C2.40781 17.1532 2.13281 16.8782 2.13281 16.5344V6.35942L10.1766 11.5157C10.4172 11.6875 10.6922 11.7563 10.9672 11.7563C11.2422 11.7563 11.5172 11.6875 11.7578 11.5157L19.8016 6.35942V16.5688C19.8703 16.9125 19.5953 17.1532 19.2516 17.1532Z"
                                                                fill=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="password" @error('password') is-invalid @enderror"
                                                    name="password" value="{{ old('password') }}"
                                                    autocomplete="new-password" autofocus placeholder="********"
                                                    class="w-10/12 rounded-lg border border-stroke bg-transparent py-2 pl-10 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            </div>
                                            @error('password')
                                                <span class="text-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label class="mb-2.5 block fs-6 text-black dark:text-white">Address</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-3.5">
                                                    <svg class="fill-current" width="15" height="15"
                                                        viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M19.2516 3.30005H2.75156C1.58281 3.30005 0.585938 4.26255 0.585938 5.46567V16.6032C0.585938 17.7719 1.54844 18.7688 2.75156 18.7688H19.2516C20.4203 18.7688 21.4172 17.8063 21.4172 16.6032V5.4313C21.4172 4.26255 20.4203 3.30005 19.2516 3.30005ZM19.2516 4.84692C19.2859 4.84692 19.3203 4.84692 19.3547 4.84692L11.0016 10.2094L2.64844 4.84692C2.68281 4.84692 2.71719 4.84692 2.75156 4.84692H19.2516ZM19.2516 17.1532H2.75156C2.40781 17.1532 2.13281 16.8782 2.13281 16.5344V6.35942L10.1766 11.5157C10.4172 11.6875 10.6922 11.7563 10.9672 11.7563C11.2422 11.7563 11.5172 11.6875 11.7578 11.5157L19.8016 6.35942V16.5688C19.8703 16.9125 19.5953 17.1532 19.2516 17.1532Z"
                                                                fill=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="text" @error('address') is-invalid @enderror"
                                                    name="address" value="{{ old('address') }}" autocomplete="address"
                                                    placeholder="Enter your address"
                                                    class="w-10/12 rounded-lg border border-stroke bg-transparent py-2 pl-10 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3 col-lg-6">
                                            <label class="mb-2.5 block fs-6 text-black dark:text-white">Pincode</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-3.5">
                                                    <svg class="fill-current" width="15" height="15"
                                                        viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M19.2516 3.30005H2.75156C1.58281 3.30005 0.585938 4.26255 0.585938 5.46567V16.6032C0.585938 17.7719 1.54844 18.7688 2.75156 18.7688H19.2516C20.4203 18.7688 21.4172 17.8063 21.4172 16.6032V5.4313C21.4172 4.26255 20.4203 3.30005 19.2516 3.30005ZM19.2516 4.84692C19.2859 4.84692 19.3203 4.84692 19.3547 4.84692L11.0016 10.2094L2.64844 4.84692C2.68281 4.84692 2.71719 4.84692 2.75156 4.84692H19.2516ZM19.2516 17.1532H2.75156C2.40781 17.1532 2.13281 16.8782 2.13281 16.5344V6.35942L10.1766 11.5157C10.4172 11.6875 10.6922 11.7563 10.9672 11.7563C11.2422 11.7563 11.5172 11.6875 11.7578 11.5157L19.8016 6.35942V16.5688C19.8703 16.9125 19.5953 17.1532 19.2516 17.1532Z"
                                                                fill=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="text" maxlength="6"  @error('postalcode') is-invalid @enderror" data-state="state" data-city="locality" data-msg="s_msg"
                                                    name="postalcode" value="{{ old('postalcode') }}"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"
                                                    autocomplete="postalcode" placeholder="Enter your postal code"
                                                    class="w-10/12 postal rounded-lg border border-stroke bg-transparent py-2 pl-10 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            </div>
                                            <span class="" id="s_msg"></span>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label class="mb-2.5 block fs-6 text-black dark:text-white">City</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-3.5">
                                                    <svg class="fill-current" width="15" height="15"
                                                        viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M19.2516 3.30005H2.75156C1.58281 3.30005 0.585938 4.26255 0.585938 5.46567V16.6032C0.585938 17.7719 1.54844 18.7688 2.75156 18.7688H19.2516C20.4203 18.7688 21.4172 17.8063 21.4172 16.6032V5.4313C21.4172 4.26255 20.4203 3.30005 19.2516 3.30005ZM19.2516 4.84692C19.2859 4.84692 19.3203 4.84692 19.3547 4.84692L11.0016 10.2094L2.64844 4.84692C2.68281 4.84692 2.71719 4.84692 2.75156 4.84692H19.2516ZM19.2516 17.1532H2.75156C2.40781 17.1532 2.13281 16.8782 2.13281 16.5344V6.35942L10.1766 11.5157C10.4172 11.6875 10.6922 11.7563 10.9672 11.7563C11.2422 11.7563 11.5172 11.6875 11.7578 11.5157L19.8016 6.35942V16.5688C19.8703 16.9125 19.5953 17.1532 19.2516 17.1532Z"
                                                                fill=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="text" @error('city') is-invalid @enderror" name="city"
                                                    value="{{ old('city') }}" autocomplete="city"
                                                    placeholder="Enter your city" id="locality"
                                                    class="w-10/12 rounded-lg border border-stroke bg-transparent py-2 pl-10 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            </div>
                                        </div>
                                        <div class="mb-3 col-lg-6">
                                            <label class="mb-2.5 block fs-6 text-black dark:text-white">State</label>
                                            <div class="relative">
                                                <span class="absolute left-4 top-3.5">
                                                    <svg class="fill-current" width="15" height="15"
                                                        viewBox="0 0 22 22" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g opacity="0.5">
                                                            <path
                                                                d="M19.2516 3.30005H2.75156C1.58281 3.30005 0.585938 4.26255 0.585938 5.46567V16.6032C0.585938 17.7719 1.54844 18.7688 2.75156 18.7688H19.2516C20.4203 18.7688 21.4172 17.8063 21.4172 16.6032V5.4313C21.4172 4.26255 20.4203 3.30005 19.2516 3.30005ZM19.2516 4.84692C19.2859 4.84692 19.3203 4.84692 19.3547 4.84692L11.0016 10.2094L2.64844 4.84692C2.68281 4.84692 2.71719 4.84692 2.75156 4.84692H19.2516ZM19.2516 17.1532H2.75156C2.40781 17.1532 2.13281 16.8782 2.13281 16.5344V6.35942L10.1766 11.5157C10.4172 11.6875 10.6922 11.7563 10.9672 11.7563C11.2422 11.7563 11.5172 11.6875 11.7578 11.5157L19.8016 6.35942V16.5688C19.8703 16.9125 19.5953 17.1532 19.2516 17.1532Z"
                                                                fill=""></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                                <input type="text" @error('state') is-invalid @enderror" name="state"
                                                    value="{{ old('state') }}" autocomplete="state" id="state"
                                                    placeholder="Enter your  state"
                                                    class="w-10/12 rounded-lg border border-stroke bg-transparent py-2 pl-10 pr-10 outline-none focus:border-primary focus-visible:shadow-none dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
                                            </div>
                                        </div>
                                        <input type="hidden" name="redirection_url"
                                            value="{{ request()->get('redirection_url') }}">
                                    </div>
                                    <div class="mb-2 text-center w-10/12 mt-3">
                                        <input type="submit" value="Sign In"
                                            class="w-1/2 cursor-pointer rounded-lg  btn-theme py-2 px-10 fs-6 text-white transition hover:bg-opacity-90">
                                    </div>

                                    <div class="mt-2 text-center w-10/12">
                                        <p class="font-sm">
                                            I have already account
                                            <a href="{{ route('login') }}" class="text-primary">Sign In</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('footer')
    <script>
        $('body').on('input', '.postal', function() {
            var pin_code = $(this).val();
            var Idstate = $(this).data('state');
            var Idcity = $(this).data('city');
            var Idmsg = $(this).data('msg')


            if (pin_code.length == 6) {
                $.ajax({
                    url: "{{ route('public.pincode.check') }}",
                    cache: false,
                    type: "GET",
                    data: {
                        pin_code: pin_code
                    },
                    success: function(response) {
                        $('#' + Idmsg).attr('class', '');
                        if (response.result) {
                            $('#' + Idmsg).addClass('text-success');
                            $('#' + Idmsg).text('')
                        } else {
                            $('#' + Idmsg).addClass('text-danger');
                            $('#' + Idmsg).text('Sorry, we are unable to deliver to this pincode at the moment.')

                        }

                        

                        $('#' + Idstate).val(response.state)
                        $('#' + Idcity).val(response.city)
                       
                    }
                });
            }
        });
    </script>
@endpush
