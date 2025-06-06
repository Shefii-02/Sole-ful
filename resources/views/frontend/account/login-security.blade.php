@extends('layouts.app')
@push('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css" rel="stylesheet">
<style>
    .intl-tel-input,
    .iti {
        width: 100%;
    }
</style>
@endpush
@push('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
    <script>
        $("#mobile").intlTelInput({
            initialCountry: "in",
            separateDialCode: false,
            nationalMode: true,
            formatOnDisplay: false,
            // utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.4/js/utils.js"
        });
        $('form').on('submit', function () {
            var code = $("#mobile").intlTelInput("getSelectedCountryData").dialCode;
            var phoneNumber = $('#mobile').val();
            $("#mobile").val(code+phoneNumber); // This will replace the input value with full number (+91xxxx)
        });
    </script>
@endpush
@section('content')
    <section class="product-listing-banner">
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area bg-img" data-bg="/assets/img/breadcrumb-banner.webp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h1 class="breadcrumb-title">Login & Security</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('account.home') }}">My Account</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Login & Security</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
    </section>

    <section class="page_section  py-5">
        <div class="container">
            <div class="row justify-center">
             
                <div class="col-lg-8 mb-2">
                    <div class="card border-Default mb-3">
                        <div class=" text-dark fw-bold">
                            <div class="col-lg-12 card-body">
                                <div class="row position-relative align-items-center">
                                    <div class="col-10">
                                        <p>Email</p>
                                        <p>{{ $account->email }}</p>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-light shadow btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#edit_phone">Edit</button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12 card-body">
                                <div class="row">
                                    <div class="col-10">
                                        <p>Name</p>
                                        <p>{{ $account->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="col-lg-12 card-body">
                                <div class="row">
                                    <div class="col-10">
                                        <p>Phone</p>
                                        <p>{{ $account->mobile }}</p>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="col-lg-12 card-body">
                                <div class="row position-relative">
                                    <div class="col-10">
                                        <p>Password</p>
                                        <p>**********</p>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-light shadow btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#edit_password">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                        
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="edit_phone" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="new_ModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header justify-between">
                    <h5 class="modal-title py-3 fs-5 fw-bold" id="new_ModalLabel">Edit Login and Security</h5>
                    <i class=" cursor-pointer fa fa-times text-dark fa-2x" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>
                <div class="modal-body">

                    <form action="{{ route('account.profile.update') }}" class="row" novalidate id="profile_edit"
                        method="POST">
                        @csrf()
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="">Full Name</label>
                            <input type="text" autocomplete="off" form="profile_edit" value="{{ $account->name }}"
                                class="form-control" name="name">
                        </div>
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="">Email Id</label>
                            <input type="email" autocomplete="off" form="profile_edit" class="form-control"
                                value="{{ $account->email }}" name="email">
                        </div>
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="">Phone Number</label>
                            <input type="text" autocomplete="off" id="mobile" form="profile_edit" required
                                value="{{ $account->mobile }}" class="form-control" name="mobile">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary swal2-styled swal2-cancel"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="profile_edit"
                        class="swal2-confirm btn btn-theme swal2-styled swal2-default-outline">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="edit_password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="new_ModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header justify-between">
                    <h5 class="modal-title py-3 fs-5 fw-bold" id="new_ModalLabel">Reset Password</h5>
                    <i class=" cursor-pointer fa fa-times text-dark fa-2x" data-bs-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <form action="{{ route('account.profile.reset-password') }}" class="validated not-ajax"
                        id="password_edit" method="POST">
                        @csrf()
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="password">Password</label>
                            <input type="password" autocomplete="off" form="password_edit" class="form-control" required
                                id="password" name="password">
                            <small id="passwordError" class="text-danger"></small>
                        </div>
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="confirm_password">Confirm Password</label>
                            <input type="password" autocomplete="off" form="password_edit" class="form-control" required
                                id="confirm_password" name="confirm_password">
                            <small id="confirmError" class="text-danger"></small>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary swal2-styled swal2-cancel"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="password_edit"
                        class="swal2-confirm btn swal2-styled btn-theme swal2-default-outline">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footer')
    <script>
        $(document).ready(function() {
            $('#confirm_password').on('input', function() {
                var password = $('#password').val();
                var confirmPassword = $(this).val();
                var passwordError = $('#passwordError');
                var confirmError = $('#confirmError');
                if (password.length <= confirmPassword.length) {
                    if (password !== confirmPassword) {
                        passwordError.text('Password and Confirm Password do not match');
                        confirmError.text('Password and Confirm Password do not match');
                    } else {
                        passwordError.text('');
                        confirmError.text('');
                    }
                } else {
                    passwordError.text('');
                    confirmError.text('');
                }
            });

            $('#password_edit').on('submit', function(event) {

                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();
                var passwordError = $('#passwordError');
                var confirmError = $('#confirmError');

                if (password !== confirmPassword) {
                    passwordError.text('Password and Confirm Password do not match');
                    confirmError.text('Password and Confirm Password do not match');
                    event.preventDefault();
                }
            });
        });
    </script>
@endpush
