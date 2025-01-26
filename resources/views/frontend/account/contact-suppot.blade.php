@extends('layouts.app')
@section('styles')
@endsection
@section('content')
    <section class="product-listing-banner">
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area bg-img" data-bg="assets/img/breadcrumb-banner.webp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h1 class="breadcrumb-title">Support Center</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('account.home') }}">My Account</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Support Center</li>
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



                    <div class="col-md-12">
                        <div class="row justify-center">

                            <div class="col-md-6 col-lg-4">

                                <div class="card border-0 shadow-lg p-3 mb-5 bg-body rounded">
                                    <div class="card-body text-center">
                                        <div class="row g-0">
                                            <div class="col-12">
                                                <img src="{{ url('/assets/img/icon/storefront.png') }}"
                                                    class="mx-auto mb-3 p-2">
                                            </div>
                                            <div class="col-12">
                                                <h6 class="mb-2 fw-bold"> Soleful Ahdia </h6>
                                                <small>#5 1 FLOOR GEDDALAHALLI,HENNUR<br>
                                                    BAGLUR MAIN ROAD KOTHALUR POST BLR.560077</small>
                                                <div class="d-flex gap-3 justify-center mt-3">
                                        
                                                        <a class="mb-1 store_button" href="tel:+917996666225"><i
                                                                class="bi bi-telephone"></i> Call</a>
                                                        <a class="mb-1 store_button"
                                                            href="mailto:solefulfootwears@gmail.com"><i
                                                                class="bi bi-envelope "></i> Inquiry</a>
                                                
                                            
                                                        <a class="mb-1 store_button" target="map_new"
                                                            href="https://maps.app.goo.gl/MtY4isgHncwS6jfB8"><i
                                                                class="bi bi-geo"></i>
                                                            Directions</a>
                                                    
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
    </section>
@endsection


@section('scripts')
    <script></script>
@endsection
