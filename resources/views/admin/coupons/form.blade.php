@extends('admin.layouts.master')

@section('content')
    <style>
        .coupon {
            border: 5px dotted #bbb;
            width: 80%;
            border-radius: 15px;
            margin: 0 auto;
            max-width: 600px;
        }

        .promo {
            background: #ccc;
            padding: 3px;
        }
    </style>
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
                        <a class="flex items-center gap-3 font-medium" href="{{ route('admin.coupons.index') }}">
                            <svg class="fill-current" width="18" height="7" viewBox="0 0 18 7" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.5704 2.58734L14.8227 0.510459C14.6708 0.333165 14.3922 0.307837 14.1896 0.459804C14.0123 0.61177 13.9869 0.890376 14.1389 1.093L15.7852 3.04324H1.75361C1.50033 3.04324 1.29771 3.24586 1.29771 3.49914C1.29771 3.75241 1.50033 3.95504 1.75361 3.95504H15.7852L14.1389 5.90528C13.9869 6.08257 14.0123 6.36118 14.1896 6.53847C14.2655 6.61445 14.3668 6.63978 14.4682 6.63978C14.5948 6.63978 14.7214 6.58913 14.7974 6.48782L16.545 4.41094C17.0009 3.85373 17.0009 3.09389 16.5704 2.58734Z"
                                    fill=""></path>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14.1896 0.459804C14.3922 0.307837 14.6708 0.333165 14.8227 0.510459L16.5704 2.58734C17.0009 3.09389 17.0009 3.85373 16.545 4.41094L14.7974 6.48782C14.7214 6.58913 14.5948 6.63978 14.4682 6.63978C14.3668 6.63978 14.2655 6.61445 14.1896 6.53847C14.0123 6.36118 13.9869 6.08257 14.1389 5.90528L15.7852 3.95504H1.75361C1.50033 3.95504 1.29771 3.75241 1.29771 3.49914C1.29771 3.24586 1.50033 3.04324 1.75361 3.04324H15.7852L14.1389 1.093C13.9869 0.890376 14.0123 0.61177 14.1896 0.459804ZM15.0097 2.68302H1.75362C1.3014 2.68302 0.9375 3.04692 0.9375 3.49914C0.9375 3.95136 1.3014 4.31525 1.75362 4.31525H15.0097L13.8654 5.67085C13.8651 5.67123 13.8648 5.67161 13.8644 5.67199C13.5725 6.01385 13.646 6.50432 13.9348 6.79318C14.1022 6.96055 14.3113 7 14.4682 7C14.6795 7 14.9203 6.91713 15.0784 6.71335L16.8207 4.64286L16.8238 4.63904C17.382 3.95682 17.3958 3.00293 16.8455 2.35478C16.8453 2.35453 16.845 2.35429 16.8448 2.35404L15.0984 0.278534L15.0962 0.276033C14.8097 -0.0583053 14.3139 -0.0837548 13.9734 0.17163L13.964 0.17867L13.9551 0.186306C13.6208 0.472882 13.5953 0.968616 13.8507 1.30913L13.857 1.31743L15.0097 2.68302Z"
                                    fill=""></path>
                            </svg>
                            <span class="hover:text-primary">Coupons</span>
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
                        {{ isset($coupon) ? 'Edit' : 'Create' }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="flex flex-col gap-9">
        <!-- Form Container -->
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
            <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
                <h2 class="text-title-sm2 font-bold text-black dark:text-black">
                    {{ isset($coupon) ? 'Edit Coupon' : 'Create a Coupon' }}
                </h2>
            </div>

            <form x-data="{
                code: `{{ old('code', $coupon->code ?? '---') }}`,
                value: `{{ old('value', $coupon->value ?? '0') }}`,
                valueType: `{{ old('value_type', $coupon->value_type ?? 'percentage') }}`,
                maxCount: `{{ old('max_count', $coupon->max_count ?? '50000') }}`,
                startDate: `{{ isset($coupon) ? old('start_time', date('Y-m-d', strtotime($coupon->start_time))) : date('Y-m-d') }}`,
                endDate: `{{ isset($coupon) ? old('end_time', date('Y-m-d', strtotime($coupon->end_time))) : date('Y-m-d') }}`,
                minSale: `{{ old('min_sales', $coupon->min_sales ?? '0') }}`,
                enabled: {{ old('status', isset($coupon) && $coupon->status == 'active' ? 'true' : 'false') }}
            }"
                action="{{ isset($coupon) ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store') }}"
                method="POST" enctype="multipart/form-data" class="p-4">
                @csrf
                @if (isset($coupon))
                    @method('PUT')
                @endif

                <div class="col-lg-12">
                    <div class="row">
                        <!-- Form Section -->
                        <div class="col-lg-7 flex flex-wrap justify-between">
                            <div class="mb-2 w-5/12 me-3">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-dark">Coupon Code</label>
                                <input type="text" name="code" x-model="code" placeholder="Enter coupon code"
                                    autocomplete="off" class="form-control"
                                    value="{{ old('code', $coupon->code ?? '') }}" />
                                @error('code')
                                    <span class="fw-bold text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-2 w-5/12 me-3">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-dark">Coupon Value</label>
                                <input type="text" autocomplete="off" x-model="value" placeholder="Enter value"
                                    name="value" class="form-control"
                                    value="{{ old('value', $coupon->color_name ?? '0') }}" />
                                @error('value')
                                    <span class="fw-bold text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-2 w-5/12 me-3">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-dark">Value Type</label>
                                <select name="value_type" x-model="valueType"
                                    class="w-full mt-1 border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 form-control"
                                    required>
                                    <option value="percentage">Percentage</option>
                                    <option value="amount">Amount</option>
                                </select>
                                @error('value_type')
                                    <span class="fw-bold text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2 w-5/12 me-3">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-dark">Max Coupon
                                    Count</label>
                                <input type="text" autocomplete="off" name="max_count" x-model="maxCount"
                                    placeholder="Max usage count" class="form-control"
                                    value="{{ old('max_count', $coupon->color_name ?? '') }}" />
                                @error('max_count')
                                    <span class="fw-bold text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-2 w-5/12 me-3">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-dark">Start Date</label>
                                <input type="date" autocomplete="off" name="start_time" x-model="startDate"
                                    class="form-control" value="{{ old('start_time', $coupon->start_time ?? '') }}" />
                                @error('start_time')
                                    <span class="fw-bold text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-2 w-5/12 me-3">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-dark">End Date</label>
                                <input type="date" autocomplete="off" name="end_time" x-model="endDate"
                                    class="form-control" value="{{ old('end_time', $coupon->end_time ?? '') }}" />
                                @error('end_time')
                                    <span class="fw-bold text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-2 w-5/12 me-3">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-dark">Minimum Sale
                                    Amount</label>
                                <input type="text" autocomplete="off"name="min_sales" x-model="minSale"
                                    class="form-control" value="{{ old('min_sales', $coupon->color_name ?? '') }}" />
                                @error('min_sales')
                                    <span class="fw-bold text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-2 w-full me-3">
                                <label class="block mb-2 text-sm font-medium text-black dark:text-dark">Status</label>
                                <div class="form-group mb-3 col-md-4">
                                    <label class="form-check form-switch">
                                        <input class="form-check-input" name="status" x-model="enabled" type="checkbox"
                                            value="active" id="status"
                                            {{ old('status', isset($coupon) && ($coupon->status == 'active' ? 'checked' : '')) }}>

                                        <span class="form-check-label">Active</span>
                                    </label>
                                </div>

                            </div>



                        </div>
                        <div class="col-lg-5">
                            <!-- Preview Section -->
                            <div class="bg-gray-100 rounded-lg p-4 coupon">
                                <div class="container mt-3">
                                    <h2 class="mt-2 fs-3 text-theme fw-bold text-center mb-3"
                                        x-text="valueType === 'amount' ? ('₹' + value + ' Off') : (value + '% Off') || '---'">
                                    </h2>
                                </div>
                                <div class="container">
                                    <h6 class="mb-3 fw-bold">Use Promo Code:
                                        <span class=" coupon_code_image py-4"><span x-text="code || '---'"></span></span>
                                    </h6>
                                    <p class="text-sm flex gap-2 mb-3"><span class="fw-bold">Max Count:</span> <span
                                            x-text="maxCount || 'Unlimited'"></span></p>
                                    <p class="text-sm flex gap-2 mb-3"><span class="fw-bold">Minimum Sale:</span>₹ <span
                                            x-text="minSale || 'None'"></span></p>
                                    <p class="text-sm flex gap-2 mb-3"><span class="fw-bold">Start Date:</span> <span
                                            x-text="startDate || 'Not Set'"></span></p>
                                    <p class="text-sm text-danger flex gap-2 mb-3"><span class="fw-bold">End Date:</span>
                                        <span x-text="endDate || 'Not Set'"></span>
                                    </p>
                                    <p class="text-sm flex gap-2 mb-3"><span class="fw-bold">Status:</span> <span
                                            class="fw-bold" x-text="enabled == true ? 'Active' : 'In Active'"></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit"
                                class="rounded bg-primary px-6 py-2 text-white transition hover:bg-primary-dark">
                                {{ isset($coupon) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
