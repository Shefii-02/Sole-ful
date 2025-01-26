@extends('layouts.app')
@push('header')
    <style>
        .myaddress .box {
            border-style: dashed;
            height: 220px;
            width: 342px;
            border-width: 2px;
            box-sizing: border-box;
            border-color: #C7C7C7;
            text-align: center;
            display: flex;
            border-radius: 7px;
            cursor: pointer;
            flex-direction: column;
            flex-wrap: nowrap;
            justify-content: center;
        }
    </style>
@endpush
@section('content')
    <section class="product-listing-banner">
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area bg-img" data-bg="assets/img/breadcrumb-banner.webp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h1 class="breadcrumb-title">My Account</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('account.home') }}">My Account</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Address</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
    </section>

    <section class=" pb-5 pt-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-10 ">


                    <div class="col-md-12 myaddress">
                        <div class="row">
                            <div class="col-lg-4 d-flex justify-content-center mb-2">
                                <div class="box" data-bs-toggle="modal" data-bs-target="#new_Modal">
                                    <i class="fa fa-plus fa-3x text-secondary mb-3"></i>
                                    <p class="h3">Add Address</p>
                                </div>
                            </div>
                            @foreach ($myadd as $item)
                                <div class="col-md-6 col-lg-4 mb-2">
                                    <div class="card border-Default mb-3">
                                        <div class="card-header bg-transparent pb-0 pt-0">
                                        </div>
                                        <div class="card-body text-dark fw-bold">
                                            <div class="d-flex w-100 justify-content-end">
                                                @if ($item->base == 1)
                                                    <input type="radio" class="me-2" {{ $item->base == '1' ? 'checked' : '' }}>
                                                    {{ $item->base == 1 ? 'Default' : '' }}
                                                @endif
                                            </div>
                                            <div class="d-flex flex-column">
                                                <small class="text-capitalize">{{ $item->name }}</small>
                                                <small class="text-capitalize">{{ $item->address }}</small>
                                                <small class="text-capitalize">{{ $item->city . ',' . $item->postalcode }}</small>
                                                <small class="text-capitalize">{{ $item->province . ',' . $item->country }}</small>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-success">
                                            <ul class="list-unstyled pe-2 d-flex ">
                                                <li class="pe-2">
                                                    <small class="add_edit btn btn-light btn-sm cursor-pointer"
                                                        data-name="{{ $item->name }}" data-id="{{ $item->id }}"
                                                        data-address="{{ $item->address }}"
                                                        data-city="{{ $item->city }}"
                                                        data-postalcode="{{ $item->postalcode }}"
                                                        data-province="{{ $item->province }}"
                                                        data-country="{{ $item->country }}"
                                                        data-base="{{ $item->base }}">Edit</small>
                                                </li>
                                                @if ($myadd->count() > 1)
                                                    <li class="ps-1 pe-1">|</li>
                                                    <li>
                                                        <form method="POST"
                                                            action="{{ route('account.address.delete', $item->id) }}"
                                                            class="validated not-ajax" id="add_{{ $item->id }}">
                                                            @csrf()
                                                            <button type="submit"
                                                                class="btn btn-light btn-sm cursor-pointer"
                                                                data-id="add_{{ $item->id }}">Delete</button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="new_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="new_ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title py-3 fs-5 fw-bold" id="new_ModalLabel">Add Address</h5>
                    <i class=" fa fa-times text-dark fa-2x" role="button" data-bs-dismiss="modal" aria-label="Close"></i>
                </div>

                <div class="modal-body">
                    <form action="{{ route('account.address.add') }}" method="POST" id="add_address"
                        class="row address-form">
                        @csrf()
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="">Full Name</label>
                            <input type="text" required autocomplete="off" form="add_address" class="form-control"
                                name="name">
                        </div>
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="">Address</label>
                            <input type="text" autocomplete="off" placeholder="" class="form-control address_fill"
                                form="add_address" name="address">
                        </div>
                        <div class="col-lg-6 form-group mb-2">
                            <label class="mb-2" for="">Postal Code</label>
                            <input type="text" required autocomplete="off" form="add_address"
                                class="form-control postalCode_fill" name="postalcode">
                        </div>
                        <div class="col-lg-6 form-group mb-2">
                            <label class="mb-2" for="">City</label>
                            <input type="text" required autocomplete="off" form="add_address"
                                class="form-control city_fill" name="city">
                        </div>
                        <div class="col-lg-6 form-group mb-2">
                            <label class="mb-2" for="">Province</label>
                            <input form="add_address" class="form-control province_fill" autocomplete="off"
                                type="text" name="province" id="province" placeholder="" required>

                        </div>
                        <div class="col-lg-12 form-group mb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" form="add_address" type="checkbox" name="base"
                                    id="flexSwitchbase">
                                <label class="form-check-label" for="flexSwitchbase">Default</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary swal2-styled swal2-cancel"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="add_address"
                        class="swal2-confirm btn btn-theme swal2-styled swal2-default-outline">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!------------------------------------------------------------------------------------------------------------->


    <!-- Modal -->
    <div class="modal fade" id="edit_Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="new_ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title py-3 fs-5 fw-bold" id="new_ModalLabel">Edit Address</h5>
                    <i class=" fa fa-times text-dark fa-2x" role="button" data-bs-dismiss="modal"
                        aria-label="Close"></i>
                </div>
                <div class="modal-body">
                    <form action="{{ route('account.address.update') }}" method="POST" id="edit_address"
                        class="row address-form" novalidate>
                        @csrf()
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="name">Full Name</label>
                            <input type="hidden" name="id" id="id" form="edit_address" required>
                            <input type="text" required autocomplete="off" class="form-control" form="edit_address"
                                name="name" id="name">
                        </div>
                        <div class="col-lg-12 form-group mb-2">
                            <label class="mb-2" for="Editaddress">Address</label>
                            <textarea autocomplete="off" class="form-control address_fill" name="address" form="edit_address" id="Editaddress"></textarea>
                        </div>
                        <div class="col-lg-6 form-group mb-2">
                            <label class="mb-2" for="Editpostalcode">Postal Code</label>
                            <input type="text" required autocomplete="off" maxlength="7"
                                class="form-control postalCode_fill" form="edit_address" name="postalcode"
                                id="Editpostalcode">
                        </div>
                        <div class="col-lg-6 form-group mb-2">
                            <label class="mb-2" for="Editcity">City</label>
                            <input type="text" required autocomplete="off" class="form-control city_fill"
                                form="edit_address" name="city" id="Editcity">
                        </div>
                        <div class="col-lg-6 form-group mb-2">

                            <label class="mb-2" for="">Province</label>
                            <input form="edit_address" class="form-control province_fill" autocomplete="off"
                                type="text" name="province" id="Editprovince" placeholder="" required>


                        </div>

                        <div class="col-lg-12 form-group mb-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" form="edit_address" type="checkbox" name="base"
                                    id="Editbase">
                                <label class="form-check-label" for="Editbase">Default</label>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary swal2-styled swal2-cancel"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="edit_address"
                        class="swal2-confirm btn btn-theme swal2-styled swal2-default-outline">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('footer')
    <script>
        $('body').on('click', '.add_edit', function() {

            var name = $(this).data('name');
            var id = $(this).data('id');
            var address = $(this).data('address');
            var city = $(this).data('city');
            var postalcode = $(this).data('postalcode');
            var province = $(this).data('province');
            var country = $(this).data('country');
            var base = $(this).data('base');


            $('#name').val(name)
            $('#id').val(id)
            $('#Editaddress').val(address)
            $('#Editcity').val(city)
            $('#Editpostalcode').val(postalcode)
            $('#Editprovince').val(province)
            $('#Editcountry').val(country)
            if (base == 1) {
                $("#Editbase").prop("checked", true);
            } else {
                $("#Editbase").prop("checked", false);
            }

            $('#edit_Modal').modal('show')
        });
    </script>
@endpush
