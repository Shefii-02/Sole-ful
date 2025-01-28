@extends('layouts.app')

@section('content')
    <!-- breadcrumb area start -->
    <div class="breadcrumb-area bg-img" data-bg="assets/img/banner/breadcrumb-banner.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-wrap text-center">
                        <nav aria-label="breadcrumb">
                            <h1 class="breadcrumb-title">Contact Us</h1>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area end -->

    <!-- contact wrapper area start -->
    <div class="contact-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contact-message">
                        <h2 class="contact-title">Contact Us</h2>
                        <form id="contact-form" action="{{ route('public.contact-send') }}" method="post"
                            class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input name="first_name" placeholder="Name *" type="text" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input name="phone" placeholder="Phone *" type="text" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input name="email_address" placeholder="Email *" type="text" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <input name="contact_subject" placeholder="Subject *" type="text">
                                </div>
                                <div class="col-12">
                                    <div class="contact2-textarea text-center">
                                        <textarea placeholder="Message *" name="message" class="form-control2" required=""></textarea>
                                    </div>
                                    <div class="contact-btn">
                                        <button class="btn btn-theme" type="submit">Send Message</button>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <p class="form-messege"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-info pt-0">
                       
                        
                        <ul>
                            <li><i class="fa fa-fax"></i> Address :
                                <a  href="https://maps.app.goo.gl/MtY4isgHncwS6jfB8" target="_blank">
                                SOLEFUL<br>
                                #5, 1st floor, Geddalahalli,<br>
                                Hennur Bagalur Main Road,<br>
                                Bangalore - 560077.
                                </a></li>
                            <li><i class="fa fa-phone"></i> <a href="mailto:relationship@soleful.in" target="_blank">relationship@soleful.in</a></li>
                            <li><i class="fa fa-envelope-o"></i> <a href="tel:+917996666225" target="_blank">+91 79966 66225</a></li>
                        </ul>
                        <div class="working-time">
                            <h3>Working Hours</h3>
                            <p class="pb-0"><span>Monday – Saturday:</span>08:00 AM – 09:30 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact wrapper area end -->
@endsection
