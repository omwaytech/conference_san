@extends('layouts.dash')

@section('title')
    Home
@endsection

@section('styles')
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        #registrationInfo {
            animation: blink 1s infinite;
            /* You can adjust the duration and iteration count */
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        @if (auth()->user()->id == 2)
            <div class="main-content">
                <div class="breadcrumb">
                    <h4>Day 1</h4>

                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Attendance</h5>
                                    <ul>
                                        @php
                                            $OrganizerAttendaceDay1 = 0;
                                            $InternationalAttendaceDay1 = 0;
                                            $SpeakerAttendaceDay1 = 0;
                                            $AttendeeAttendaceDay1 = 0;
                                            $SponsorAttendaceDay1 = $day1AttendanceSponsor->count();
                                        @endphp

                                        @foreach ($day1Attendance as $attendance)
                                            {{-- @dd($attendance->conferenceRegistration->committeMember->isNotEmpty()) --}}

                                            @if (
                                                $attendance->conferenceRegistration &&
                                                    $attendance->conferenceRegistration->committeMember->isNotEmpty() &&
                                                    $attendance->conferenceRegistration->user->userDetail->country_id == 125)
                                                @php $OrganizerAttendaceDay1++ @endphp
                                            @elseif ($attendance->conferenceRegistration && $attendance->conferenceRegistration->user->userDetail->country_id != 125)
                                                @php $InternationalAttendaceDay1++ @endphp
                                            @elseif ($attendance->conferenceRegistration && $attendance->conferenceRegistration->registrant_type == 2)
                                                @php $SpeakerAttendaceDay1++ @endphp
                                            @else
                                                @php $AttendeeAttendaceDay1++ @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            // Calculate total attendance for Day 1
                                            $TotalAttendanceDay1 =
                                                $OrganizerAttendaceDay1 +
                                                $InternationalAttendaceDay1 +
                                                $SpeakerAttendaceDay1 +
                                                $AttendeeAttendaceDay1 +
                                                $SponsorAttendaceDay1;
                                        @endphp
                                        <li>Organizer:{{ $OrganizerAttendaceDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyAttendance', ['day1', 'organizer']) }}">View</a></span>
                                        </li>
                                        <li>International:{{ $InternationalAttendaceDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyAttendance', ['day1', 'international']) }}">View</a></span>
                                        </li>
                                        <li>Speaker/Faculty:{{ $SpeakerAttendaceDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyAttendance', ['day1', 'speaker']) }}">View</a></span>
                                        </li>
                                        <li>Delegate:{{ $AttendeeAttendaceDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyAttendance', ['day1', 'delegate']) }}">View</a></span>
                                        </li>
                                        <li>Sponsor:{{ $SponsorAttendaceDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewSponsorAttendance', ['day1']) }}">View</a></span>
                                        </li>

                                    </ul>
                                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid #ccc;">
                                    <h4>Total: {{ $TotalAttendanceDay1 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $OrganizerLaunchDay1 = 0;
                        $InternationalLaunchDay1 = 0;
                        $SpeakerLaunchDay1 = 0;
                        $AttendeeLaunchDay1 = 0;
                        $sponsorLaunchDay1 = 0;
                    @endphp

                    @foreach ($day1Launch as $launch)
                        {{-- @dd($launch->conferenceRegistration) --}}
                        @if (
                            $launch->conferenceRegistration &&
                                $launch->conferenceRegistration->committeMember->isNotEmpty() &&
                                $launch->conferenceRegistration->user->userDetail->country_id == 125)
                            @php $OrganizerLaunchDay1 = $OrganizerLaunchDay1+$launch->lunch_taken @endphp
                        @elseif ($launch->conferenceRegistration && $launch->conferenceRegistration->user->userDetail->country_id != 125)
                            @php $InternationalLaunchDay1 =  $InternationalLaunchDay1+$launch->lunch_taken @endphp
                        @elseif ($launch->conferenceRegistration && $launch->conferenceRegistration->registrant_type == 2 )
                            @php $SpeakerLaunchDay1 =  $SpeakerLaunchDay1+$launch->lunch_taken @endphp
                        @else
                            @php $AttendeeLaunchDay1 = $AttendeeLaunchDay1+$launch->lunch_taken @endphp
                        @endif
                    @endforeach

                    @foreach ($day1LaunchSponsor as $sponsorLunch)
                        {{-- @dd($sponsorLunch) --}}
                        @php
                            $sponsorLaunchDay1 = $sponsorLaunchDay1 + $sponsorLunch->lunch_taken;
                        @endphp
                    @endforeach

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Lunch</h5>
                                    <ul>
                                        @php
                                            // Calculate total lunch count
                                            $totalLunchDay1 =
                                                $OrganizerLaunchDay1 +
                                                $InternationalLaunchDay1 +
                                                $SpeakerLaunchDay1 +
                                                $AttendeeLaunchDay1 +
                                                $sponsorLaunchDay1;
                                        @endphp

                                        <li>Organizer:{{ $OrganizerLaunchDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day1', 'organizer', 'lunch']) }}">View</a></span>
                                        </li>
                                        <li>International:{{ $InternationalLaunchDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day1', 'international', 'lunch']) }}">View</a></span>
                                        </li>
                                        <li>Speaker/Faculty:{{ $SpeakerLaunchDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day1', 'speaker', 'lunch']) }}">View</a></span>
                                        </li>
                                        <li>Delegate:{{ $AttendeeLaunchDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day1', 'delegate', 'lunch']) }}">View</a></span>
                                        </li>
                                        <li>Sponsor:{{ $sponsorLaunchDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewSponsorDailyMeal', ['day1', 'lunch']) }}">View</a></span>
                                        </li>

                                    </ul>
                                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid #ccc;">
                                    <h4>Total: {{ $totalLunchDay1 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $OrganizerDinnerDay1 = 0;
                        $InternationalDinnerDay1 = 0;
                        $SpeakerDinnerDay1 = 0;
                        $AttendeeDinnerDay1 = 0;
                        $sponsorDinnerDay1 = 0;
                    @endphp

                    @foreach ($day1Dinner as $Dinner)
                        {{-- @dd($Dinner) --}}
                        @if (
                            $Dinner->conferenceRegistration &&
                                $Dinner->conferenceRegistration->committeMember->isNotEmpty() &&
                                $Dinner->conferenceRegistration->user->userDetail->country_id == 125)
                            @php $OrganizerDinnerDay1 = $OrganizerDinnerDay1 +$Dinner->dinner_taken @endphp
                        @elseif ($Dinner->conferenceRegistration && $Dinner->conferenceRegistration->user->userDetail->country_id != 125)
                            @php $InternationalDinnerDay1= $InternationalDinnerDay1 +$Dinner->dinner_taken @endphp
                        @elseif ($Dinner->conferenceRegistration && $Dinner->conferenceRegistration->registrant_type == 2)
                            @php $SpeakerDinnerDay1=$SpeakerDinnerDay1 + $Dinner->dinner_taken @endphp
                        @else
                            @php $AttendeeDinnerDay1= $AttendeeDinnerDay1 + $Dinner->dinner_taken @endphp
                        @endif
                    @endforeach
                    @foreach ($day1DinnerSponsor as $sponsorDinner)
                        @php
                            $sponsorDinnerDay1 = $sponsorDinnerDay1 + $sponsorDinner->dinner_taken;
                        @endphp
                    @endforeach
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Dinner</h5>
                                    <ul>
                                        @php
                                            // Calculate total dinner count
                                            $totalDinnerDay1 =
                                                $OrganizerDinnerDay1 +
                                                $InternationalDinnerDay1 +
                                                $SpeakerDinnerDay1 +
                                                $AttendeeDinnerDay1 +
                                                $sponsorDinnerDay1;
                                        @endphp

                                        <li>Organizer:{{ $OrganizerDinnerDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day1', 'organizer', 'dinner']) }}">View</a></span>
                                        </li>
                                        <li>International:{{ $InternationalDinnerDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day1', 'international', 'dinner']) }}">View</a></span>
                                        </li>
                                        <li>Speaker/Faculty:{{ $SpeakerDinnerDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day1', 'speaker', 'dinner']) }}">View</a></span>
                                        </li>
                                        <li>Delegate:{{ $AttendeeDinnerDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day1', 'delegate', 'dinner']) }}">View</a></span>
                                        </li>
                                        <li>Sponsor:{{ $sponsorDinnerDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewSponsorDailyMeal', ['day1', 'dinner']) }}">View</a></span>
                                        </li>

                                        {{-- @php
                                        $totalDinnerDay2 += $day2Dinner->total_dinners;
                                    @endphp --}}
                                    </ul>
                                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid #ccc;">
                                    <h4>Total: {{ $totalDinnerDay1 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Conference Kit</h5>
                                    <ul>
                                        @php
                                            $OrganizerKitDay1 = 0;
                                            $InternationalKitDay1 = 0;
                                            $SpeakerKitDay1 = 0;
                                            $AttendeeKitDay1 = 0;
                                        @endphp
                                        @foreach ($day1ConferenceKit as $kit)
                                            {{-- @dd($kit->conferenceRegistration->committeMember->isNotEmpty()) --}}

                                            @if (
                                                $kit->conferenceRegistration &&
                                                    $kit->conferenceRegistration->committeMember->isNotEmpty() &&
                                                    $kit->conferenceRegistration->user->userDetail->country_id == 125)
                                                @php $OrganizerKitDay1++ @endphp
                                            @elseif ($kit->conferenceRegistration && $kit->conferenceRegistration->user->userDetail->country_id != 125)
                                                @php $InternationalKitDay1++ @endphp
                                            @elseif ($kit->conferenceRegistration && $kit->conferenceRegistration->registrant_type == 2)
                                                @php $SpeakerKitDay1++ @endphp
                                            @else
                                                @php $AttendeeKitDay1++ @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            // Calculate total attendance for Day 1
                                            $TotalKitDay1 =
                                                $OrganizerKitDay1 +
                                                $InternationalKitDay1 +
                                                $SpeakerKitDay1 +
                                                $AttendeeKitDay1;
                                        @endphp

                                        <li>Organizer:{{ $OrganizerKitDay1 }} | 
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesConferenceKit', ['day1', 'organizer']) }}">View</a></span>
                                        </li>
                                        <li>International:{{ $InternationalKitDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesConferenceKit', ['day1', 'international']) }}">View</a></span>
                                        </li>
                                        <li>Speaker/Faculty:{{ $SpeakerKitDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesConferenceKit', ['day1', 'speaker']) }}">View</a></span>
                                        </li>
                                        <li>Delegate:{{ $AttendeeKitDay1 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesConferenceKit', ['day1', 'delegate']) }}">View</a></span>
                                        </li>

                                        {{-- @php
                                        $totalDinnerDay2 += $day2Dinner->total_dinners;
                                    @endphp --}}
                                    </ul>
                                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid #ccc;">
                                    <h4>Total: {{ $TotalKitDay1 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="separator-breadcrumb border-top"></div>

                <div class="breadcrumb">
                    <h4>Day 2</h4>

                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Attendance</h5>
                                    <ul>
                                        @php
                                            $OrganizerAttendaceDay2 = 0;
                                            $InternationalAttendaceDay2 = 0;
                                            $SpeakerAttendaceDay2 = 0;
                                            $AttendeeAttendaceDay2 = 0;
                                            $SponsorAttendaceDay2 = $day2AttendanceSponsor->count();

                                        @endphp

                                        @foreach ($day2Attendance as $attendance)
                                            @if (
                                                $attendance->conferenceRegistration &&
                                                    $attendance->conferenceRegistration->committeMember->isNotEmpty() &&
                                                    $attendance->conferenceRegistration->user->userDetail->country_id == 125)
                                                @php $OrganizerAttendaceDay2++ @endphp
                                            @elseif ($attendance->conferenceRegistration && $attendance->conferenceRegistration->user->userDetail->country_id != 125)
                                                @php $InternationalAttendaceDay2++ @endphp
                                            @elseif ($attendance->conferenceRegistration && $attendance->conferenceRegistration->registrant_type == 2)
                                                @php $SpeakerAttendaceDay2++ @endphp
                                            @else
                                                @php $AttendeeAttendaceDay2++ @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            // Calculate total attendance for Day 2
                                            $TotalAttendanceDay2 =
                                                $OrganizerAttendaceDay2 +
                                                $InternationalAttendaceDay2 +
                                                $SpeakerAttendaceDay2 +
                                                $AttendeeAttendaceDay2 +
                                                $SponsorAttendaceDay2;
                                        @endphp
                                        <li>Organizer:{{ $OrganizerAttendaceDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyAttendance', ['day2', 'organizer']) }}">View</a></span>
                                        </li>
                                        <li>International:{{ $InternationalAttendaceDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyAttendance', ['day2', 'international']) }}">View</a></span>
                                        </li>
                                        <li>Speaker/Faculty:{{ $SpeakerAttendaceDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyAttendance', ['day2', 'speaker']) }}">View</a></span>
                                        </li>
                                        <li>Delegate:{{ $AttendeeAttendaceDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyAttendance', ['day2', 'delegate']) }}">View</a></span>
                                        </li>
                                        <li>Sponsor:{{ $SponsorAttendaceDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewSponsorAttendance', ['day2']) }}">View</a></span>
                                        </li>

                                    </ul>
                                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid #ccc;">
                                    <h4>Total: {{ $TotalAttendanceDay2 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $OrganizerLaunchDay2 = 0;
                        $InternationalLaunchDay2 = 0;
                        $SpeakerLaunchDay2 = 0;
                        $AttendeeLaunchDay2 = 0;
                        $sponsorLaunchDay2 = 0;

                    @endphp

                    @foreach ($day2Launch as $launch)
                        {{-- @dd($launch->conferenceRegistration) --}}
                        @if (
                            $launch->conferenceRegistration &&
                                $launch->conferenceRegistration->committeMember->isNotEmpty() &&
                                $launch->conferenceRegistration->user->userDetail->country_id == 125)
                            @php $OrganizerLaunchDay2 = $OrganizerLaunchDay2+$launch->lunch_taken @endphp
                        @elseif ($launch->conferenceRegistration && $launch->conferenceRegistration->user->userDetail->country_id != 125)
                            @php $InternationalLaunchDay2 =  $InternationalLaunchDay2+$launch->lunch_taken @endphp
                        @elseif ($launch->conferenceRegistration && $launch->conferenceRegistration->registrant_type == 2 )
                            @php $SpeakerLaunchDay2 =  $SpeakerLaunchDay2+$launch->lunch_taken @endphp
                        @else
                            @php $AttendeeLaunchDay2 = $AttendeeLaunchDay2+$launch->lunch_taken @endphp
                        @endif
                    @endforeach

                    @foreach ($day2LaunchSponsor as $sponsorLunch)
                        @php
                            $sponsorLaunchDay2 = $sponsorLaunchDay2 + $sponsorLunch->lunch_taken;
                        @endphp
                    @endforeach

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Lunch</h5>
                                    <ul>
                                        @php
                                            // Calculate total lunch count
                                            $totalLunchDay2 =
                                                $OrganizerLaunchDay2 +
                                                $InternationalLaunchDay2 +
                                                $SpeakerLaunchDay2 +
                                                $AttendeeLaunchDay2 +
                                                $sponsorLaunchDay2;
                                        @endphp

                                        <li>Organizer:{{ $OrganizerLaunchDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day2', 'organizer', 'lunch']) }}">View</a></span>
                                        </li>
                                        <li>International:{{ $InternationalLaunchDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day2', 'international', 'lunch']) }}">View</a></span>
                                        </li>
                                        <li>Speaker/Faculty:{{ $SpeakerLaunchDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day2', 'speaker', 'lunch']) }}">View</a></span>
                                        </li>
                                        <li>Delegate:{{ $AttendeeLaunchDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day2', 'delegate', 'lunch']) }}">View</a></span>
                                        </li>
                                        <li>Sponsor:{{ $sponsorLaunchDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewSponsorDailyMeal', ['day2', 'lunch']) }}">View</a></span>
                                        </li>

                                    </ul>
                                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid #ccc;">
                                    <h4>Total: {{ $totalLunchDay2 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $OrganizerDinnerDay2 = 0;
                        $InternationalDinnerDay2 = 0;
                        $SpeakerDinnerDay2 = 0;
                        $AttendeeDinnerDay2 = 0;
                        $sponsorDinnerDay2 = 0;

                    @endphp

                    @foreach ($day2Dinner as $Dinner)
                        {{-- @dd($Dinner) --}}
                        @if (
                            $Dinner->conferenceRegistration &&
                                $Dinner->conferenceRegistration->committeMember->isNotEmpty() &&
                                $Dinner->conferenceRegistration->user->userDetail->country_id == 125)
                            @php $OrganizerDinnerDay2 = $OrganizerDinnerDay2 +$Dinner->dinner_taken @endphp
                        @elseif ($Dinner->conferenceRegistration && $Dinner->conferenceRegistration->user->userDetail->country_id != 125)
                            @php $InternationalDinnerDay2= $InternationalDinnerDay2 +$Dinner->dinner_taken @endphp
                        @elseif ($Dinner->conferenceRegistration && $Dinner->conferenceRegistration->registrant_type == 2)
                            @php $SpeakerDinnerDay2=$SpeakerDinnerDay2 + $Dinner->dinner_taken @endphp
                        @else
                            @php $AttendeeDinnerDay2= $AttendeeDinnerDay2 + $Dinner->dinner_taken @endphp
                        @endif
                    @endforeach
                    @foreach ($day2DinnerSponsor as $sponsorLunch)
                        @php
                            $sponsorDinnerDay2 = $sponsorDinnerDay2 + $sponsorLunch->dinner_taken;
                        @endphp
                    @endforeach
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Dinner</h5>
                                    <ul>
                                        @php
                                            // Calculate total dinner count
                                            $totalDinnerDay2 =
                                                $OrganizerDinnerDay2 +
                                                $InternationalDinnerDay2 +
                                                $SpeakerDinnerDay2 +
                                                $AttendeeDinnerDay2 +
                                                $sponsorDinnerDay2;
                                        @endphp

                                        <li>Organizer:{{ $OrganizerDinnerDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day2', 'organizer', 'dinner']) }}">View</a></span>
                                        </li>
                                        <li>International:{{ $InternationalDinnerDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day2', 'international', 'dinner']) }}">View</a></span>
                                        </li>
                                        <li>Speaker:{{ $SpeakerDinnerDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day2', 'speaker', 'dinner']) }}">View</a></span>
                                        </li>
                                        <li>Delegate:{{ $AttendeeDinnerDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesDailyMeal', ['day2', 'delegate', 'dinner']) }}">View</a></span>
                                        </li>
                                        <li>Sponsor:{{ $sponsorDinnerDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewSponsorDailyMeal', ['day2', 'dinner']) }}">View</a></span>
                                        </li>

                                        {{-- @php
                                        $totalDinnerDay2 += $day2Dinner->total_dinners;
                                    @endphp --}}
                                    </ul>
                                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid #ccc;">
                                    <h4>Total: {{ $totalDinnerDay2 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Conference Kit</h5>
                                    <ul>
                                        @php
                                            $OrganizerKitDay2 = 0;
                                            $InternationalKitDay2 = 0;
                                            $SpeakerKitDay2 = 0;
                                            $AttendeeKitDay2 = 0;
                                        @endphp
                                        @foreach ($day2ConferenceKit as $kit)
                                            {{-- @dd($kit->conferenceRegistration->committeMember->isNotEmpty()) --}}

                                            @if (
                                                $kit->conferenceRegistration &&
                                                    $kit->conferenceRegistration->committeMember->isNotEmpty() &&
                                                    $kit->conferenceRegistration->user->userDetail->country_id == 125)
                                                @php $OrganizerKitDay2++ @endphp
                                            @elseif ($kit->conferenceRegistration && $kit->conferenceRegistration->user->userDetail->country_id != 125)
                                                @php $InternationalKitDay2++ @endphp
                                            @elseif ($kit->conferenceRegistration && $kit->conferenceRegistration->registrant_type == 2)
                                                @php $SpeakerKitDay2++ @endphp
                                            @else
                                                @php $AttendeeKitDay2++ @endphp
                                            @endif
                                        @endforeach
                                        @php
                                            // Calculate total attendance for Day 1
                                            $TotalKitDay2 =
                                                $OrganizerKitDay2 +
                                                $InternationalKitDay2 +
                                                $SpeakerKitDay2 +
                                                $AttendeeKitDay2;
                                        @endphp

                                        <li>Organizer:{{ $OrganizerKitDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesConferenceKit', ['day2', 'organizer']) }}">View</a></span>
                                        </li>
                                        <li>International:{{ $InternationalKitDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesConferenceKit', ['day2', 'international']) }}">View</a></span>
                                        </li>
                                        <li>Speaker/Faculty:{{ $SpeakerKitDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesConferenceKit', ['day2', 'speaker']) }}">View</a></span>
                                        </li>
                                        <li>Delegate:{{ $AttendeeKitDay2 }} |
                                            <span class="badge badge-success"><a
                                                    href="{{ route('viewMemberTypesConferenceKit', ['day2', 'delegate']) }}">View</a></span>
                                        </li>

                                        {{-- @php
                                        $totalDinnerDay2 += $day2Dinner->total_dinners;
                                    @endphp --}}
                                    </ul>
                                    <hr style="margin: 5px 0; border: 0; border-top: 1px solid #ccc;">
                                    <h4>Total: {{ $TotalKitDay2 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endif
        @if ($user->role == 1 || !empty($checkRegistrationCommittee))
            @if ($user->role == 1)
                <div class="breadcrumb">
                    <h4>Total Registrations</h4>
                </div>
                <div class="row">
                    @php
                        $totalRegistrants = count($registrants->unique('user_id')->where('verified_status', 1));
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Total Registrations</h5>
                                    <a href="#">
                                        <p class="lead text-primary text-24 mb-2">{{ $totalRegistrants }}</p>
                                    </a>
                                    <a href="{{ route('home.viewParticipants', 'total-registrants') }}"
                                        class="btn btn-primary btn-sm">View All</a>
                                    <a href="{{ route('home.viewAttendanceStatus') }}"
                                        class="btn btn-primary btn-sm mt-1">View Attendance Status</a>
                                    <a href="{{ route('home.viewSponsorAttendanceStatus') }}"
                                        class="btn btn-primary btn-sm mt-1">View Sponsor Attendance Status</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body">
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Total National Registrants</h5>
                                    @foreach ($totalNationalRegistrants as $nr_item)
                                        <p class="text-muted mt-2 mb-0">{{ $nr_item->type }}: {{ $nr_item->user_count }}
                                        </p>
                                    @endforeach
                                    <a href="{{ route('home.viewParticipants', 'national') }}"
                                        class="btn btn-primary btn-sm">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body">
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Total International Registrants</h5>
                                    @foreach ($totalInternationalRegistrants as $inr_item)
                                        <p class="text-muted mt-2 mb-0">{{ $inr_item->type }}:
                                            {{ $inr_item->user_count }}</p>
                                    @endforeach
                                    <a href="{{ route('home.viewParticipants', 'international') }}"
                                        class="btn btn-primary btn-sm">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Mens"></i>
                                <div style="margin-left: 6%;">
                                    <p class="text-muted mt-2 mb-0">Total Accompany Persons</p>
                                    @php
                                        $totalPersons = 0;
                                        foreach ($registrants->where('verified_status', 1) as $value) {
                                            $totalPersons += $value->total_attendee;
                                        }
                                        $totalAccompanyPersons = $totalPersons - $totalRegistrants;
                                    @endphp
                                    <a href="#">
                                        <p class="lead text-primary text-24 mb-2">{{ $totalAccompanyPersons }}</p>
                                    </a>
                                    <a href="{{ route('home.viewParticipants', 'accompany-persons') }}"
                                        class="btn btn-primary btn-sm">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="separator-breadcrumb border-top"></div>
            @endif
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <h4 class="w-50 float-left card-title mb-3">Recent accepted participants</h4>
                            <i class="nav-icon i-Bell1"></i>
                            <sup>
                                <sup
                                    class="badge badge-danger px-2 py-2">{{ count($registrants->where('verified_status', 1)) }}</sup>
                            </sup>
                            <a href="{{ route('home.viewParticipants', 'accepted') }}" class="float-right"><button
                                    class="btn btn-sm btn-primary" type="button">View All</button></a>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registrants->where('verified_status', 1)->take(5) as $a_item)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $a_item->user->fullName($a_item, 'user') }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-success">{{ $a_item->registrant_type == 1 ? 'Attendee' : 'Presenter' }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <h4 class="w-50 float-left card-title mb-3">Recent unverified participants</h4>
                            <i class="nav-icon i-Bell1"></i>
                            <sup>
                                <sup
                                    class="badge badge-danger px-2 py-2">{{ count($registrants->where('verified_status', 0)) }}</sup>
                            </sup>
                            <a href="{{ route('home.viewParticipants', 'unverified') }}" class="float-right"><button
                                    class="btn btn-sm btn-primary" type="button">View All</button></a>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($registrants->where('verified_status', 0)->take(5) as $u_item)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $u_item->user->fullName($u_item, 'user') }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-warning">{{ $u_item->registrant_type == 1 ? 'Attendee' : 'Presenter' }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($workshops->isNotEmpty())
                <div class="separator-breadcrumb border-top"></div>
                <div class="breadcrumb">
                    <h4>Workshops</h4>
                </div>
            @endif
            <div class="row">
                @foreach ($workshops as $w_item)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-Conference"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">{{ $w_item->title }}</h5>
                                    @php
                                        $totalQuota = $w_item->no_of_participants;
                                        $appliedQuota = $w_item->registrations->count();
                                    @endphp
                                    <p class="text-muted mt-2 mb-0">Total Quota: {{ $totalQuota }}</p>
                                    <p class="text-muted mt-2 mb-0">Applied Quota: {{ $appliedQuota }}</p>
                                    <p class="text-muted mt-2 mb-0">Remaining Quota:
                                        {{ $totalQuota - $appliedQuota < 0 ? 0 : $totalQuota - $appliedQuota }}</p>
                                    @php
                                        $withConferenceCount = DB::table('conference_registrations')
                                            ->where('conference_id', $conference->id)
                                            ->whereIn('user_id', $w_item->registrations->pluck('user_id')->toArray())
                                            ->get()
                                            ->count();

                                    @endphp
                                    <p class="text-muted mt-2 mb-0">With Conference: {{ $withConferenceCount }}</p>
                                    <p class="text-muted mt-2 mb-0">Without Conference:
                                        {{ $appliedQuota - $withConferenceCount }}</p>
                                    @php
                                        $verified = $w_item->registrations->where('verified_status', 1)->count();
                                    @endphp
                                    <p class="text-muted mt-2 mb-0">Verified Registrants: {{ $verified }}</p>
                                    <p class="text-muted mt-2 mb-0">Unverified Registrants:
                                        {{ $appliedQuota - $verified }}</p>
                                    <a href="{{ route('home.workshopRegistrations', $w_item->slug) }}"
                                        class="btn btn-primary btn-sm">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($user->role == 1)
                <div class="separator-breadcrumb border-top"></div>
                <div class="breadcrumb">
                    <h4>Submissions</h4>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-File"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Poster</h5>
                                    <p class="text-muted mt-2 mb-0">Total:
                                        {{ $submissions->where('presentation_type', 1)->count() }}</p>
                                    <a href="{{ route('home.submission', 1) }}" class="btn btn-primary btn-sm">View
                                        All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-File"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Oral(Abstract)</h5>
                                    <p class="text-muted mt-2 mb-0">Total:
                                        {{ $submissions->where('presentation_type', 2)->count() }}</p>
                                    <a href="{{ route('home.submission', 2) }}" class="btn btn-primary btn-sm">View
                                        All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            @php
                $checkConferenceRegistration = DB::table('conference_registrations')
                    ->where(['conference_id' => $conference->id, 'user_id' => $user->id, 'status' => 1])
                    ->first();
            @endphp
            @if (empty($checkConferenceRegistration))
                <div class="modal fade" id="openModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="modalContent">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalCenterTitle">Confirmation For Conference
                                    Registration.</h3>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <h5><b>Conference Registration Status:</b> <span class="text-danger">Not Registered</span>
                                </h5>
                                <a href="{{ route('conference-registration.create') }}">Click here to register into
                                    conference</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="breadcrumb">
                <h1>Dashboard</h1>
            </div>
            {{-- <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-card alert-warning text-center" role="alert"><span id="registrationInfo" class="text-danger" style="font-size: 20px">Conference Registration Has Been Closed.</span>
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
            </div> --}}
            <div class="separator-breadcrumb border-top"></div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body text-center">
                            <div class="mx-auto text-success"><i class="i-Checked-User text-success"></i>
                                <p class="text-24 mt-2 mb-0">{{ $user->fullName($user) }}</p>
                                <p class="text-24 mt-2 mb-0">Welcome To Dashboard.</p>
                                @if (!empty($user->conferenceRegistration) && $user->conferenceRegistration->registrant_type == 1)
                                    <a href="{{ route('conference-registration.convertToSpeaker') }}"
                                        class="btn btn-primary mt-2">Convert To Speaker?</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#openModal').modal('show');
        });
    </script>
@endsection
