@extends('admin.layouts.master')

@section('content')
    <div>
        <!-- ===== Data Stats Start ===== -->
        <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-title-sm2 font-bold text-black dark:text-white">
                    This Website Overview
                </h2>
            </div>


        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
            <div
                class="rounded-sm border border-stroke bg-white p-4 shadow-default dark:border-strokedark dark:bg-boxdark md:p-6 xl:p-7.5">
                <div class="flex items-end justify-between">
                    <div>
                        <h3 class="mb-4 text-title-lg font-bold text-black dark:text-white">
                            {{ number_format($totalOrders) ?? 0 }}
                        </h3>
                        <p class="font-medium">Total Orders</p>

                    </div>
                </div>
            </div>

            <div
                class="rounded-sm border border-stroke bg-white p-4 shadow-default dark:border-strokedark dark:bg-boxdark md:p-6 xl:p-7.5">
                <div class="flex items-end justify-between">
                    <div>
                        <h3 class="mb-4 text-title-lg font-bold text-black dark:text-white">
                            {{ number_format($totalProducts) ?? 0 }}
                        </h3>
                        <p class="font-medium">Total Products</p>

                    </div>

                </div>
            </div>

            <div
                class="rounded-sm border border-stroke bg-white p-4 shadow-default dark:border-strokedark dark:bg-boxdark md:p-6 xl:p-7.5">
                <div class="flex items-end justify-between">
                    <div>
                        <h3 class="mb-4 text-title-lg font-bold text-black dark:text-white">
                            {{ number_format($activeCoupons) ?? 0 }}
                        </h3>
                        <p class="font-medium">Active Coupons</p>
                    </div>

                </div>
            </div>

            <div
                class="rounded-sm border border-stroke bg-white p-4 shadow-default dark:border-strokedark dark:bg-boxdark md:p-6 xl:p-7.5">
                <div class="flex items-end justify-between">
                    <div>
                        <h3 class="mb-4 text-title-lg font-bold text-black dark:text-white">
                            {{ number_format($totalAccounts) ?? 0 }}
                        </h3>
                        <p class="font-medium">Total Accounts</p>

                    </div>

                </div>
            </div>
        </div>
        <!-- ===== Data Stats End ===== -->

        <div class="mt-7.5">
            <div class=" grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">
                <div class="col-span-12 xl:col-span-7">
                    <div class="grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">
                        <!-- ===== Chart Seven Start ===== -->
                        <div class="col-span-12 xl:col-span-12">
                            <div
                                class="col-span-12 rounded-sm border border-stroke bg-white px-5 pb-2 pt-7.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-8">
                                <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                                    <div>
                                        <h4 class="text-title-sm2 font-bold text-black dark:text-white">
                                            Visitor Analystics
                                        </h4>
                                    </div>

                                </div>
                                <div>
                                    <div id="VisitorAnalystics" class="-ml-5"></div>
                                </div>

                                <div class="flex flex-col text-center xsm:flex-row">
                                    <div class="border-stroke py-2 dark:border-strokedark xsm:w-1/2 xsm:border-r">
                                        <p class="font-medium">Total Orders</p>
                                        <h4 class="mt-1 text-title-sm font-bold text-black dark:text-white">
                                            {{ number_format($totalOrders) }}
                                        </h4>
                                    </div>
                                    <div class="py-2 xsm:w-1/2">
                                        <p class="font-medium">Total Visitors</p>
                                        <h4 class="mt-1 text-title-sm font-bold text-black dark:text-white">
                                            {{ number_format($totalViews ?? 0) }}
                                        </h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- ===== Chart Seven End ===== -->

                        <!-- ===== Chart Eight Start ===== -->
                        <div class="col-span-12 xl:col-span-12">
                            <div
                                class="col-span-12 rounded-sm border border-stroke bg-white px-5 pb-5 pt-7.5 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:col-span-5">
                                <div class="mb-3 justify-between gap-4 sm:flex">
                                    <div>
                                        <h4 class="text-xl font-bold text-black dark:text-white">
                                            Used Devices
                                        </h4>
                                    </div>

                                </div>
                                <div class="mb-2">
                                    <div id="chartTopDevices" class="mx-auto flex justify-center"></div>
                                </div>
                                <div class="-mx-8 flex flex-wrap items-center justify-center gap-y-3">
                                    @foreach ($topDevices ?? [] as $device)
                                        <div class="w-full px-8 sm:w-1/2">
                                            <div class="flex w-full items-center">
                                                <span class="mr-2 block h-3 w-full max-w-3 rounded-full bg-primary"></span>
                                                <p
                                                    class="flex w-full justify-between text-sm font-medium text-black dark:text-white">
                                                    <span class="text-capitalize"> {{ $device->device_category }} </span>
                                                    <span> {{ number_format($device->user_count) }} </span>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>

                        </div>
                        <!-- ===== Chart Eight End ===== -->

                        <div class="col-span-12 xl:col-span-6">
                            <!-- ====== Top Content Start -->
                            <div
                                class="mb-4 rounded-sm border border-stroke bg-white p-4 shadow-default dark:border-strokedark dark:bg-boxdark md:mb-6 md:p-6 xl:p-7.5 2xl:mb-7.5">
                                <div class="mb-7 flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-black dark:text-white">
                                            Top Pages
                                        </h3>
                                    </div>

                                </div>

                                <div class="flex flex-col gap-2">
                                    <div class="grid grid-cols-12 py-2">
                                        <div class="col-span-6">
                                            <p class="text-sm font-medium">Title</p>
                                        </div>
                                        <div class="col-span-4">
                                            <p class="text-left text-sm font-medium">Url</p>
                                        </div>
                                        <div class="col-span-2">
                                            <p class="text-right text-sm font-medium">Views</p>
                                        </div>
                                    </div>
                                    @foreach ($topLandingPages ?? [] as $ladingPageItem)
                                        <div class="relative z-1 grid grid-cols-12 py-2">
                                            <div class="col-span-6 ">
                                                <a href="{{ url($ladingPageItem->page_url) }}" target="_blank"
                                                    class="text-sm font-medium"
                                                    title="{{ $ladingPageItem->page_title }}">{{ Str::limit($ladingPageItem->page_title, '30', '...') }}</a>
                                            </div>
                                            <div class="col-span-4">
                                                <a href="{{ url($ladingPageItem->page_url) }}" target="_blank"
                                                    class="text-center text-sm font-medium"
                                                    title="{{ $ladingPageItem->page_url }}">{{ Str::limit($ladingPageItem->page_url, '20', '...') }}</a>
                                            </div>
                                            <div class="col-span-2">
                                                <p class="text-right text-sm font-medium">
                                                    {{ number_format($ladingPageItem->view_count) }}</p>
                                            </div>
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                            <!-- ====== Top Content End -->
                        </div>
                        <div class="col-span-12 xl:col-span-6">
                            <!-- ====== Top Channels Start -->
                            <div
                                class="rounded-sm border border-stroke bg-white p-4 shadow-default dark:border-strokedark dark:bg-boxdark md:p-6 xl:p-7.5">
                                <div class="mb-7 flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold text-black dark:text-white">
                                            Top Sources
                                        </h3>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <div class="grid grid-cols-12 py-2">
                                        <div class="col-span-6">
                                            <p class="text-sm text-capitalize fw-bold">Source</p>
                                        </div>
                                        <div class="col-span-4">
                                            <p class="text-right text-sm font-medium">Views</p>
                                        </div>
                                    </div>
                                    @foreach ($topReferrers ?? [] as $topRef)
                                        <div class="relative z-1 grid grid-cols-12 py-2">
                                            <div class="col-span-6">
                                                <p class="text-sm  text-capitalize fw-bold">{{ $topRef->referrer_url }}</p>
                                            </div>
                                            <div class="col-span-4">
                                                <p class="text-right text-sm font-medium">{{ $topRef->user_count }}</p>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <!-- ====== Top Channels End -->
                        </div>
                    </div>

                </div>
                <div class="col-span-12 xl:col-span-5">
                    <!-- ====== Limited and out of stock Start -->
                    <div
                        class="rounded-sm border border-stroke bg-white p-4 shadow-default dark:border-strokedark dark:bg-boxdark md:p-6 xl:p-7.5">
                        <div class="mb-7 flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-black dark:text-white">
                                    <small>  Limited and Out of Stock Products <span class="text-danger">Stock Below 10<small></small>
                                </h3>
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="grid grid-cols-12 py-2">
                                <div class="col-span-6">
                                    <p class="text-sm text-capitalize fw-bold text-info">Product</p>
                                </div>
                                <div class="col-span-4">
                                    <p class="text-right text-sm font-medium  text-danger">Stock</p>
                                </div>
                            </div>
                            <hr>
                            @foreach ($stockProducts ?? [] as $product)
                                <div class="relative z-1 grid grid-cols-12 py-2">
                                    <div class="col-span-6">
                                        <p class="text-sm  text-capitalize fw-bold">
                                            {{ $product->v_name }}<br>
                                        </p>
                                        <small x-data="{ copied: false }">
                                            Product Id : 
                                            <span class="text-primary">{{ $product->product->unique_value }}</span> 
                                            <span role="button" class="copy" 
                                                  @click="navigator.clipboard.writeText('{{ $product->product->unique_value }}'); copied = true; setTimeout(() => copied = false, 2000)">
                                                <i class="bi bi-copy"></i>
                                            </span>
                                            <span x-show="copied" class="text-success" x-transition> Copied! </span>
                                        </small>
                                        
                                       
                                    </div>
                                    <div class="col-span-4">
                                        <p class="text-right text-sm font-medium">{{ $product->in_stock }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <!-- ====== Limited and out of stock  End -->
                </div>
            </div>


        </div>
    </div>
@endsection

@push('footer')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        function chartTopDevices() {
            // Prepare the data from the database
            const topDevicesData = @json($topDevices); // This will pass the data to JavaScript

            // Extract series and labels
            const series = topDevicesData.map(device => device
                .user_count); // Assuming 'user_count' is the field in your table
            const labels = topDevicesData.map(device => device
                .device_category); // Assuming 'device_category' is the field in your table

            const chartTopDevicesOptions = {
                series: series, // Dynamically set series from the database
                chart: {
                    type: "donut",
                    width: 380
                },
                colors: ["#3C50E0", "#6577F3", "#8FD0EF", "#0FADCF"], // Customize colors if needed
                labels: labels, // Dynamically set labels from the database
                legend: {
                    show: false,
                    position: "bottom"
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "65%",
                            background: "transparent"
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                responsive: [{
                    breakpoint: 640,
                    options: {
                        chart: {
                            width: 200
                        }
                    }
                }]
            };

            // Select chart element by ID and render the chart
            const chartSelector = document.querySelectorAll("#chartTopDevices");
            if (chartSelector.length) {
                const chartTopDevices = new ApexCharts(document.querySelector("#chartTopDevices"), chartTopDevicesOptions);
                chartTopDevices.render();
            }
        }

        // Call chartTopDevices function
        chartTopDevices();

        function VisitorAnalystics() {
            const visitorsData = @json($last30DaysVisitors);

            // Map the visitor data to extract total users and dates
            const visitorCountData = visitorsData.map(visitor => parseInt(visitor.total_users)); // Ensure it's a number
            const categories = visitorsData.map(visitor => visitor.date); // Ensure it's a string (date)


            // Chart configuration options
            const chartOptions = {
                series: [{
                    name: "Visitors", // Name for the series
                    data: visitorCountData // Data for the series
                }],
                chart: {
                    type: "line", // Line chart type
                    height: 350, // Chart height
                    toolbar: {
                        show: false // Hide the toolbar
                    }
                },
                xaxis: {
                    categories: categories, // X-axis categories (dates)
                    title: {
                        text: 'Date' // X-axis label
                    },
                    tickPlacement: 'on' // Place ticks on the axis
                },
                yaxis: {
                    title: {
                        text: 'Total Visitors' // Y-axis label
                    }
                },
                tooltip: {
                    enabled: true, // Enable tooltip
                    x: {
                        format: 'dd MMM yyyy' // Format date in tooltip (optional)
                    },
                    y: {
                        formatter: function(value) {
                            return value + " Visitors"; // Format the y-axis value in tooltip
                        }
                    }
                }
            };

            // Create the chart
            const chart = new ApexCharts(document.querySelector("#VisitorAnalystics"), chartOptions);

            // Render the chart
            chart.render();
        }

        // Call the function to render the chart
        VisitorAnalystics();
    </script>
@endpush
