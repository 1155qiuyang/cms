@extends('frontend.layouts.master')

@section('title','E-SHOP || Order Track Page')

@section('main-content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home <i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javasript:void(0);">Order Track</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- End Breadcrumbs-->

    <section class="tracking_box-area section_gap py5">
        <div class="container">
            <div class="tracking_box_inner">
                <p>To track </p>
                <form class="row tracking_form my-4" action="{{route('product.tack.order')}}" method="POST" novalidate="novalidate">
                @csrf
                  <div class="col-md-8 form-group">
                    <input type="text" class="form-contol p-2" name="order_number" placeholder="Enter your order number">

                  </div>
                  <div class="col-md-8 form-gruop">
                    <button type="submit" value="submit" class="btn submit_btn">Track Order</button>
                  </div>
                </form>
            </div>
        </div>
    </section>
@endsection
