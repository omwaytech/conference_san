@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{ route('front.index') }}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Workshop Details
                            </a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;"> {{ $workshop->title }}
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
                                        {{-- <div class="bottom-area justify-content-start mb--10">
                                            <span class="date"> {{Carbon\Carbon::parse($workshop->start_date)->format('d F, Y')}}</span>
                                        </div> --}}

                                        <div>
                                            <p><b>Date:</b>
                                                {{ Carbon\Carbon::parse($workshop->start_date)->format('d F, Y') .
                                                    (!empty($workshop->end_date) ? ' - ' . Carbon\Carbon::parse($workshop->end_date)->format('d F, Y') : '') }}
                                                <br>
                                                <b>Veneu:</b> {{ $workshop->venue }} <br>
                                                <b>No. of Participants:</b> {{ $workshop->no_of_participants }} <br>
                                            </p>
                                        </div>
                                    </div>
                                    {{-- <a href="#" class="thumbnail">
                                        <img class="w-100" src="assets/images/blog/05.jpg" alt="">
                                    </a> --}}

                                </div>
                                <div class="post-panel">
                                    <div class="post-content">
                                        <p><b>Aims & Scope of Workshop:</b></p>
                                        <p class="first-text" style="">{!! $workshop->description !!}</p>
                                    </div>
                                </div>
                                <div>
                                    {{-- <div class="inner-content-wrapper text-start"> --}}
                                    <div>
                                        <p><b>Instructors:</b><br>
                                        <div class="row">
                                            @php
                                                $trainers = DB::table('workshop_trainers')
                                                    ->where(['workshop_id' => $workshop->id, 'status' => 1])
                                                    ->get();
                                            @endphp
                                            @if (!empty($trainers))
                                                @foreach ($trainers as $trainer)
                                                    <div class="col-3 mb-1">
                                                        <div class="workshop-img-text">
                                                            <img src="{{ asset('storage/workshop/trainers/image/' . $trainer->image) }}"
                                                                class="card-img-top" alt="{{ $trainer->name }}" />
                                                            <div class="card-body">
                                                                <h5 class="card-title">{{ $trainer->name }}</h5>
                                                                <small>{{ $trainer->affiliation }}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div><br>
                                        <b>Schedules:</b>
                                        </p>
                                    </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 sticky-coloum-item">
                            <div class="fluxi-right-ct-1">

                                <div class="rts-single-wized Recent-post">
                                    <div class="wized-header">
                                        <h5 class="title">
                                            Other Workshops
                                        </h5>
                                    </div>
                                    <div class="wized-body">
                                        @foreach ($workshops as $workshopItem)
                                            <div class="recent-post-single">
                                                <div class="thumbnail">
                                                    <a href="{{ route('front.noticeDetail', $workshopItem->slug) }}">
                                                        @if (!empty($workshopItem->image))
                                                            <img
                                                                src="{{ asset('storage/notice/' . $workshopItem->image) }}" />
                                                        @else
                                                            <img src="{{ asset('frontend') }}/assets/images/blog/02.png" />
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="content-area text-start">
                                                    <div class="user">
                                                        <i class="fal fa-clock"></i>
                                                        <span>{{ Carbon\Carbon::parse($workshopItem->start_date)->format('d M, Y') }}</span>
                                                    </div>
                                                    <a class="post-title"
                                                        href="{{ route('front.workshopDetail', $workshopItem->slug) }}">
                                                        <h6 class="title">{{ $workshopItem->title }}</h6>
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
    <style>
        .workshop-img-text {
            text-align: center;
            padding: 15px;
        }

        .workshop-img-text img {
            height: auto;
            background: #e8b7ba;
            border-radius: 100%;
            border: #fff 5px solid;
            box-shadow: 0px 1px 0px 1px rgba(0, 0, 0, 0.3)
        }

        .workshop-img-text .card-body {
            text-align: center;
            font-size: 16px;
        }

        .workshop-img-text .card-body h5 {
            font-size: 14px;
        }

        .workshop-img-text .card-body small {
            line-height: 5px !important;
            text-align: italic !important;
        }

        .post-content p {
            margin: 5px 0px;
        }
    </style>
@endsection
