
@extends('layouts.app')
@section('content')
      
    <section class="product-listing-banner">
        <!-- breadcrumb area start -->
        <div class="breadcrumb-area bg-img" data-bg="assets/img/breadcrumb-banner.webp">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb-wrap text-center">
                            <nav aria-label="breadcrumb">
                                <h1 class="breadcrumb-title">My Orders</h1>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('account.home') }}">My Account</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb area end -->
    </section>
    
    <section class="page_section">
        <div class="container">
           
            <div class="row justify-content-center">
                <div class="col-md-10 ">
                               
                  
        
                    
                    @if($orders->count() > 0 )
                    
                        @foreach($orders as $item)
                        <div class="card mb-3">

                            <div class="card-header" data-bs-toggle="collapse" data-bs-target="#{{$item->id}}" aria-expanded="false" aria-controls="{{$item->id}}" role="button">
                                <ul class="nav_booter list-unstyled  pe-md-5 m-0 d-flex justify-content-between flex-wrap">
                                    <li class="d-flex flex-column">
                                        <small>Order Placed</small>
                                        <small class="fw-bolder">{{dateFormat($item->created_at)}}</small>
                                    </li>
                                    
                                    <li>
                                        <small class="fw-bolder">Total :{{getPrice($item->grandtotal)}}</small>
                                    </li>
                                    <li>
                                        @if($add_billing = $item->address->where('type','billing')->first())
                                            <small class="hover-container">Billing To <i class="fa fa-angle-down"></i>
                                              
                                                <div class="hidden-div  fw-bolder mb-5 p-3 rounded shadow-lg">
                                                    <div class="d-flex flex-column">
                                                        <small>{{$add_billing->name}}</small>
                                                        <small>{{$add_billing->address}}</small>
                                                        <small>{{$add_billing->city.','.$add_billing->postalcode}}</small>
                                                        <small>{{$add_billing->province.','.$add_billing->country}}</small>
                                                    </div>
                                                </div>
                                            </small>
                                        @endif
                                          
                                    </li>
                                    @if($item->order_type == 'delivery')
                                    <li>
                                        @if($add_delivery = $item->address->where('type','delivery')->first())
                                            <small class="hover-container">Ship/Pickup To <i class="fa fa-angle-down"></i>
                                              
                                            <div class="hidden-div  fw-bolder mb-5 p-3 rounded shadow-lg">
                                                <div class="d-flex flex-column">
                                                    <small>{{$add_delivery->firstname .' '. $add_delivery->lastname}}</small>
                                                    <small>{{$add_delivery->address}}</small>
                                                    <small>{{$add_delivery->city.','.$add_delivery->postalcode}}</small>
                                                    <small>{{$add_delivery->province.','.$add_delivery->country}}</small>
                                                </div>
                                            </div>
                                            </small>
                                        @endif
                                    </li>
                                    @endif
                                    
                                    <li class="d-flex flex-column">
                                        <small class="fw-bolder">Order No:#{{$item->invoice_id}}</small>
                                        <!--<small class="float-end cursor-pointer">Invoice <i class="fa fa-download"></i></small>-->
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body collapse" id="{{$item->id}}">
                                
                                <div class="row g-0">
                                    <div class="col-md-8 card-body pe-3">
                                        <div class=""  >
                                            @foreach($item->basket->items as  $listing_item)
                        
                                                <div class="col-md-12">
                                                    <div class="row g-0">
                                                        <div class="col-md-2">
                                                          <img onerror="this.onerror=null;this.src='/assets/images/dummy-product.jpg';" src="{{asset('images/products/'.$listing_item->picture)}}"  class="img-fluid rounded " alt="...">
                                                        </div>
                                                        <div class="col-md-10">
                                                          <div class="card-body">
                                                            <h5 class="card-title">{{$listing_item->product_name}}</h5>
                                                            @if($listing_item->bundle_product == '1')
                                                            <table>
                                                                @foreach($listing_item->bundle_items as $itm)
                                                                <tr>
                                                                    <td class="p-0">
                                                                         <div class="fw-normal p-0 border-1 border border-gray  smaller mb-1 rounded-1"><i class="bi bi-check text-success"></i>{{ $itm->product_name }}</div>
                                                                        </td>
                                                                </tr>
                                                                @endforeach
                                                            </table>
                                                                
                                                            @endif
                                                            <p class="card-text">{{$listing_item->variation}}</p>
                                                            <p class="card-text">{{getPrice($listing_item->price_amount * $listing_item->quantity)}}</p>
                                                            
                                                          </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <hr>
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4 order-page-s">
                                        <h5 class="mb-3">Order Summary</h5>
                                        <div id="od-subtotals" class="col-12 a-fixed-right-grid-col a-col-right">
                                            <div class="row fw-bolder">
                                                <div class="col-7 mb-3">
                                                    <p class="mb-0">Item(s) Subtotal:</p>
                                                </div> 
                                                <div class="col-5 text-end mb-3">
                                                    <span class="text-end">
                                                        {{getPrice($item->subtotal)}}
                                                    </span> 
                                                </div>
                                                <div class="col-7 mb-3">
                                                    <p class="mb-0">
                                                        Shipping:
                                                    </p> 
                                                </div> 
                                                <div class="col-5 text-end mb-3">
                                                    <span  class="text-end">
                                                        {{getPrice($item->shipping_charge)}}
                                                    </span> 
                                                </div> 
                                               
                                                <div class="col-7 mb-3">
                                                    <p class="mb-0">
                                                        Discount:
                                                    </p> 
                                                </div> 
                                                <div class="col-5 text-end mb-3">
                                                    <span class="text-end">
                                                        {{getPrice($item->discount)}}
                                                    </span>
                                                </div>
                                                <div class="col-12 order-page-ss" >
                                                    <div class="row">
                                                        <hr>
                                                <div class="col-7">
                                                    <p class="mb-0">
                                                        Grand Total:
                                                    </p> 
                                                </div> 
                                                <div class="col-5 text-end">
                                                    <span class="text-end">
                                                        {{getPrice($item->grandtotal)}}
                                                    </span>
                                                </div> 
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        @endforeach
                    @else
                            <div class="mt-5 d-flex justify-content-center align-items-center">
                                <div class="col-md-6">
                                    <div class="border border-3 border-dark"></div>
                                    <div class="card  bg-white shadow p-5">
                                        <div class="mb-4 mx-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
                                              <circle cx="60" cy="60" r="52" fill="#F5F6F8" stroke="#E2E4E8" stroke-width="4" />
                                              <path d="M32 40L88 40" stroke="#A0AEC0" stroke-width="8" stroke-linecap="round" />
                                              <path d="M32 60L88 60" stroke="#A0AEC0" stroke-width="8" stroke-linecap="round" />
                                              <path d="M32 80L88 80" stroke="#A0AEC0" stroke-width="8" stroke-linecap="round" />
                                              <circle cx="60" cy="60" r="10" fill="#A0AEC0" />
                                            </svg>


                                        </div>
                                        <div class="text-center">
                                            <h1 class="fs-2 fw-bold">No Orders Found !</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection    


@section('scripts')
<script>
$(document).ready(function() {
  $('.hover-container').mousemove(function(e) {
    const x = e.pageX - $(this).offset().left;
    const y = e.pageY - $(this).offset().top;

    $(this).find('.hidden-div').css({
      display: 'block',
    });
  });

  $('.hover-container').mouseleave(function() {
    $(this).find('.hidden-div').css('display', 'none');
  });
   $('#yearSelect').change(function() {
        $('#filter_order').submit();
    });
});

</script>
@endsection
                 