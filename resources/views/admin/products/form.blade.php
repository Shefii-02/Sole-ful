@extends('admin.layouts.master')

@push('header')
    <link href="/assets/admin/products.css" rel="stylesheet" />
    <style>
        strong.select2-results__group {
            font-weight: 600;
            color: #999;
        }

        .apply-to-all {
            color: #fff !important;
            cursor: pointer;
        }

        .tab-panel {
            position: relative;
        }

        .row.topActions {
            position: absolute;
            right: 25px;
            top: -75px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #f6822d;
            border: 1px solid #f6822d;
            color: #fff;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            background-color: #f6822d !important;
            border: none;
            border-right: 1px solid #f6822d;
            color: #fff;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e3e3e3 !important;
            border-radius: 0px;
        }

        .select2-container .select2-selection--multiple {
            min-height: 44px !important;
        }

        .select2-container .select2-search--inline .select2-search__field {
            height: 22px !important;
        }
    </style>
    <style>
        .form-check-input {
            margin-top: 0.5rem !important;
        }

        .disable {
            pointer-events: none;
            opacity: 0.5;
        }

        #multi_step_form {
            padding-bottom: 75px;
        }

        #multi_step_form .container #multistep_nav {
            display: flex;
            justify-content: space-between;
        }

        .progress_holder {
            padding: 20px;
            width: 25%;
            text-align: center;
            display: -ms-flexbox;
            display: flex;
            flex-direction: column;
            align-content: center;
            align-items: center;
        }


        #multi_step_form .container fieldset.step {
            position: relative;
            padding: 125px;
            text-align: center;
            align-items: center;
            justify-content: center;
        }

        #multi_step_form .container fieldset.step .nextStep {
            color: #fff;
            border-bottom: 5px solid #d86500;
            background-image: -webkit-linear-gradient(30deg, #f6822d 50%, transparent 50%);
            background-image: linear-gradient(30deg, #f6822d 50%, transparent 50%);
            border-radius: 9px;
            right: 0;
            bottom: 0;
            padding: 10px;
            cursor: pointer;
            border-bottom: 5px solid #d86500;
            background: #f6822d;
            background-size: 900px;
            background-repeat: no-repeat;
            background-position: 0%;
            -webkit-transition: background .8s ease-in-out;
            transition: background .8s ease-in-out;



        }

        #multi_step_form .container fieldset.step .prevStep {
            color: #fff;
            border-bottom: 5px solid #d86500;
            background-image: -webkit-linear-gradient(30deg, #f6822d 50%, transparent 50%);
            background-image: linear-gradient(30deg, #f6822d 50%, transparent 50%);
            border-radius: 9px;
            right: 0;
            bottom: 0;
            padding: 10px;
            cursor: pointer;
            border-bottom: 5px solid #d86500;
            background: #f6822d;
            background-size: 900px;
            background-repeat: no-repeat;
            background-position: 0%;
            -webkit-transition: background .8s ease-in-out;
            transition: background .8s ease-in-out;
        }

        #multi_step_form .container fieldset.step:not(:first-of-type) {
            display: none;
        }

        .activated_step .step-icon {
            background-color: #f6822d !important;
            color: white;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            -o-border-radius: 50%;
            -ms-border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            background: rgba(0, 0, 0, .1);
            position: relative;
            outline: none;
            -o-outline: none;
            -ms-outline: none;
            -moz-outline: none;
            -webkit-outline: none;
            color: #666;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .step-icon i {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
        }

        span.select2.select2-container.select2-container--default {
            width: 100% !important;

        }

        span.select2.select2-container.select2-container--default {
            margin-left: 0px !important;
        }

        .online_category span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        span.select2.select2-container.select2-container--default.select2-container--below.select2-container--focus {
            margin-left: 0px;
            width: 100% !important;
        }

        span.select2.select2-container.select2-container--default.select2-container--focus {
            width: 100% !important;
            margin-left: 0px;
        }

        span.delete-group.btn.small,
        span.delete-variant.btn.small {
            transform: scale(0.5);
            right: -10px;
            top: -10px;
        }

        span.delete-group.btn,
        span.delete-variant.btn {
            position: absolute;
            right: -6px;
            top: 0;
            background: #d94747;
            color: #fff;
            transform: scale(0.75);
            width: auto;
            cursor: pointer;
        }

        .select2-container .select2-selection--single {
            height: 36px !important;
        }

        div#multistep_nav {
            display: flex;
            justify-content: space-around;
        }

        * {
            box-sizing: border-box;
        }

        div.s-lc span.select2 {
            margin: 0 !important;
        }

        div#multi_step_form div.container {
            margin: 0 !important;
            width: 100% !important;
            max-width: 100%;
        }


        /* Hide the "No results found" message */
        .select2-results__option.select2-results__message {
            display: none;
        }

        .select2-results {
            /*display: none;*/
        }

        .swal2-container.swal2-center.swal2-backdrop-show {
            z-index: 10001;
        }

        .modal {
            z-index: 10000;

        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@section('content')
    <div class="py-4">
        <div
            class="rounded-md border border-stroke bg-whiter p-4 py-3 dark:border-strokedark dark:bg-meta-4 sm:px-6 sm:py-5.5 xl:px-7.5">
            <nav>
                <ol class="flex flex-wrap items-center gap-2">
                    <li>
                        <a class="flex items-center gap-2 font-medium text-black hover:text-primary dark:text-white dark:hover:text-primary"
                            href="{{ route('admin.dashboard') }}">
                            <svg class="fill-current" width="15" height="15" viewBox="0 0 15 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.3503 14.6504H10.2162C9.51976 14.6504 8.93937 14.0698 8.93937 13.373V10.8183C8.93937 10.5629 8.73043 10.3538 8.47505 10.3538H6.54816C6.29279 10.3538 6.08385 10.5629 6.08385 10.8183V13.3498C6.08385 14.0465 5.50346 14.6272 4.80699 14.6272H1.62646C0.929989 14.6272 0.349599 14.0465 0.349599 13.3498V5.24444C0.349599 4.89607 0.535324 4.57092 0.837127 4.38513L6.96604 0.506623C7.29106 0.297602 7.73216 0.297602 8.05717 0.506623L14.1861 4.38513C14.4879 4.57092 14.6504 4.89607 14.6504 5.24444V13.3266C14.6504 14.0698 14.07 14.6504 13.3503 14.6504ZM6.52495 9.54098H8.45184C9.14831 9.54098 9.7287 10.1216 9.7287 10.8183V13.3498C9.7287 13.6053 9.93764 13.8143 10.193 13.8143H13.3503C13.6057 13.8143 13.8146 13.6053 13.8146 13.3498V5.26766C13.8146 5.19799 13.7682 5.12831 13.7218 5.08186L7.61608 1.20336C7.54643 1.15691 7.45357 1.15691 7.40714 1.20336L1.27822 5.08186C1.20858 5.12831 1.18536 5.19799 1.18536 5.26766V13.373C1.18536 13.6285 1.3943 13.8375 1.64967 13.8375H4.80699C5.06236 13.8375 5.2713 13.6285 5.2713 13.373V10.8183C5.24809 10.1216 5.82848 9.54098 6.52495 9.54098Z"
                                    fill=""></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.51145 1.55118L13.465 5.33306V13.3498C13.465 13.4121 13.4126 13.4646 13.3503 13.4646H10.193C10.1307 13.4646 10.0783 13.4121 10.0783 13.3498V10.8183C10.0783 9.92844 9.34138 9.19125 8.45184 9.19125H6.52495C5.63986 9.19125 4.89529 9.92534 4.9217 10.8238V13.373C4.9217 13.4354 4.86929 13.4878 4.80699 13.4878H1.64967C1.58738 13.4878 1.53496 13.4354 1.53496 13.373V5.33323L7.51145 1.55118ZM1.27822 5.08186L7.40714 1.20336C7.45357 1.15691 7.54643 1.15691 7.61608 1.20336L13.7218 5.08186C13.7682 5.12831 13.8146 5.19799 13.8146 5.26766V13.3498C13.8146 13.6053 13.6057 13.8143 13.3503 13.8143H10.193C9.93764 13.8143 9.7287 13.6053 9.7287 13.3498V10.8183C9.7287 10.1216 9.14831 9.54098 8.45184 9.54098H6.52495C5.82848 9.54098 5.24809 10.1216 5.2713 10.8183V13.373C5.2713 13.6285 5.06236 13.8375 4.80699 13.8375H1.64967C1.3943 13.8375 1.18536 13.6285 1.18536 13.373V5.26766C1.18536 5.19799 1.20858 5.12831 1.27822 5.08186ZM13.3503 15.0001H10.2162C9.32668 15.0001 8.58977 14.2629 8.58977 13.373V10.8183C8.58977 10.756 8.53735 10.7036 8.47505 10.7036H6.54816C6.48587 10.7036 6.43345 10.756 6.43345 10.8183V13.3498C6.43345 14.2397 5.69654 14.9769 4.80699 14.9769H1.62646C0.736911 14.9769 0 14.2397 0 13.3498V5.24444C0 4.77143 0.251303 4.33603 0.651944 4.08848L6.77814 0.211698C7.21781 -0.0704034 7.80541 -0.0704031 8.24508 0.211698C8.24546 0.211943 8.24584 0.212188 8.24622 0.212433L14.3713 4.08851C14.7853 4.34436 15 4.78771 15 5.24444V13.3266C15 14.2589 14.2671 15.0001 13.3503 15.0001ZM14.1861 4.38513L8.05717 0.506623C7.73216 0.297602 7.29106 0.297602 6.96604 0.506623L0.837127 4.38513C0.535324 4.57092 0.349599 4.89607 0.349599 5.24444V13.3498C0.349599 14.0465 0.929989 14.6272 1.62646 14.6272H4.80699C5.50346 14.6272 6.08385 14.0465 6.08385 13.3498V10.8183C6.08385 10.5629 6.29279 10.3538 6.54816 10.3538H8.47505C8.73043 10.3538 8.93937 10.5629 8.93937 10.8183V13.373C8.93937 14.0698 9.51976 14.6504 10.2162 14.6504H13.3503C14.07 14.6504 14.6504 14.0698 14.6504 13.3266V5.24444C14.6504 4.89607 14.4879 4.57092 14.1861 4.38513Z"
                                    fill=""></path>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="flex items-center gap-3 font-medium" href="{{ route('admin.products.index') }}">
                            <svg class="fill-current" width="18" height="7" viewBox="0 0 18 7" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.5704 2.58734L14.8227 0.510459C14.6708 0.333165 14.3922 0.307837 14.1896 0.459804C14.0123 0.61177 13.9869 0.890376 14.1389 1.093L15.7852 3.04324H1.75361C1.50033 3.04324 1.29771 3.24586 1.29771 3.49914C1.29771 3.75241 1.50033 3.95504 1.75361 3.95504H15.7852L14.1389 5.90528C13.9869 6.08257 14.0123 6.36118 14.1896 6.53847C14.2655 6.61445 14.3668 6.63978 14.4682 6.63978C14.5948 6.63978 14.7214 6.58913 14.7974 6.48782L16.545 4.41094C17.0009 3.85373 17.0009 3.09389 16.5704 2.58734Z"
                                    fill=""></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.1896 0.459804C14.3922 0.307837 14.6708 0.333165 14.8227 0.510459L16.5704 2.58734C17.0009 3.09389 17.0009 3.85373 16.545 4.41094L14.7974 6.48782C14.7214 6.58913 14.5948 6.63978 14.4682 6.63978C14.3668 6.63978 14.2655 6.61445 14.1896 6.53847C14.0123 6.36118 13.9869 6.08257 14.1389 5.90528L15.7852 3.95504H1.75361C1.50033 3.95504 1.29771 3.75241 1.29771 3.49914C1.29771 3.24586 1.50033 3.04324 1.75361 3.04324H15.7852L14.1389 1.093C13.9869 0.890376 14.0123 0.61177 14.1896 0.459804ZM15.0097 2.68302H1.75362C1.3014 2.68302 0.9375 3.04692 0.9375 3.49914C0.9375 3.95136 1.3014 4.31525 1.75362 4.31525H15.0097L13.8654 5.67085C13.8651 5.67123 13.8648 5.67161 13.8644 5.67199C13.5725 6.01385 13.646 6.50432 13.9348 6.79318C14.1022 6.96055 14.3113 7 14.4682 7C14.6795 7 14.9203 6.91713 15.0784 6.71335L16.8207 4.64286L16.8238 4.63904C17.382 3.95682 17.3958 3.00293 16.8455 2.35478C16.8453 2.35453 16.845 2.35429 16.8448 2.35404L15.0984 0.278534L15.0962 0.276033C14.8097 -0.0583053 14.3139 -0.0837548 13.9734 0.17163L13.964 0.17867L13.9551 0.186306C13.6208 0.472882 13.5953 0.968616 13.8507 1.30913L13.857 1.31743L15.0097 2.68302Z"
                                    fill=""></path>
                            </svg>
                            <span class="hover:text-primary">Products</span>
                        </a>
                    </li>
                    <li class="flex items-center gap-2 font-medium">
                        <svg class="fill-current" width="18" height="7" viewBox="0 0 18 7" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.5704 2.58734L14.8227 0.510459C14.6708 0.333165 14.3922 0.307837 14.1896 0.459804C14.0123 0.61177 13.9869 0.890376 14.1389 1.093L15.7852 3.04324H1.75361C1.50033 3.04324 1.29771 3.24586 1.29771 3.49914C1.29771 3.75241 1.50033 3.95504 1.75361 3.95504H15.7852L14.1389 5.90528C13.9869 6.08257 14.0123 6.36118 14.1896 6.53847C14.2655 6.61445 14.3668 6.63978 14.4682 6.63978C14.5948 6.63978 14.7214 6.58913 14.7974 6.48782L16.545 4.41094C17.0009 3.85373 17.0009 3.09389 16.5704 2.58734Z"
                                fill=""></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M14.1896 0.459804C14.3922 0.307837 14.6708 0.333165 14.8227 0.510459L16.5704 2.58734C17.0009 3.09389 17.0009 3.85373 16.545 4.41094L14.7974 6.48782C14.7214 6.58913 14.5948 6.63978 14.4682 6.63978C14.3668 6.63978 14.2655 6.61445 14.1896 6.53847C14.0123 6.36118 13.9869 6.08257 14.1389 5.90528L15.7852 3.95504H1.75361C1.50033 3.95504 1.29771 3.75241 1.29771 3.49914C1.29771 3.24586 1.50033 3.04324 1.75361 3.04324H15.7852L14.1389 1.093C13.9869 0.890376 14.0123 0.61177 14.1896 0.459804ZM15.0097 2.68302H1.75362C1.3014 2.68302 0.9375 3.04692 0.9375 3.49914C0.9375 3.95136 1.3014 4.31525 1.75362 4.31525H15.0097L13.8654 5.67085C13.8651 5.67123 13.8648 5.67161 13.8644 5.67199C13.5725 6.01385 13.646 6.50432 13.9348 6.79318C14.1022 6.96055 14.3113 7 14.4682 7C14.6795 7 14.9203 6.91713 15.0784 6.71335L16.8207 4.64286L16.8238 4.63904C17.382 3.95682 17.3958 3.00293 16.8455 2.35478C16.8453 2.35453 16.845 2.35429 16.8448 2.35404L15.0984 0.278534L15.0962 0.276033C14.8097 -0.0583053 14.3139 -0.0837548 13.9734 0.17163L13.964 0.17867L13.9551 0.186306C13.6208 0.472882 13.5953 0.968616 13.8507 1.30913L13.857 1.31743L15.0097 2.68302Z"
                                fill=""></path>
                        </svg>
                        {{ isset($product) ? 'Edit' : 'Create' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    @if ($errors->count())
        <div class="alert alert-danger alert-dismissable">
            Sorry some errors in form submission
        </div>
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif

    <div class="flex flex-col gap-9">
        <!-- Form Container -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                <h2 class="text-title-sm2 font-bold text-black dark:text-black">
                    {{ isset($product) ? 'Edit Product' : 'Create a Product' }}
                </h2>
            </div>
            <form method="post" action="" id="product_form" enctype="multipart/form-data">
                <div id="tab-wrapper">
                    <!----------------------------------------// TAB NAVIGATION //---------------------------------->
                    <nav id="tab-navigation">
                        <ul>
                            <li class="active" id="nav-info">
                                <a href="#product-info" class="tabnav tab1" data-no="1" data-target="back-product-info">
                                    <span><big>Product</big> Basic Info</span>
                                </a>
                            </li>

                            <li id="nav-variants">
                                <a href="#product-variants" class="tabnav tab2" data-no="2"
                                    data-target="save-product-info">
                                    <span><big>Variants</big> and Pricing</span>
                                </a>
                            </li>


                            <li id="nav-images">
                                <a href="#product-images" class="tabnav tab4" data-no="3"
                                    data-target="save-product-variants">
                                    <span><big>Images</big> Uploads</span>
                                </a>

                            </li>


                        </ul>
                    </nav>

                    <div class="tab-panels">

                        <!----------------------------------------// BASICS TAB //---------------------------------->

                        <div class="tab-panel" id="product-info">
                            <div class="row topActions">
                                <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-theme button-1  ctm-border-radius p-2 ctm-btn-padding"
                                        id="save-product-info"> &nbsp; Next Step &nbsp; </a>
                                </div>
                            </div>
                            <h2>Basic Product Info</h2>

                            <div class="row mb-3">
                                <div class="form-group col-md-12">
                                    <label class="form-group__label">Product Name</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        value="{{ old('name', isset($product) ? $product->name : '') }}" placeholder=""
                                        autocomplete="off">

                                </div>
                            </div>

                            <div class="row ">
                                <div class="form-group col-md-4 mb-3">
                                    <label class="form-group__label">ART Code</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        value="{{ old('name', isset($product) ? $product->name : '') }}" placeholder=""
                                        autocomplete="off">
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label class="form-group__label">Shoe Type</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        value="{{ old('name', isset($product) ? $product->name : '') }}" placeholder=""
                                        autocomplete="off">
                                </div>
                                <div class="form-group col-md-4 mb-3">
                                    <label class="form-group__label">Gender</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                        value="{{ old('name', isset($product) ? $product->name : '') }}" placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-group col-md-12">
                                    <label class="form-group__label">Care Instruction</label>
                                    <textarea name="contents" class="form-control ckeditor-textarea" id="contents" rows="4" placeholder=""
                                        autocomplete="off">{{ old(
                                            'contents',
                                            isset($product)
                                                ? $product->contents
                                                : 'Keep your product dry avoid getting it wet or damp. To clean it, simply wipe with a dry cloth. keep fasteners and zip running smoothly by running pencil leads over the open teeth.',
                                        ) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-group col-md-12">
                                    <label class="form-group__label">Marketed By</label>
                                    <textarea name="baking_info" class="form-control" id="baking_info" rows="4" placeholder=""
                                        autocomplete="off">{{ old(
                                            'baking_info',
                                            isset($product)
                                                ? $product->baking_info
                                                : 'VOCHE THE INTERIOR STUDIO #5 1 FLOOR GEDDALAHALLI,HENNUR BAGLUR MAIN ROAD KOTHALUR POST BLR.560077',
                                        ) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="form-group col-md-12">
                                    <label class="form-group__label">Manufactured By</label>
                                    <textarea name="baking_info" class="form-control" id="baking_info" rows="4" placeholder=""
                                        autocomplete="off">{{ old('baking_info', isset($product) ? $product->baking_info : 'UNIVERSAL EXPORTS # 101 ARIHANT COMMERCIAL COMPLEX PURNA VILLAGE  BHIWANDI ,THAHE .421302') }}</textarea>
                                </div>
                            </div>



                            <div class="row mb-3">
                                <div class="form-group col-xs-2 col-md-4">
                                    <div class="mb-2 w-full me-3">
                                      
                                        <div class="form-group mb-3">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" name="status" x-model="enabled" type="checkbox" value="active"
                                                    id="status"
                                                    {{ old('status', isset($coupon) && $coupon->status ? 'checked' : '') }}>
                                                <span class="form-check-label">Set as Featured product</span>
                                            </label>
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="form-group col-xs-2 col-md-4">
                                    <div class="mb-2 w-full me-3">
                                      
                                        <div class="form-group mb-3 ">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" name="status" x-model="enabled" type="checkbox" value="active"
                                                    id="status"
                                                    {{ old('status', isset($coupon) && $coupon->status ? 'checked' : '') }}>
                                                <span class="form-check-label">Set as Best selling product</span>
                                            </label>
                                        </div>
                                        
                                    </div>
                                   
                                </div>

                                {{-- <div class="form-group col-xs-2 col-md-12">
                                    <div class="mb-2 w-full me-3">
                                      
                                        <div class="form-group mb-3">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" name="status" x-model="enabled" type="checkbox" value="active"
                                                    id="status"
                                                    {{ old('status', isset($coupon) && $coupon->status ? 'checked' : '') }}>
                                                <span class="form-check-label">Mark out of stock</span>
                                            </label>
                                        </div>
                                        
                                    </div>
                                 
                                </div> --}}
                                <div class="form-group col-xs-2 col-md-12">
                                    <div class="mb-2 w-full me-3">
                                        <div class="form-group mb-3">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" name="status" x-model="enabled" type="checkbox" value="active"
                                                    id="status"
                                                    {{ old('status', isset($coupon) && $coupon->status ? 'checked' : '') }}>
                                                <span class="form-check-label">Enable on Publish</span>
                                            </label>
                                        </div>
                                        
                                    </div>

                                   
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 text-right">
                                    <a href="#"
                                        class="btn btn-theme button-1  ctm-border-radius p-2 ctm-btn-padding"
                                        id="save-product-info"> &nbsp; Next Step &nbsp; </a>
                                </div>
                            </div>
                        </div>
                        <!----------------------------------------// VARIANTS TAB //---------------------------------->

                        <div class="tab-panel" id="product-variants">
                            <div class="row topActions">
                                <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-theme button-2 bg-light ctm-border-radius p-2"
                                        id="back-product-info"> &nbsp; &nbsp; Back &nbsp; &nbsp; </a>
                                    <a href="#"
                                        class="btn btn-theme button-1  ctm-border-radius p-2 ctm-btn-padding"
                                        id="save-product-variants"> &nbsp; &nbsp; Next Step &nbsp; &nbsp; </a>
                                </div>
                            </div>
                            <h2>Variants and Pricing</h2>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <div class="mb-2 w-full me-3">
                                        <div class="form-group mb-3 col-md-4">
                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" value="active" name="has_variants"
                                                    @if (old('has_variation', isset($product) ? $product->has_variation : 0) == 1) checked @endif id="has-variants" 
                                                >
                                                <span class="form-check-label">This product has multiple prices</span>
                                            </label>
                                        </div>
                                        
                                    </div>

                                    {{-- <div class="pretty p-switch p-fill">
                                        <input type="checkbox" name="has_variants"
                                            @if (old('has_variation', isset($product) ? $product->has_variation : 0) == 1) checked @endif id="has-variants" />
                                        
                                        <div class="state p-success">
                                            <label class="control-label">This product has multiple prices</label>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="variants-no"
                                @if (isset($product)) @if ($product->has_variation == '0') style="display:block" @else style="display:none" @endif
                                @endif>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="row productVariant" data-id="single_variant">
                                            <div class="col-md-4 form-group">
                                                <input type="hidden" class="form-control" name="product_option_signle"
                                                    value="1" />
                                                <input type="text" name="product_sku_single"
                                                    value="{{ old('product_sku_single', isset($product) && !$product->has_variation ? $product->product_variation->first()->sku : '') }}"
                                                    class="form-control pv-sku" placeholder="" />
                                                <label class="form-group__label">Sku</label>
                                            </div>

                                            <!--<div class="col-md-1">-->
                                            <!--    <input type="number" min="0" name="product_quantity_single" value="{{ old('product_quantity_single', isset($product) && !$product->has_variation ? $product->product_variation->first()->box_quantity : '') }}" class="form-control pv-name" placeholder="Quantity" />-->
                                            <!--</div>-->
                                            <div class="col-md-3 form-group">
                                                <input type="text" name="product_weight_single"
                                                    value="{{ old('product_sku_single', isset($product) && !$product->has_variation ? $product->product_variation->first()->weight : 0) }}"
                                                    class="form-control" placeholder="" />
                                                <label class="form-group__label">Weight</label>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <input type="number" name="product_price_single"
                                                    value="{{ old('product_sku_single', isset($product) && !$product->has_variation ? $product->product_variation->first()->price : 1) }}"
                                                    class="form-control pv-price" placeholder="" />
                                                <label class="form-group__label">Price</label>
                                            </div>

                                            <div class="col-md-2 form-group">
                                                <input type="text" name="product_stock_single" value="0"
                                                    class="form-control option-price" placeholder="" />
                                                <label class="form-group__label">Stock</label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="variants-yes"
                                @if (isset($product)) @if ($product->has_variation == '1') style="display:block" @else style="display:none" @endif
                                @endif>

                                <div class="mb-2"><a href="#" class="show-options" style="color:#000;">Add/Edit
                                        Product Options</a></div>

                                @if (isset($product) && count($product->product_variation))

                                    @php
                                        $options = [];
                                        $opt = [];

                                        foreach ($product->option as $option) {
                                            $options[$option->name][] = $option->value;
                                        }

                                        foreach ($options as $key => $option) {
                                            $values = [];

                                            foreach ($option as $val) {
                                                $values[] = $val;
                                            }

                                            $opt[] = ['name' => $key, 'values' => $values];
                                        }

                                        $var = getVariants($opt, 0, '');
                                        $variant_options = explode("\n", $var);
                                        array_pop($variant_options);

                                    @endphp

                                    @foreach ($product->product_variation as $vkey => $variation)
                                        <div class="row mb-3">

                                            @php $rand_name = 'UID-'.$variation->id; @endphp
                                            <a href="#" class=""><span
                                                    class="bi bi-x-circle text-danger del-variant"></span></a>
                                            <div class="col-md-12">
                                                <div class="row productVariant" data-id="{{ $rand_name }}">

                                                    <div class="col-md-2">
                                                        <select class="form-control option-select"
                                                            name="variants[{{ $rand_name }}]"
                                                            data-option="{{ $rand_name }}">
                                                            <option value="">Select an Option</option>
                                                            @foreach ($variant_options as $option)
                                                                @php
                                                                    $parts = explode(',', $option);
                                                                    $option_string = '';
                                                                    foreach ($parts as $part) {
                                                                        $subparts = explode(':', $part);
                                                                        $option_string .= isset($subparts[1])
                                                                            ? $subparts[1] . ' '
                                                                            : '';
                                                                    }
                                                                @endphp

                                                                <option value="{{ $option }}"
                                                                    @if ($variation->variation == $option) selected @endif>
                                                                    {{ trim($option_string) }}</option>
                                                            @endforeach
                                                            <option value="new-option">Add/Edit Multiple
                                                                Options</option>
                                                        </select>

                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="text" name="variants_sku[{{ $rand_name }}]"
                                                            value="{{ $variation->sku }}"
                                                            class="form-control option-sku pv-sku" placeholder="" />
                                                        <label class="form-group__label">SKU</label>
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <input type="text" name="variants_name[{{ $rand_name }}]"
                                                            value="{{ $variation->variation_name }}"
                                                            class="form-control option-name pv-name" placeholder="" />
                                                        <label class="form-group__label">Variant name</label>
                                                    </div>

                                                    <div class="col-md-1 form-group">
                                                        <input type="text" name="variants_weight[{{ $rand_name }}]"
                                                            value="{{ $variation->weight }}"
                                                            class="form-control option-weight " placeholder="" />
                                                        <label class="form-group__label">Weight</label>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="number" name="variants_price[{{ $rand_name }}]"
                                                            value="{{ $variation->price }}"
                                                            class="form-control option-price pv-price" placeholder="" />
                                                        <label class="form-group__label">Price</label>
                                                    </div>
                                                    <div class="col-md-2 form-group">
                                                        <input type="text" name="variants_stock[{{ $rand_name }}]"
                                                            value="0" class="form-control option-price"
                                                            placeholder="" />
                                                        <label class="form-group__label">Stock</label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-3">
                                        <a href="#" class=""><span
                                                class="bi bi-x-circle text-danger del-variant"></span></a>
                                        @php $rand_name = substr(md5(rand()),2,7); @endphp
                                        <div class="col-md-12">
                                            <div class="row productVariant" data-id="{{ $rand_name }}">
                                                <div class="col-md-2">
                                                    <select class="form-control option-select"
                                                        name="variants[{{ $rand_name }}]"
                                                        data-option="{{ $rand_name }}">
                                                        <option value="">Select an Option</option>
                                                        <option value="new-option">Add/Edit Multiple Options
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <input type="text" name="variants_sku[{{ $rand_name }}]"
                                                        value="" class="form-control option-sku" placeholder="" />
                                                    <label class="form-group__label">SKU</label>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <input type="text" name="variants_name[{{ $rand_name }}]"
                                                        value="" class="form-control option-name" placeholder="" />
                                                    <label class="form-group__label">Variant name</label>
                                                </div>
                                                <div class="col-md-1 form-group">
                                                    <input type="text" name="variants_weight[{{ $rand_name }}]"
                                                        value="" class="form-control option-weight"
                                                        placeholder="" />
                                                    <label class="form-group__label">Weight</label>
                                                </div>

                                                <div class="col-md-2 form-group">
                                                    <input type="text" name="variants_price[{{ $rand_name }}]"
                                                        value="1.00" class="form-control option-price"
                                                        placeholder="" />
                                                    <label class="form-group__label">Price</label>
                                                </div>
                                                <div class="col-md-2 form-group">
                                                    <input type="text" name="variants_stock[{{ $rand_name }}]"
                                                        value="0" class="form-control option-price"
                                                        placeholder="" />
                                                    <label class="form-group__label">Stock</label>
                                                </div>



                                            </div>
                                        </div>

                                    </div>



                                @endif

                                <a href="#" class="add-variant"><i class="bi bi-plus" style="font-size:20px;"></i>
                                    Add Variant</a>

                            </div>

                            <div class="row">
                                <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-theme button-2 bg-light ctm-border-radius p-2"
                                        id="back-product-info"> &nbsp; &nbsp; Back &nbsp; &nbsp; </a>
                                    <a href="#"
                                        class="btn btn-theme button-1  ctm-border-radius p-2 ctm-btn-padding"
                                        id="save-product-variants"> &nbsp; &nbsp; Next Step &nbsp; &nbsp; </a>
                                </div>
                            </div>
                        </div>

                        <!----------------------------------------// IMAGES TAB //---------------------------------->

                        <div class="tab-panel" id="product-images">
                            <div class="row topActions">
                                <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-theme button-2 bg-light ctm-border-radius p-2"
                                        id="back-product-images"> &nbsp; &nbsp; Back &nbsp; &nbsp; </a>
                                    <a href="#"
                                        class="btn btn-theme button-1  ctm-border-radius p-2 ctm-btn-padding"
                                        id="save-product-nutrition"> &nbsp; &nbsp; Save the Product &nbsp;
                                        &nbsp; </a>
                                </div>
                            </div>
                            <h2>Product Images</h2>
                            <div class="row">


                                @if (isset($product) && count($product->images))
                                    @foreach ($product->images->sortBy('id') as $image)
                                        @php $rand_name = 'UID-'.$image->id; @endphp
                                        <div class="col-md-6 mb-3">
                                            <div class="box-div">
                                                <div class="row">
                                                    <div class="col-md-7 position-relative">
                                                        <a href="#" class="del-image"
                                                            data-id="{{ $rand_name }}">
                                                            <span class="bi bi-x-circle text-danger fs-3"></span>
                                                        </a>
                                                        <input type="file" class="product-image"
                                                            data-img="img-{{ $rand_name }}"
                                                            data-src="src-{{ $rand_name }}" />
                                                        <img src="/images/products/{{ $image->picture }}"
                                                            style="width:200px;height:auto;" class="mt-3"
                                                            id="img-{{ $rand_name }}" />
                                                        <input type="hidden" name="product_images[{{ $rand_name }}]"
                                                            id="src-{{ $rand_name }}">
                                                    </div>
                                                    <div class="col-md-5 position-relative">
                                                        <select class="form-control mb-2"
                                                            name="product_images_type[{{ $rand_name }}]">
                                                            <option value="Extra Image"
                                                                @if ($image->type == 'Extra Image') selected @endif>
                                                                Extra</option>
                                                            <option value="Main Image"
                                                                @if ($image->type == 'Main Image') selected @endif>
                                                                Main</option>
                                                            <option value="Thumbnail"
                                                                @if ($image->type == 'Thumbnail') selected @endif>
                                                                Thumbnail</option>
                                                        </select>

                                                        <div class="box-div" style="height:200px;">
                                                            <div class="product-images-variants"
                                                                id="{{ $rand_name }}">

                                                                @foreach ($product->product_variation as $vkey => $variation)
                                                                    <div class="product-images-variant">
                                                                        <div class="pretty p-switch p-fill">
                                                                            <input type="checkbox"
                                                                                name="product_images_variant[{{ $rand_name }}][{{ $variation->id }}]"
                                                                                @if ($image->variation_image->where('variation_id', '=', $variation->id)->count() > 0) checked @endif
                                                                                value="{{ $variation->sku }}" />
                                                                            <div class="state p-success">
                                                                                <label
                                                                                    class="control-label">`+item.name+`</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-6 mb-3">
                                        <div class="box-div">
                                            <div class="row">
                                                <div class="col-md-7 ">
                                                    <a href="#" class="del-image" data-id="{{ $rand_name }}">
                                                        <span class="bi bi-x fs-3"></span>
                                                    </a>
                                                    <input type="file" class="product-image"
                                                        data-img="img-{{ $rand_name }}"
                                                        data-src="src-{{ $rand_name }}" />
                                                    <img src="/assets/img/noimage.png" style="width:200px;height:auto;"
                                                        class="mt-3" id="img-{{ $rand_name }}" />
                                                    <input type="hidden" name="product_images[{{ $rand_name }}]"
                                                        id="src-{{ $rand_name }}">
                                                </div>
                                                <div class="col-md-5  position-relative">
                                                    <select class="form-control mb-2"
                                                        name="product_images_type[{{ $rand_name }}]">
                                                        <option value="Extra Image">Extra</option>
                                                        <option value="Main Image">Main</option>
                                                        <option value="Thumbnail">Thumbnail</option>
                                                    </select>

                                                    <div class="box-div" style="height:200px;">
                                                        <div class="product-images-variants" id="{{ $rand_name }}">



                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-1 mb-3">
                                    <a href="#" class="add-image">
                                        <i class="bi bi-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 text-right">
                                    <a href="#" class="btn btn-theme button-2 bg-light ctm-border-radius p-2"
                                        id="back-product-images"> &nbsp; &nbsp; Back &nbsp; &nbsp; </a>
                                    <a href="#"
                                        class="btn btn-theme button-1  ctm-border-radius p-2 ctm-btn-padding"
                                        id="save-product-nutrition"> &nbsp; &nbsp; Save the Product &nbsp;
                                        &nbsp; </a>
                                </div>
                            </div>
                        </div>
                    </div><!-- Tab Panels //-->

                </div><!-- Tab Wrapper //-->

                {{ csrf_field() }}


                <div class="modal fade" id="variation-options-modal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="width:70%;max-width:100%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel">Add/Edit Product Options</h45>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @if (isset($product) && count($product->option))

                                        @php
                                            $options = [];
                                        @endphp

                                        @foreach ($product->option as $option)
                                            @php
                                                $options[$option->name][] = $option;
                                            @endphp
                                        @endforeach

                                        @foreach ($options as $key => $option)
                                            <div class="col-md-6 mb-3">
                                                @php $rand_name = substr(md5(rand()),2,7); @endphp
                                                <div class="box-div">
                                                    <div class="row">
                                                        <a href="#" class="">
                                                            <span
                                                                class="bi bi-x-circle-fill fs-3 text-danger del-option"></span>
                                                        </a>
                                                        <div class="col-md-6">
                                                            <select
                                                                class="form-control option-type option-type-{{ $rand_name }}"
                                                                data-random="{{ $rand_name }}"
                                                                name="variant_options[{{ $rand_name }}]">
                                                                <option value="size"
                                                                    @if ($key == 'size') selected @endif>
                                                                    Size</option>
                                                                <option value="color"
                                                                    @if ($key == 'color') selected @endif>
                                                                    Color</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5">
                                                            @foreach ($option as $option_values)
                                                                <a href="#" class="del-option-value"><span
                                                                        class="bi bi-x fs-3 text-danger">close</span></a>
                                                                <select
                                                                    name="variant_option_values[{{ $rand_name }}][]"
                                                                    class="form-control option-value mb-2">
                                                                    <option value="">Select Size</option>
                                                                    <option value="S">Small (S)</option>
                                                                    <option value="M">Medium (M)</option>
                                                                    <option value="L">Large (L)</option>
                                                                    <option value="XL">Extra Large (XL)
                                                                    </option>
                                                                    <option value="XXL">Double Extra Large
                                                                        (XXL)
                                                                    </option>
                                                                </select>
                                                                {{-- <input type="text"
                                                                                class="form-control option-value mb-2"
                                                                                data-random="{{ $rand_name }}"
                                                                                value="{{ $option_values->value }}"
                                                                                name="variant_option_values[{{ $rand_name }}][]" /> --}}
                                                            @endforeach
                                                            <a href="#" class="add-option-value mt-2"
                                                                data-random="{{ $rand_name }}">
                                                                <i class="bi bi-plus fs-3" style="font-size:20px;"></i>
                                                                <span>Add Size</span>
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-6 mb-3">
                                            @php $rand_name = substr(md5(rand()),2,7); @endphp
                                            <div class="box-div">
                                                <div class="row position-relative">
                                                    <a href="#" class="">
                                                        <span
                                                            class="bi bi-x-circle-fill fs-3 text-danger del-option"></span>
                                                    </a>
                                                    <div class="col-md-6">
                                                        <select
                                                            class="form-control option-type option-type-{{ $rand_name }}"
                                                            data-random="{{ $rand_name }}"
                                                            name="variant_options[{{ $rand_name }}]">
                                                            <option value="size">Size</option>
                                                            <option value="color">Color</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5 position-relative">
                                                        {{-- <a href="#" class="del-option-value"><span
                                                                            class="bi bi-x fs-3 text-danger"></span></a> --}}
                                                        {{-- <input type="text"
                                                                        class="form-control option-value mb-2"
                                                                        data-random="{{ $rand_name }}"
                                                                        name="variant_option_values[{{ $rand_name }}][]" /> --}}
                                                        <select name="variant_option_values[{{ $rand_name }}][]"
                                                            data-random="{{ $rand_name }}"
                                                            class="form-control option-value mb-2 option-value-{{ $rand_name }}">
                                                            <option value="">Select Size</option>
                                                            <option value="S">Small (S)</option>
                                                            <option value="M">Medium (M)</option>
                                                            <option value="L">Large (L)</option>
                                                            <option value="XL">Extra Large (XL)</option>
                                                            <option value="XXL">Double Extra Large (XXL)
                                                            </option>
                                                        </select>
                                                        <a href="#" class="add-option-value mt-2"
                                                            data-random="{{ $rand_name }}">
                                                            <i class="bi bi-plus fs-3" style="font-size:20px;"></i>
                                                            <span>Add Size</span>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-1 py-10">
                                        <a href="#" class="add-option">
                                            <i class="bi bi-plus fs-3"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-theme button-2 bg-light ctm-border-radius p-2"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="button"
                                    class="btn btn-theme button-1  ctm-border-radius p-2 ctm-btn-padding"
                                    id="save-options">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>
@endsection
@push('footer')
    <script language="javascript" src="/assets/admin/product2.js?v=1.1.0" defer></script>
    <script language="javascript">
        @isset($product)
            $('.tabnav').on('click', function() {
                $('#save-product-info').click();
                $('#save-product-variants').click();

                $('.tab-panel').hide();
                $('#' + $(this).data('target')).click();
            });
        @endif

        $(document).on('click', '.del-ingredient', function(e) {
            e.preventDefault();
            $(this).closest('.ingredient-group-container').remove();
        });

        $('.apply-to-all').on('click', function(e) {
            if ($('#special_price').is(':checked')) {
                applyAll()
            }
        });

        $('#has-variants').on('click', function(e) {
            if ($('#special_price').is(':checked') && $('.special_variants').children().length) {
                applyAll()
            }

        });

        function applyAll() {
            let pvs = $('.productVariant')
            if ($('#has-variants').is(':checked')) {
                pvs = $('.variants-yes .productVariant')
            } else {
                pvs = $('.variants-no .productVariant')
            }
            $('.special_variants').empty();
            pushSpecialPrice(pvs);
        }

        function pushSpecialPrice(pvs) {
            if ($('#has-variants').is(':checked')) {
                $('.id-single_variant').remove();
            } else {
                $('.sp:not(.id-single_variant)').remove();
            }

            pvs.each(function() {
                let id = $(this).attr('data-id');

                if (!$('.id-' + id).length) {
                    let sku = $(this).find('.pv-sku').val();
                    let name = $(this).find('.pv-name').val();
                    let price = parseFloat($(this).find('.pv-price').val());
                    price = isNaN(price) ? 0 : price;

                    let discountType = $('[name="discount_type"]').val();
                    let discountValue = parseFloat($('[name="discount_value"]').val());

                    discountValue = isNaN(discountValue) ? 0 : discountValue;

                    let newPrice = price;

                    if (discountValue && !isNaN(discountValue) && discountType == 'percentage') {
                        newPrice = Math.max((discountValue + 100) / 100 * price, 0)
                    } else if (discountValue && !isNaN(discountValue) && discountType == 'amount') {
                        newPrice = Math.max(price + discountValue, 0)
                    }

                    let priceDiff = newPrice - price;

                    $('.special_variants').append(`<div class="sp splist row align-items-center mb-2 id-${id}" data-id="${id}">
                <div class="col-lg-2 font-weight-bold spl-name">${name} <span class="font-weight-normal">($${price.toFixed(2)})</span></div>
                <div class="col-lg-2"><input type="number" step="any" min="0" max="${price.toFixed(2)}" name="special_price[${sku}]" data-price="${price.toFixed(2)}" value="${newPrice.toFixed(2)}" class="form-control spl-price" placeholder="Special price"></div>
                <div class="col-lg-2 priceText"></div>
                </div>`);
                    $(setPriceText);
                }
            });
        }

        $('.add-variant').on('click', function() {
            setTimeout(function() {
                if ($('#special_price').is(':checked') && $('.special_variants').children().length) {
                    pvs = $('.variants-yes .productVariant');
                    pushSpecialPrice(pvs);
                }
            }, 500)
        });

        const setPriceText = function() {
            let discountType = $('[name="discount_type"]').val();
            $('.splist').each(function() {
                let actualPrice = parseFloat($(this).find('.spl-price').attr('data-price'));
                let specialPrice = parseFloat($(this).find('.spl-price').val());

                let diff = specialPrice - actualPrice;

                let prefix = specialPrice > actualPrice ? '+' : (actualPrice > specialPrice ? '-' : '');

                let discountValue = 0;
                let discountText = null;

                let d = actualPrice > specialPrice ? 'Discount' : (actualPrice < specialPrice ? 'Over price' :
                    '');

                if (discountType == 'amount') {
                    discountText = `${prefix}$${Math.abs(diff).toFixed(2)}`;
                } else {
                    discountValue = ((Math.abs(diff) / actualPrice) * 100).toFixed(1);
                    discountValue = isNaN(discountValue) ? 0 : discountValue;
                    discountText = `${prefix}$${Math.abs(diff).toFixed(2)}(${discountValue}%)`;
                }

                $(this).find('.priceText').text(`${d} ${discountText}`);
            });
        }

        function discountInput(input) {
            let value = input.value.trim();
            if (value !== '') {
                let num = parseFloat(value);
                if (!isNaN(num)) {
                    input.value = -Math.abs(num);
                } else {
                    input.value = '';
                }
            }
        }
        // $('#discount_value').on('input keyup change', function(){
        //     let v = $(this).val().trim();
        //     let n = v.replace(/[^0-9.]+/g, '').replace(/(\.\.)+/g, '.').replace(/^(\d*\.\d*)\./, '$1');
        //     if(n){
        //       $(this).val('-'+n)  
        //     }else{
        //         $(this).val('');
        //     }

        // });
        $(document).on('change input keyup', '.spl-price', setPriceText);

        $(setPriceText);

        $(document).on('change input keyup', '.pv-name, .pv-price', function() {
            let id = $(this).closest('.productVariant').attr('data-id');
            $('.id-' + id).find('.spl-name').html($(this).closest('.productVariant').find('.pv-name').val() +
                `<span class="font-weight-normal"> ($${$(this).closest('.productVariant').find('.pv-price').val()})</span>`
            );
            $('.id-' + id).find('.spl-price').attr('data-price', $(this).closest('.productVariant').find(
                '.pv-price').val());
        });

        $(document).on('change input keyup', '.pv-sku', function() {
            let id = $(this).closest('.productVariant').attr('data-id');
            $('.id-' + id).find('.spl-price').attr('name', `special_price[${$(this).val()}]`);
        });

        const specialPrice = function() {
            if ($('#special_price').is(':checked')) {
                $('.special_price_settings').show();
                $('#special_price_from, #special_price_to').attr('required', true);
            } else {
                $('#special_price_from, #special_price_to').removeAttr('required');
                $('.special_price_settings').hide();
            }

            if ($('#special_price').is(':checked') && !$('.special_variants').children().length) {
                applyAll()
            }

        }

        $('#special_price').on('click', specialPrice)
        $(specialPrice);

        $("body").delegate("#select-all-stores", "click", function(e) {

            if ($(this).is(":checked")) {
                $(".store-select").attr("checked", "checked");
            } else {
                $(".store-select").removeAttr("checked");
            }

        });
    </script>
@endpush
