@extends('frontend.layouts.master')
@section('title','Cart Page')

@section('main-content')


{{-- Breadcrumbs --}}

<div class="breadcrumbs">
    <div  class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{('home')}}">Home <i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="">Cart</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Breadcrumbs --}}


{{-- Shopping cart --}}

<div class="shopping-cart section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                {{-- Shopping Summary --}}
                <table class="table shopping-summary">
                    <thead>
                        <tr class="main-hading">
                            <th>PRODUCT</th>
                            <th>NAME</th>
                            <th class="text-center">UNIT PRICE</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center">TOTAL</th>
                            <th class="text-center"><i class="ti-trash remove-icon"></i></th>

                        </tr>
                    </thead>

                    <tbody id="cart_item_list">
                        <form action="{{route('cart.update')}}" method="post">
                        @csrf

                        @if (Helper::getAllProductFromCart())
                        @foreach (Helper::getAllProductFromCart() as $key=>$cart)
                        <tr>
                            @php
                                $photo = explode(',',$cart->product['photo']);
                            @endphp
                            <td class="image" data-title="No"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></td>
                            <td class="product-des" data-title="Description">
                                <p class="product-name"><a href="{{route('product-detail',$cart->product['slug'])}}" target="_blank">{{$cart->product['title']}}</a></p>
                                <p class="product-des">{!! ($cart['summary']) !!}</p>

                            </td>
                            <td class="price" data-title="Price"><span>${{number_formart($cart['price'],2)}}</span></td>
                            <td class="qty" data-title="Qty">
                                <div class="input-group">
                                <div class="button minus">
                                    <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[{{$key}}]">
                                    <i class="ti-minus"></i>
                                    </button>

                                </div>
                                <input type="text" name="quan[{{$key}}]" class="input-number" data-min="1" data-max="100" value="{{$cart->quantity}}">
                                <input type="hidden" name="qty_id[]" value="{{$cart->id}}">
                                <div class="button plus">
                                    <button type="button" class="btn btnprimary btn-number" data-type="plus" data-field="quant[{{$key}}]">
                                    <i class="ti-plus"></i>
                                    </button>
                                </div>
                                </div>
                                {{-- End Input Order --}}
                            </td>
                            <td class="total-amount cart_single_price" data-title="Total"><span class="money">${{$cart['amount']}}</span></td>

                            <td class="action" data-title="Remove"><a href="{{route('cart-delete',$cart->id)}}"><i class="ti-trash remove-icon"></i></a></td>

                        </tr>
                            
                        @endforeach
                            
                        <track>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="float-right">
                            <button type="submit" class="btn float-right">Update</button>

                        </td>
                        </track>

                        @else
                        <tr>
                            <td class="text-center">
                                There are no any carts available. <a href="{{route('product-grids')}}" style="color: blue;">Continue shopping</a>
                            </td>
                        </tr>
                        @endif
                        </form>
                    </tbody>
                </table>
                {{-- End Shopping Summary --}}
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                {{-- Total Amount --}}
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12">
                            <div class="left">
                                <div class="coupon">
                                    <form action="{{route('coupon-store')}}" method="post">
                                    @csrf
                                    <input name="code" placeholder="Enter Your Coupon">
                                    <button class="btn">Apply</button>
                                    </form>
                                </div>



                            </div>
                        </div>

                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <ul>
                                    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Cart Subtotal <span>${{number_format(Helper::totalCartPrice(),2)}}</span></li>

                                    @if (session()->has('coupon'))
                                    <li class="coupon_price" data-price="{{Session::get('coupon')['value']}}">You Save <span>${{number_format(Session::get('coupon')['value'],2)}}</span></li>

                                        
                                    @endif

                                    @php
                                        $total_amount = Helper::totalCartPrice();
                                        if (session()->has('coupon')) {
                                            $total_amount = $total_amount-Session::get('coupon')['value'];

                                        }
                                    @endphp

                                    @if (session()->has('coupon'))
                                    <li class="last" id="order_total_price">You Pay <span>${{number_format($total_amount,2)}}</span></li>

                                    @else
                                    <li class="last" id="order_total_price">You Pay <span>${{number_format($total_amount,2)}}</span></li>


                                        
                                    @endif
                                </ul>

                                <div class="button5">
                                    <a href="{{route('checkout')}}" class="btn">Checkout</a>
                                    <a href="{{route('product-grids')}}" class="btn">Continue shopping</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Total Amount --}}
            </div>
        </div>
    </div>
</div>
{{-- End Shopping Cart --}}



{{-- Start Shop Services Area --}}


<section class="shop-services section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
               {{-- Start Single Service --}}
             <div class="single-service">
                <i class="ti-rocket"></i>
                <h4>Free shipping</h4>
                <p>Orders over $1000</p>
             </div>
             {{-- End Single Service --}}
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                {{-- Start Single Service --}}

                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Free Return</h4>
                    <p>Within 30 days returns</p>
                </div>
                {{-- End Single Service --}}
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                {{-- Start Single Service --}}
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Sucure Payment</h4>
                    <p>100% secure payment</p>
                </div>
                {{-- End Single Service --}}
            </div>

            <div class="col-lg-3 col-md-6 col-12">
                {{-- Start Single Service --}}

                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Best Price</h4>
                    <p>Guarandteed price</p>
                </div>
                {{-- End Single Service --}}
            </div>
        </div>
    </div>
</section>

{{-- End Shop Newsletter --}}


{{-- Start Shop Newsletter --}}

@include('frontend.layouts.newsletter')
{{-- End Shop Newslatter --}}

@endsection