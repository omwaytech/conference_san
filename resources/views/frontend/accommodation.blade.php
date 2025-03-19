@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{ route('front.index') }}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Accommodation
                            </a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">Hotels
                            </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rts-section-gapBottom rts-blog-area-one">
        <div class="container">
            <div class="row g-48 mt--0 justify-content-sm-center justify-content-md-start">
                @forelse ($hotels as $hotel)
                    <div class="col-lg-4 col-md-6 col-sm-10">
                        <!-- single blog area start -->
                        <div class="single-blog-area-style-one">
                            <a href="{{ route('front.accommodationInner', $hotel->slug) }}" class="thumbnail">
                                @if (!empty($hotel->featured_image))
                                    <img src="{{ asset('storage/hotel/featured-image/' . $hotel->featured_image) }}"
                                        alt="blog-image">
                                @else
                                    <img src="{{ asset('default-images/hotel.png') }}" alt="blog-image">
                                @endif
                            </a>
                            <div class="inner-content-wrapper">
                                <a href="{{ route('front.accommodationInner', $hotel->slug) }}">
                                    <h6 class="title">
                                        {{ $hotel->name }}
                                    </h6>
                                </a>
                                <div class="bottom-area">
                                    <span class="admin">{{ $hotel->address }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- single blog area end -->
                    </div>
                @empty
                    <p class="text-danger text-center">Hotels Not Added Yet.</p>
                @endforelse
            </div>
        </div>
    </div>

        <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" >
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                     
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">Tour And Travel
                            </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="rts-section-gapBottom rts-blog-area-one">
        <div class="container">
            <div class="row mt--0 justify-content-sm-center justify-content-md-start">
    
                <div class="col-lg-12 col-md-6 col-sm-10">
                    {{-- <iframe src="{{ asset('default-images/travel.pdf') }}" width="100%" height="1800px"></iframe> --}}
                    <div class="row g-48 mt--0 justify-content-sm-center justify-content-md-start">
                        <div class="col-lg-12 col-md-6 col-sm-10 d-flex justify-content-center" >
                            <!-- single blog area start -->
                            <div class="single-blog-area-style-one">
                                <a href="https://experts.holiday/package_tags/sdn/" target="_blank" class="thumbnail">
                                    <img style="height: 200px; width: 800px;" src="https://experts.holiday/wp-content/uploads/2022/08/FULL-NAME-LOGO-scaled.jpg"
                                        alt="expert-holidays">

                                </a>
                                <div class="inner-content-wrapper">
                                    <a href="https://experts.holiday/package_tags/sdn/" target="_blank">
                                        <h4 class="title">
                                            <u>Holiday Expert Travel Pvt. Ltd.</u>

                                        </h4>
                                    </a>
                                    <div class="bottom-area">
                                        <div class="" style="">

                                            <p class="admin" >Contact Person: Reeya Bajracharya
                                            </p>
                                            <span class="admin" >Contact number: +9779843438409, +9779801540590
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- single blog area end -->
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
