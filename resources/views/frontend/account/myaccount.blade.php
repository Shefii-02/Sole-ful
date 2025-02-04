
@extends('layouts.app')

@section('content')
<style>
    section.my-account-page .col-lg-10 .col-lg-4{
        width: 32.3333%;
    }
    @media(max-width: 1025px){
        section.my-account-page .col-lg-10 .col-lg-4 .card{
        padding: 10px 0 !important;
        }
    }
    @media(max-width: 992px){
        section.my-account-page .col-lg-10 .col-lg-4{
            width: 49%;
        }
    }
    @media(max-width: 600px){
         section.my-account-page .col-lg-10 .col-lg-4{
            width: 100%;
        }
    }
</style>
      
    <section class="product-listing-banner pt-5">
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area bg-img" data-bg="/assets/img/breadcrumb-banner.webp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h1 class="breadcrumb-title">My Account</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Account</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
    </section>
    
    <section class="page_section my-account-page">
        <div class="container">
            <div class="row justify-content-center w-100 m-0">
              <div class="col-md-12 col-lg-10 ">
                  
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-lg-4 shadow mb-3">
                            <a href="{{route('account.orders.show')}}" class="text-decoration-none">
                                <div class="card border-0 p-3 bg-body rounded">
                                    <div class="card-body">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                
                                                <img src="{{url('assets/img/icon/orders.png')}}" class="img-fluid p-2">
                                            </div>
                                            <div class="col-9">
                                                <h6>My Orders</h6>
                                                <small>View and track your orders</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6 col-lg-4 shadow mb-3">
                            <a href="{{route('account.profile.show')}}" class="text-decoration-none">
                                <div class="card border-0 p-3 bg-body rounded">
                                    <div class="card-body">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                <img src="{{url('assets/img/icon/security.png')}}" class="img-fluid p-2">
                                            </div>
                                            <div class="col-9">
                                                <h6>Profile & security</h6>
                                                <small>Edit login, name, and mobile number</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6 col-lg-4 shadow mb-3">
                            <a href="{{route('account.address.show')}}" class="text-decoration-none">
                                <div class="card border-0 p-3 bg-body rounded">
                                    <div class="card-body">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                <img src="{{url('assets/img/icon/addresss.png')}}" style="width: 48px !important;" class="img-fluid">
                                            </div>
                                            <div class="col-9">
                                                <h6>Addresses</h6>
                                                <small>Edit addresses for orders</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        
                        <div class="col-md-6 col-lg-4 shadow mb-3">
                            
                            <a href="{{route('account.support-center')}}" class="text-decoration-none">
                                <div class="card border-0 p-3 bg-body rounded">
                                    <div class="card-body">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                <img src="{{url('assets/img/icon/technical-support.png')}}" class="img-fluid p-1">
                                            </div>
                                            <div class="col-9">
                                                <h6>Support Center</h6>
                                                <small>Dedicated online support</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection