@extends('frontend.layouts.master')

@section('title','E-SHOP || Blog Page')

@section('main-content')


<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home <i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javasript:void(0);">Blog Grid Sidebar</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>




<section class="blog-single shop-blog grid section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="row">
                    @foreach ($posts as $post )

                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="shop-single-blog">
                            <img src="{{$post->photo}}" alt="{{$post->photo}}">
                            <div class="content">
                                <p class="date"><i class="fa fa-calendar" aria-hidden="true"></i>{{$post->created_at->format('d M,Y. D')}}
                                <span class="float-right">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    {{$post->author_info->name ?? 'Anonymous'}}
                                </span>
                                </p>



                                <a href="{{route('blog.detail',$post->slug)}}"  class="title">{{$post->title}}</a>

                                <p>{!! html_entity_decode($post->summary) !!}</p>

                                <a href="{{route('blog.detail',$post->slug)}}" class="more-btn">Continue Reading</a>




                            </div>
                        </div>
                    </div>
                        
                    @endforeach

                    <div class="col-12">

                    </div>
                </div>
            </div>
             
            <div class="col-lg-4 col-12">
                <div class="main-sidebar">
                    <div class="single-widget search">
                        <form class="form" action="{{route('blog.search')}}" method="get">
                        <input type="text" placeholder="Search Here..." name="search">
                        <button type="submit" class="button" ><i class="fa fa-search"></i></button>

                        </form>
                    </div>


                    <div class="single-widget category">
                        <h3 class="title">Blog Categories</h3>
                        <ul class="category-list">

                            @if (!empty($_GET['category']))
                            @php
                                $filter_cats = exploade(',',$_GET['category']);
                            @endphp

                                
                            @endif


                            <form action="{{route('blog.filter')}}" method="post">
                             @csrf
                             @foreach (Helper::postCategoryList('post') as $cat )
                             <li>
                                <a href="{{route('blog.category',$cat->slug)}}">{{$cat->title}}</a>

                             </li>
                                 
                             @endforeach
                            </form>
                        </ul>
                    </div>



                    <div class="single-widget recent-post">
                        <h3 class="title">Recent post</h3>
                        @foreach ($recent_posts as $post)

                        <div class="single-post">
                            <div class="image">
                                <img src="{{$post->photo}}" alt="{{$post->photo}}">

                            </div>

                            <div class="content">
                                <h5><a href="#">{{$post->title}}</a></h5>
                                <ul class="comment">
                                    <li><i class="fa fa-calendar" aria-hidden="true"></i>{{$post->created_at->format('d M,y')}}</li>
                                    <li><i class="fa fa-user" aria-hidden="true"></i>
                                     {{$post->author_info->name ?? 'Anonymous'}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                            
                        @endforeach
                    </div>





                    <div class="single-widget side-tags">
                        <h3 class="title">Tags</h3>
                        <ul class="tag">
                            @if (!empty($_GET['tag']))
                            @php
                                $filter_tags = explode(',',$_GET['tag']);
                            @endphp
                                
                            @endif

                            <form action="{{route('blog.filter')}}" method="post">
                            @csrf
                            @foreach (Helper::postTagList('posts') as $tag)
                       
                            <li>
                                <li>
                                    <a href="{{route('blog.tag',$tag->title)}}">{{$tag->title}}</a>

                                </li>
                            </li>
                                
                            @endforeach
                            
                            </form>
                        </ul>
                    </div>



                    <div class="single-widget newsletter">
                        <h3 class="title">Newslatter</h3>
                        <div class="letter-inner">
                            <h4>Subsribe $ get new <br> latest update. </h4>

                            <form action="{{route('subscribe')}}" method="post" class="form-inner">
                            @csrf
                            <input type="emai" name="email" placeholder="Enter your email">
                            <button type="submit" class="btn" style="width: 100%">Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .pagination{
        display: inline-flex;
    }
</style>
    
@endpush
