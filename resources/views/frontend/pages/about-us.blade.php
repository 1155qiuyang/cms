@extends('frontend.layouts.master')

@section('main-content')

<!-- Breadcrumbs -->

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="index1.html">Home <i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="blog-single.html"> About Us</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Breadcrumbs -->


<!-- About Us -->

<section class="about-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="about-content">
                    @php
                        $settings=DB::table('settings')->get();
                    @endphp
                    <h3>Welcome To <span>Eshop</span></h3>
                    <p>@foreach ($settings as $data){{$data->description}}
                        
                    @endforeach</p>
                    <div class="button">
                        <a href="{{route('blog')}}" class="btn">Our Blog</a>
                        <a href="{{route('contact')}}" class="btn primary"> Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="about-img overlay">
                    <img src="@foreach ($settings as $data) {{$data->photo}}
                        
                    @endforeach" alt="@foreach ($settings as $data ) {{$data->photo}}
                        
                    @endforeach">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- End About Us -->

<!-- Start Shop Service Area -->
<section class="shop-service section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Signle Service -->

                <div class="single-service">
                    <i class="ti-rocket">
                        <h4>Free shipping</h4>
                        <p>Orders over $100</p>
                    </i>
                </div>
                <!-- End Single Service -->

            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-servie">
                    <i class="ti-reload"></i>
                    <h4>Free Return</h4>
                    <p>Within 20days returns</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Secure Payment</h4>
                    <p>100% secure payment</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-service">
                    <i class="ti-tag"></i>
                        <h4>Best Peice</h4>
                        <p>Guarantedd price</p>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@include('frontend.layouts.newsletter')
@endsection



