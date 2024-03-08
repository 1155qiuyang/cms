@extends('frontend.layouts.master')

@section('meta')

<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
	<meta name="description" content="{{$product_detail->summary}}">
	<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
	<meta property="og:type" content="article">
	<meta property="og:title" content="{{$product_detail->title}}">
	<meta property="og:image" content="{{$product_detail->photo}}">
	<meta property="og:description" content="{{$product_detail->description}}">
    
@endsection
@section('title','E-SHOP || PRODUCT DETAIL')
@section('main-content')
    

{{-- Breadcrumbs --}}

<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home <i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="">Shop Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- End Breadcrumbs --}}



{{-- Shop Single --}}


<section class="shop single section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="product-gallery">
                        <ul class="slides">
                            @php
                                $photo = explode(',',$product_detail->photo);


                            @endphp
                            @foreach ($photo as $data)
                            <li data-thumb="{{$data}}" rel="adjustX:10,adjustY:">
                            <img src="{{$data}}" alt="{{$data}}">

                            </li>
                                
                            @endforeach
                        </ul>
                    </div>
                    {{-- End Image slider --}}
                </div>
                {{-- End Product slider --}}
            </div>
            <div class="col-ls-6 col-12">
                <div class="product-des">
                    {{-- Description --}}
                    <div class="short">
                        <h4>{{$product->title}}</h4>
                        <div class="rating-main">
                            <ul class="rating">
                                @php
                                    $rate = ceil($product_detail->getReview->avg('rate'))
                                @endphp

                                @for ($i=1;$i<=5;$i++)
                                    @if ($rate>=$i)
                                    <li><i class="fa fa-star"></i></li>
                                        @else
                                        <li><i class="fa fa-star-o"></i></li>
                                    @endif
                                
                                    
                                @endfor
                            </ul>
                            <a href="" class="total-review">({{$product_detail['getReview']->count()}}) Review</a>

                        </div>
                        @php
                            $after_discount = ($prouct_detail->price-(($product_detail->price*$product_detail->discount)/100));

                        @endphp
                        <p> class="price"><span class="diccount">${{number_format($after_discount,2)}}</span><s>${{number_format($product_detail->price,2)}}</s></p>
                        <p class="description">{!! ($product_detail->summary) !!}</p>

                    </div>




                    @if ($product_detail->size)
                    <div class="size mt-4">
                        <h4>Size</h4>
                        <ul>
                            @php
                                $sizes=explode(',',$product_detail->size);
                            @endphp
                            @foreach ($sizes as $size)
                            <li><a href="#" class="one">{{$size}}</a></li>

                                
                            @endforeach
                        </ul>
                    </div>
                        
                    @endif
                    {{-- End Size --}}
                    {{-- Product Buy --}}
                    <div class="product-buy">
                        <form action="{{route('single-add-to-cart')}}" method="post">
                        @csrf
                        <div class="quantity">
                            <h6>Quantity:</h6>
                            {{-- Input Order --}}
                            <div class="input-group">
                                <div class="button minus">
                                    <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                        <i class="ti-minus"></i>
                                    </button>
                                </div>
                            </div>
                            {{-- End Input Order --}}
                        </div>
                        <div class="add-to-cart mt-4">
                            <button type="submit" class="btn">Add to cart</button>
                            <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i class="ti-heart"></i></a>

                        </div>
                        </form>
                      <p class="cat">Category: <a href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a></p>
                      @if ($product_detail->sub_cat_info)
                      <p class="cat mt-1">Sub Category: <a href="{{route('product-sub-cat',[$product_detail->car_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a></p>

                          
                      @endif
                      <p class="availability">Stock: @if ($product_detail->stock>0) <span class="badge bage-success">{{$product_detail->stock}}</span> @else <span class="badge badge-danger">{{$product_detail->sock}}</span>
                          
                      @endif</p>
                    </div>
                    {{-- End Product Buy --}}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    {{-- Tab Nav --}}
                    <ul class="nav nav-tabs" id="mytab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a></li>
                        <li class="nav-item"><a  class="nav-link" data-toggle="tab" href="#review" role="tab">Reviews</a></li>

                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                   {{-- Description --}}


                   <div class="tab-pane fade show active" id="desc" role="tabpanel">
                    <div class="tab-single">
                        <div class="row">
                            <div class="col-12">
                                <div class="single-des">
                                    <p>{!! ($product_detail->description) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- End Description --}}


                    {{-- Reviews Tab --}}

                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="tab-single review-panel">
                            <div class="row">
                                <div class="col-12">

                                    {{-- Review --}}

                                    <div class="comment-review">
                                        <div class="add-review">
                                            <h5>Add A REview</h5>
                                            <p>Your email address will not be published Required fields are marked</p>

                                        </div>
                                        <h4>Your Rating <span class="text-danger">*</span></h4>
                                        <div class="review-inner"></div>
                                        {{-- Form --}}

                                        @auth
                                            <form  class="form" method="post" action="{{route('review.store',$product_detail->slug)}}">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-12 col-12">
                                                    <div class="rating_box">
                                                        <div class="start-rating">
                                                            <div class="start-rating__wrap">
                                                                <input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-5" title="5 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-4" title="4 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-3" title="3 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-2" title="2 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1">
																					  <label class="star-rating__ico fa fa-star-o" for="star-rating-1" title="1 out of 5 stars"></label>
                                                                                      @error('rate')
                                                                                          <span class="text-danger">{{$message}}</span>
        
                                                                                      @enderror 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-12">
                                                    <div class="form-group">
                                                        <label>Write a review</label>
                                                        <textarea name="review"  placeholder="" rows="6"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12 col-12">
                                                    <div class="form-group button5">
                                                        <button type="submit" class="btn">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            </form>

                                            @else
                                            <p class="text-center p-5">
                                                You need to <a href="{{route('login.form')}}" style="color: rgb(54, 54, 204)">Login</a>
                                                <a style="color: blue" href="{{route('register.form')}}">Register</a>

                                            </p>
                                            {{-- End Form --}}
                                        @endauth
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
