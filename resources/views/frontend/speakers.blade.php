@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{ route('front.index') }}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Speakers</a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">Speakers</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="expart-team-area-7 rts-section-gapTop rts-section-gap2Bottom inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="title-style-one-center">
                        <span class="pre skew-up text-center">Speakers</span>
                        <h2 class="title skew-up text-center">Meet the brilliant minds behind our <br> successful
                            Conference</h2>
                    </div>
                </div>
            </div>
            <div class="row g-48 mt--10">
                @php
                    use Illuminate\Support\Str;
                @endphp

                @php
                    // $residents = $speakers->filter(function ($speaker) {
                    //     return Str::contains(strtolower($speaker->user->userDetail->affiliation), [
                    //         'resident',
                    //         'general member',
                    //     ]);
                    // });

                    // $generalMembers = $speakers->reject(function ($speaker) {
                    //     return Str::contains(strtolower($speaker->user->userDetail->affiliation), 'resident');
                    // });
                    $internationalFaculty = $speakers
                        ->filter(function ($speaker) {
                            return in_array($speaker->user->userDetail->member_type_id, [5, 6, 9, 10]);
                        })
                        ->sortByDesc(function ($speaker) {
                            return !empty($speaker->user->userDetail->image);
                        });
                    $nationalFaculty = $speakers
                        ->filter(function ($speaker) {
                            return in_array($speaker->user->userDetail->member_type_id, [1, 3]);
                        })
                        ->sortByDesc(function ($speaker) {
                            return !empty($speaker->user->userDetail->image);
                        });
                    $internationalPgStudent = $speakers
                        ->filter(function ($speaker) {
                            return in_array($speaker->user->userDetail->member_type_id, [7, 8]);
                        })
                        ->sortByDesc(function ($speaker) {
                            return !empty($speaker->user->userDetail->image);
                        });
                    $nationalPgStudent = $speakers
                        ->filter(function ($speaker) {
                            return in_array($speaker->user->userDetail->member_type_id, [2, 4]);
                        })
                        ->sortByDesc(function ($speaker) {
                            return !empty($speaker->user->userDetail->image);
                        });
                    // dd($internationalFaculty);
                @endphp
                @if ($internationalFaculty->isNotEmpty())
                    <h3 class="text-center">International Faculty</h3>

                    <div class="row">
                        @foreach ($internationalFaculty as $speaker)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="single-team-area-7">
                                    <div class="thumbnail">
                                        @if (!empty($speaker->user->userDetail->image))
                                            <img src="{{ asset('storage/users/' . $speaker->user->userDetail->image) }}"
                                                alt="team">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/about/Blank.png') }}" alt="team">
                                        @endif
                                    </div>
                                    <h6 class="title">{{ $speaker->user->fullName($speaker, 'user') }}</h6>
                                    <span class="designation">{{ $speaker->user->userDetail->affiliation }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="row g-48 mt--10">

                @if ($nationalFaculty->isNotEmpty())
                    <h3 class="text-center">National Faculty</h3>
                    <div class="row">
                        @foreach ($nationalFaculty as $speaker)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="single-team-area-7">
                                    <div class="thumbnail">
                                        @if (!empty($speaker->user->userDetail->image))
                                            <img src="{{ asset('storage/users/' . $speaker->user->userDetail->image) }}"
                                                alt="team">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/about/Blank.png') }}" alt="team">
                                        @endif
                                    </div>
                                    <h6 class="title">{{ $speaker->user->fullName($speaker, 'user') }}</h6>
                                    <span class="designation">{{ $speaker->user->userDetail->affiliation }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif


            </div>
            <div class="row g-48 mt--10">

                @if ($internationalPgStudent->isNotEmpty())
                    <h3 class="text-center">International PG Students</h3>
                    <div class="row">
                        @foreach ($internationalPgStudent as $speaker)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="single-team-area-7">
                                    <div class="thumbnail">
                                        @if (!empty($speaker->user->userDetail->image))
                                            <img src="{{ asset('storage/users/' . $speaker->user->userDetail->image) }}"
                                                alt="team">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/about/Blank.png') }}"
                                                alt="team">
                                        @endif
                                    </div>
                                    <h6 class="title">{{ $speaker->user->fullName($speaker, 'user') }}</h6>
                                    <span class="designation">{{ $speaker->user->userDetail->affiliation }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif


            </div>
            <div class="row g-48 mt--10">

                @if ($nationalPgStudent->isNotEmpty())
                    <h3 class="text-center">National PG Students</h3>
                    <div class="row">
                        @foreach ($nationalPgStudent as $speaker)
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="single-team-area-7">
                                    <div class="thumbnail">
                                        @if (!empty($speaker->user->userDetail->image))
                                            <img src="{{ asset('storage/users/' . $speaker->user->userDetail->image) }}"
                                                alt="team">
                                        @else
                                            <img src="{{ asset('frontend/assets/images/about/Blank.png') }}"
                                                alt="team">
                                        @endif
                                    </div>
                                    <h6 class="title">{{ $speaker->user->fullName($speaker, 'user') }}</h6>
                                    <span class="designation">{{ $speaker->user->userDetail->affiliation }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif


            </div>

            {{-- @if ($residents->isEmpty() && $generalMembers->isEmpty())
                    <p class="text-danger text-center">Speakers Not Available Yet.</p>
                @endif --}}

        </div>
    </div>

    <style>
        .thumbnail {
            text-align: center;
            padding: 15px;
        }

        .thumbnail img {
            height: auto;
            background: #e8b7ba;
            border-radius: 100%;
            border: #fff 5px solid;
            box-shadow: 0px 1px 0px 1px rgba(0, 0, 0, 0.3);
            max-width: 200px !important;
            min-width: 200px !important;
            height: 100% !important;

        }

        .thumbnail .card-body {
            text-align: center;
            font-size: 16px;
        }

        .thumbnail .card-body h5 {
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
