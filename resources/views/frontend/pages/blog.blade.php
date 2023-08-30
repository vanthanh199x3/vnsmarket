@extends('frontend.layouts.master')
@section('title', config('app.name').' - '. __('web.post'))
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">{{ __('web.home') }}<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">{{ __('web.post') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Blog Single -->
    <section class="blog-single shop-blog grid section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        @foreach($posts as $post)
                        {{-- {{$post}} --}}
                            <div class="col-lg-6 col-md-6 col-12">
                                <!-- Start Single Blog  -->
                                <div class="shop-single-blog">
                                <img src="{{$post->photo}}" alt="{{$post->photo}}">
                                    <div class="content text-left">
                                        <p class="date"><i class="fa fa-calendar" aria-hidden="true"></i> {{$post->created_at->format('d/m/Y')}}
                                            <span class="float-right">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                 {{$post->author_info->name ?? 'Anonymous'}}
                                            </span>
                                        </p>
                                        <a href="{{route('blog.detail',$post->slug)}}" class="title">{{$post->title}}</a>
                                        <!-- <a href="{{route('blog.detail',$post->slug)}}" class="more-btn">{{ __('web.continue_reading') }}</a> -->
                                    </div>
                                </div>
                                <!-- End Single Blog  -->
                            </div>
                        @endforeach
                        <div class="col-12">
                            <!-- Pagination -->
                            {{-- {{$posts->appends($_GET)->links()}} --}}
                            <!--/ End Pagination -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget search d-none">
                            <form class="form" method="GET" action="{{route('blog.search')}}">
                                <input type="text" placeholder="{{ __('web.search_post') }}" name="search">
                                <button class="button" type="sumbit"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">{{ __('web.post_category') }}</h3>
                            <ul class="categor-list">
                                @if(!empty($_GET['category']))
                                    @php
                                        $filter_cats=explode(',',$_GET['category']);
                                    @endphp
                                @endif
                            <form action="{{route('blog.filter')}}" method="POST">
                                    @csrf
                                    {{-- {{count(Helper::postCategoryList())}} --}}
                                    @foreach(Helper::postCategoryList('posts') as $cat)
                                    <li>
                                        <a href="{{route('blog.category',$cat->slug)}}">{{$cat->title}} </a>
                                    </li>
                                    @endforeach
                                </form>

                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget recent-post">
                            <h3 class="title">{{ __('web.recent_post') }}</h3>
                            @foreach($recent_posts as $post)
                                <!-- Single Post -->
                                <div class="single-post">
                                    <div class="image">
                                        <img src="{{$post->photo}}" alt="{{$post->photo}}">
                                    </div>
                                    <div class="content">
                                        <h5><a href="#">{{$post->title}}</a></h5>
                                        <ul class="comment">
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i>{{$post->created_at->format('d/m/Y')}}</li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                {{$post->author_info->name ?? 'Anonymous'}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Single Post -->
                            @endforeach
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget side-tags d-none">
                            <h3 class="title">{{ __('web.tag') }}</h3>
                            <ul class="tag">
                                @if(!empty($_GET['tag']))
                                    @php
                                        $filter_tags=explode(',',$_GET['tag']);
                                    @endphp
                                @endif
                                <form action="{{route('blog.filter')}}" method="POST">
                                    @csrf
                                    @foreach(Helper::postTagList('posts') as $tag)
                                        <li>
                                            <li>
                                                <a href="{{route('blog.tag',$tag->title)}}">{{$tag->title}} </a>
                                            </li>
                                        </li>
                                    @endforeach
                                </form>
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget newsletter d-none">
                            <h3 class="title">{{ __('web.newsletter') }}</h3>
                            <div class="letter-inner">
                                <h4>{{ __('web.newsletter_title_post') }}</h4>
                                <form method="POST" action="{{route('subscribe')}}" class="form-inner">
                                    @csrf
                                    <input type="email" name="email" placeholder="{{ __('web.email') }}">
                                    <button type="submit" class="btn " style="width: 100%">{{ __('web.register') }}</button>
                                </form>
                            </div>
                        </div>
                        <!--/ End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blog Single -->
@endsection
@push('styles')
    <style>
        .pagination{
            display:inline-flex;
        }
    </style>

@endpush
