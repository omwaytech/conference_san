@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{route('front.index')}}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Abstract Guidelines
                            </a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">Abstract Guidelines
                            </h2>
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
                        <div class="col-xl-12 col-lg-12">
                            <div class="fluxi-left-post">
                                <div class="post-panel">
                                    <div class="post-content">
                                        <p class="first-text">{!! !empty($submissionSetting->abstract_guidelines) ? $submissionSetting->abstract_guidelines : '' !!}</p>
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
