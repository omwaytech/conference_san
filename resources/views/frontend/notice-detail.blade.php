@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{route('front.index')}}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Details
                            </a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">News & Notice
                            </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- rts service area start -->
    <section class="fluxi-hero-section inner details rts-section-gapBottom inner-post">
        <div class="fluxi-hero">
            <div class="container">
                <div class="fluxi-full-hero-content">
                    <div class="row gx-5 sticky-coloum-wrap">
                        <div class="col-xl-8 col-lg-8">
                            <div class="fluxi-left-post">
                                <div class="single-blog-area-style-one">
                                    <div class="inner-content-wrapper text-start">
                                        <div class="bottom-area justify-content-start mb--10">

                                            <span class="date"> {{Carbon\Carbon::parse($notice->date)->format('d F, Y')}}</span>
                                        </div>
                                        <h6 class="title text-start">
                                            {{$notice->title}}
                                        </h6>
                                    </div>
                                    <a href="{{ asset('storage/notice/' . $notice->image) }}" target="_blank" class="thumbnail">
                                        <img class="w-100" src="{{ asset('storage/notice/' . $notice->image) }}" alt="image">
                                    </a>

                                </div>
                                <div class="post-panel">
                                    <div class="post-content">
                                        <p class="first-text">{!! $notice->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 sticky-coloum-item">
                            <div class="fluxi-right-ct-1">

                                <div class="rts-single-wized Recent-post">
                                    <div class="wized-header">
                                        <h5 class="title">
                                            Recent Posts
                                        </h5>
                                    </div>
                                    <div class="wized-body">
                                        @foreach ($notices as $r_notice)
                                            <div class="recent-post-single">
                                                <div class="thumbnail">
                                                    <a href="{{route('front.noticeDetail', $r_notice->slug)}}">
                                                        @if (!empty($r_notice->image))
                                                            <img src="{{asset('storage/notice/'.$r_notice->image)}}" alt="Blog_post">
                                                        @else
                                                            <img src="{{asset('frontend')}}/assets/images/blog/02.png" alt="Blog_post">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="content-area text-start">
                                                    <div class="user">
                                                        <i class="fal fa-clock"></i>
                                                        <span>{{Carbon\Carbon::parse($r_notice->date)->format('d M, Y')}}</span>
                                                    </div>
                                                    <a class="post-title" href="{{route('front.noticeDetail', $r_notice->slug)}}">
                                                        <h6 class="title">{{$r_notice->title}}</h6>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
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
