@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{ route('front.index') }}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Details
                            </a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">Hotel
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
                                        <h6 class="title text-start">
                                            Hotel Name: {{ $hotel->name }}
                                        </h6>
                                        {{-- @dd($hotel) --}}
                                        <ul>
                                            <li>Address: {{ $hotel->address }}</li>
                                            <li>Price: {{ $hotel->price }}</li>
                                            {{-- <li>Facility: {{ $hotel->facility }}</li> --}}
                                            @if (!empty($hotel->contact_person) || !empty($hotel->email) || !empty($hotel->phone))
                                                <li>Contact Person
                                                    <ul>
                                                        @if (!empty($hotel->contact_person))
                                                            <li><b>Name: </b> {{ $hotel->contact_person }}</li>
                                                        @endif
                                                        @if (!empty($hotel->email))
                                                            <li><b>Email: </b>{{ $hotel->email }}</li>
                                                        @endif
                                                        @if (!empty($hotel->phone))
                                                            <li><b>WhatsApp/Phone: </b> {{ $hotel->phone }}</li>
                                                        @endif
                                                    </ul>
                                                </li>
                                            @endif
                                            @if (!empty($hotel->promo_code))
                                                <li>Promo Code: {{ $hotel->promo_code }} <span class="text-danger">(Use this
                                                        promo code for reservation through hotel's website).</span></li>
                                            @endif
                                            @if ($hotel->name == 'Hotel Shambala')
                                                <li><span class="text-danger">Note: 33% off using promo code on the
                                                        displayed rate on website. Valid for 2nd april till 7th april 2025.
                                                        Bookable from now</span></li>
                                            @endif
                                        </ul>
                                        <p><a href="{{ $hotel->website }}" target="_blank" class="text text-info">-> Click
                                                here to view website</a></p>
                                    </div>
                                    <div class="inner-content-wrapper text-start">
                                        <h6 class="title text-start">
                                            About Hotel
                                        </h6>
                                        @if (!empty($hotel->description))
                                            <span class="">{!! $hotel->description !!}</span>
                                        @endif
                                        <ul>

                                            {{-- <li>Address: {{ $hotel->address }}</li> --}}
                                            {{-- <li>Price: {{ $hotel->price }}</li> --}}
                                            @if (!empty($hotel->facility))
                                                <li>Facility: {{ $hotel->facility }}</li>
                                            @endif
                                        </ul>

                                    </div>
                                </div>
                                {{-- <div class="post-panel">
                                    <div class="post-content">
                                        <p class="first-text">{!! $hotel->description !!}</p>
                                    </div>
                                </div> --}}
                            </div>
                            <style>
                                .card-img-top {
                                    object-fit: cover;
                                    height: 200px;
                                }
                            </style>
                            @if (!empty($hotel->images))
                                @php
                                    $images = json_decode($hotel->images, true);
                                @endphp
                                @if (!empty($images) && is_array($images))
                                    <div class="pb-4">
                                        <h6>Photos of Hotel:</h6>
                                        <div class="row">
                                            @foreach ($images as $image)
                                                <div class="col-md-4 col-sm-6 mb-3">
                                                    <a target="_blank"
                                                        href="{{ asset('storage/hotel/images/large/' . $image['fileName']) }}">

                                                        <div class="card">
                                                            <img src="{{ asset('storage/hotel/images/large/' . $image['fileName']) }}"
                                                                class="card-img-top" alt="Hotel Image">
                                                            {{-- <div class="card-body">
                                                      <p class="card-text">Room Type: {{ $image['room_type'] }}</p>
                                                  </div> --}}
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <div>
                                <h6>Google Map Location:</h6>
                                <iframe src="{{ $hotel->google_map }}" style="width: 100%" height="400" style="border:0;"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                            {{-- @dd($hotel) --}}

                        </div>
                        <div class="col-xl-4 col-lg-4 sticky-coloum-item">
                            <div class="fluxi-right-ct-1">

                                <div class="rts-single-wized Recent-post">
                                    <div class="wized-header">
                                        <h5 class="title">
                                            Other Hotels
                                        </h5>
                                    </div>
                                    <div class="wized-body">

                                        @foreach ($accommodations as $accommodation)
                                            <div class="recent-post-single">
                                                <div class="thumbnail">
                                                    <a
                                                        href="{{ route('front.accommodationInner', $accommodation->slug) }}">
                                                        @if (!empty($accommodation->featured_image))
                                                            <img src="{{ asset('storage/hotel/featured-image/' . $accommodation->featured_image) }}"
                                                                alt="Blog_post">
                                                        @else
                                                            <img src="{{ asset('default-images/hotel.png') }}"
                                                                alt="Blog_post">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="content-area text-start">
                                                    <a class="post-title"
                                                        href="{{ route('front.accommodationInner', $accommodation->slug) }}">
                                                        <h6 class="title">{{ $accommodation->name }}</h6>
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
