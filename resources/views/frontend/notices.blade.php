@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{route('front.index')}}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">News & Notice
                            </a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">News & Notice
                            </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rts-section-gapBottom rts-blog-area-one">
        <div class="container">
            <div class="row g-48 mt--0 justify-content-sm-center justify-content-md-start">
                @forelse ($notices as $notice)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <!-- single blog area start -->
                        <div class="single-blog-area-style-one">
                            <a href="{{route('front.noticeDetail', $notice->slug)}}" class="thumbnail">
                                @if (!empty($notice->image))
                                    <img src="{{asset('storage/notice/'.$notice->image)}}" alt="blog-image">
                                @else
                                    <img src="{{asset('frontend')}}/assets/images/blog/02.png" alt="blog-image">
                                @endif
                            </a>
                            <div class="inner-content-wrapper">
                                <a href="{{route('front.noticeDetail', $notice->slug)}}">
                                    <h6 class="title">
                                        {{$notice->title}}
                                    </h6>
                                </a>
                                <div class="bottom-area">
                                    {{-- <span class="admin">Amir Nisi</span> --}}
                                    <span class="date">{{Carbon\Carbon::parse($notice->date)->format('d F, Y')}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- single blog area end -->
                    </div>
                @empty
                    <p class="text-danger text-center">News/Notices Not Added Yet.</p>
                @endforelse
                @if (!empty($notices))
                    <div class="rts-fluxi-pagination">
                        <ul>
                            {{-- Previous Page Link --}}
                            @if ($notices->onFirstPage())
                                <li><button disabled><i class="fa-solid fa-chevron-left"></i></button></li>
                            @else
                                <li><button onclick="window.location='{{ $notices->previousPageUrl() }}'"><i class="fa-solid fa-chevron-left"></i></button></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($notices->getUrlRange(1, $notices->lastPage()) as $page => $url)
                                @if ($page == $notices->currentPage())
                                    <li><button class="active">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</button></li>
                                @else
                                    <li><button onclick="window.location='{{ $url }}'">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</button></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($notices->hasMorePages())
                                <li><button onclick="window.location='{{ $notices->nextPageUrl() }}'"><i class="fa-solid fa-chevron-right"></i></button></li>
                            @else
                                <li><button disabled><i class="fa-solid fa-chevron-right"></i></button></li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
