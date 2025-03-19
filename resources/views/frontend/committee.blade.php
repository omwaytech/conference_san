@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{ route('front.index') }}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Committee</a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">
                            {{ $committee->committee_name }}</h1>
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
                        <span class="pre skew-up text-center">{{ $committee->committee_name }}</span>
                    </div>
                </div>
            </div>
            <div class="row g-48 mt--10">
                @if ($committee->id == 2)
                    @php
                        $sanMembers = [];
                        $aspaMembers = [];
                        foreach ($committeeMembers as $member) {
                            if ($member->member_type_id == 9 || $member->member_type_id == 9) {
                                $aspaMembers[] = $member;
                            } else {
                                $sanMembers[] = $member;
                            }
                        }
                    @endphp
                    <h5 class="text-center text-success"><b><u>SAN Committee Members</u></b></h5>
                    @foreach ($sanMembers as $sanMember)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- single teama area start -->
                            <div class="single-team-area-7">
                                <div class="thumbnail">
                                    @if (!empty($sanMember->image))
                                        <img src="{{ asset('storage/users/' . $sanMember->image) }}" alt="team">
                                    @else
                                        <img src="{{ asset('frontend') }}/assets/images/about/Blank.png" alt="team">
                                    @endif
                                </div>
                                <h6 class="title">
                                    {{ $sanMember->prefix . ' ' . $sanMember->f_name . ' ' . $sanMember->m_name . ' ' . $sanMember->l_name }}
                                </h6>
                                <span class="designation">{{ $sanMember->designation }}</span>
                            </div>
                            <!-- single teama area end -->
                        </div>
                    @endforeach
                    <h5 class="text-center text-success"><b><u>ASPA Committee Members</u></b></h5>
                    @foreach ($aspaMembers as $sanMember)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- single teama area start -->
                            <div class="single-team-area-7">
                                <div class="thumbnail">
                                    @if (!empty($sanMember->image))
                                        <img src="{{ asset('storage/users/' . $sanMember->image) }}" alt="team"
                                            style="object-fit: cover">
                                    @else
                                        <img src="{{ asset('frontend') }}/assets/images/about/Blank.png" alt="team">
                                    @endif
                                </div>
                                <h6 class="title">
                                    {{ $sanMember->prefix . ' ' . $sanMember->f_name . ' ' . $sanMember->m_name . ' ' . $sanMember->l_name }}
                                </h6>
                                <span class="designation">{{ $sanMember->designation }}</span>
                            </div>
                            <!-- single teama area end -->
                        </div>
                    @endforeach
                @else
                    @forelse ($committeeMembers as $c_member)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <!-- single teama area start -->
                            <div class="single-team-area-7">
                                <div class="thumbnail">
                                    @if (!empty($c_member->image))
                                        <img class="image" src="{{ asset('storage/users/' . $c_member->image) }}"
                                            alt="team" style="object-fit: cover">
                                    @else
                                        <img src="{{ asset('frontend') }}/assets/images/about/Blank.png" alt="team">
                                    @endif
                                </div>
                                <h6 class="title">
                                    {{ $c_member->prefix . ' ' . $c_member->f_name . ' ' . $c_member->m_name . ' ' . $c_member->l_name }}
                                </h6>
                                <span class="designation">{{ $c_member->designation }}</span>
                            </div>
                            <!-- single teama area end -->
                        </div>
                    @empty
                        <p class="text-danger text-center">Committee Members Not Available Yet.</p>
                    @endforelse
                @endif
            </div>
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
