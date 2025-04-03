<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | @yield('title') </title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
    <link href="{{ asset('backend') }}/dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link href="{{ asset('backend') }}/dist-assets/css/plugins/perfect-scrollbar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('backend') }}/dist-assets/css/plugins/toastr.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/dist-assets/css/plugins/datatables.min.css" />
    <link rel="stylesheet" href="{{ asset('backend') }}/dist-assets/css/plugins/datatables.min.css" />
    <link rel="stylesheet" href="{{ asset('plugin-links') }}/jquery-timepicker-1.14.0/jquery.timepicker.min.css" />
    <link rel="stylesheet" href="{{ asset('plugin-links') }}/select2-4.1.0-rc.0/dist/css/select2.min.css" />
    <style>
        label {
            font-weight: bold;
        }

        .nav-item.disabled {
            pointer-events: none;
            opacity: 0.5;
            /* Optionally reduce opacity to visually indicate it's disabled */
            /* Other styles for the disabled state */
        }
    </style>

    @yield('styles')
</head>

<body class="text-left">

    @php
        $conferenceDetail = session()->get('conferenceDetail');
        $latestConference = App\Models\Conference::latestConference();
        $authUser = auth()->user();
    @endphp
    <div class="app-admin-wrap layout-sidebar-large">
        <div class="main-header">
            <div class="logo">
                @if (!empty($conferenceDetail))
                    <a href="{{ route('conference.openConferencePortal', $conferenceDetail->slug) }}"><img
                            src="{{ asset('backend') }}/dist-assets/images/logo.png" alt=""></a>
                @else
                    <a href="{{ route('home') }}"><img src="{{ asset('backend') }}/dist-assets/images/logo.png"
                            alt=""></a>
                @endif
            </div>
            <div class="menu-toggle">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div style="margin: auto">
                @if (!empty($conferenceDetail))
                    <h4 class="text-success mx-auto">Conference: {{ $conferenceDetail->conference_theme }}</h4>
                @endif
            </div>
            @if (
                $authUser->role == 1 &&
                    !empty($latestConference) &&
                    !empty($conferenceDetail) &&
                    $conferenceDetail->id != $latestConference->id)
                <a href="{{ route('home', $latestConference->slug) }}" class="btn btn-danger btn-sm"> Go Back To Latest
                    Conference</a>
            @endif
            <div class="header-part-right">
                <!-- Full screen toggle -->
                <i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen></i>
                <!-- Grid menu Dropdown -->
                <!-- User avatar dropdown -->
                <div class="dropdown">
                    <div class="user col align-self-end">
                        <img src="{{ asset('backend') }}/dist-assets/images/logout.png" id="userDropdown"
                            alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-header">
                                <i class="i-Lock-User mr-1"></i> {{ $authUser->fullName($authUser) }}
                            </div>
                            @if ($authUser->role == 2)
                                <div class="dropdown-header">
                                    <i class="i-Lock-User mr-1"></i> <a href="{{ route('home.editProfile') }}">Edit
                                        Profile</a>
                                </div>
                            @endif

                            <div class="header-part-right">
                                <!-- Full screen toggle-->
                                @guest
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="side-content-wrap">
            <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="navigation-left">
                    @if ($authUser->role == 1)
                        {{-- <li class="nav-item {{empty($latestConference) ? 'disabled' : ''}}" data-item=""><a class="nav-item-hold" href="{{ route('admin.index') }}"><i
                                    class="nav-icon i-Mens"></i><span class="nav-text">Admins</span></a>
                            <div class="triangle"></div>
                        </li> --}}
                        <li class="nav-item" data-item="conference"><a class="nav-item-hold" href="#"><i
                                    class="nav-icon i-Conference"></i><span class="nav-text">Conference</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item="member"><a
                                class="nav-item-hold" href="#"><i class="nav-icon i-Mens"></i><span
                                    class="nav-text">Member Type</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item="submission"><a
                                class="nav-item-hold" href="#"><i class="nav-icon i-File"></i><span
                                    class="nav-text">Submission</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item="workshop"><a
                                class="nav-item-hold" href="{{ route('workshop.index') }}"><i
                                    class="nav-icon i-Conference"></i><span class="nav-text">Workshops</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item=""><a
                                class="nav-item-hold" href="{{ route('admin.signedUpUsersList') }}"><i
                                    class="nav-icon i-Mens"></i><span class="nav-text">Signed Up Users</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item="schedule"><a
                                class="nav-item-hold" href="#"><i class="nav-icon i-Time-Window"></i><span
                                    class="nav-text">Schedule Plan</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item="committees">
                            <a class="nav-item-hold" href=""><i class="nav-icon i-Green-House"></i><span
                                    class="nav-text">Committee</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item="sponsors"><a
                                class="nav-item-hold" href="#"><i class="nav-icon i-Dollar"></i><span
                                    class="nav-text">Sponsors</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item=""><a
                                class="nav-item-hold" href="{{ route('hotel.index') }}"><i
                                    class="nav-icon i-Hotel"></i><span class="nav-text">Accommodation</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item=""><a
                                class="nav-item-hold" href="{{ route('name-prefix.index') }}"><i
                                    class="nav-icon i-Mens"></i><span class="nav-text">Name Prefix</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item=""><a
                                class="nav-item-hold" href="{{ route('faq.index') }}"><i
                                    class="nav-icon i-Note"></i><span class="nav-text">FAQ's</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item=""><a
                                class="nav-item-hold" href="{{ route('notice.index') }}"><i
                                    class="nav-icon i-File"></i><span class="nav-text">News/Notices</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"
                            data-item="certificates"><a class="nav-item-hold" href=""><i
                                    class="nav-icon i-File"></i><span class="nav-text">Certificate Settings</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"><a
                                class="nav-item-hold" href="{{ route('download.index') }}"><i
                                    class="nav-icon i-Download"></i><span class="nav-text">Download</span></a>
                            <div class="triangle"></div>
                        </li>
                        {{-- <li class="nav-item {{empty($latestConference) ? 'disabled' : ''}}"><a class="nav-item-hold" href="{{route('content.index')}}"><i
                                    class="nav-icon i-Note"></i><span class="nav-text">Content</span></a>
                            <div class="triangle"></div>
                        </li> --}}
                        @php
                            $conferences = DB::table('conferences')->first();
                        @endphp
                    @endif
                    @if ($authUser->role == 1 && $authUser->id == 2)
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item="schedule"><a
                                class="nav-item-hold" href="#"><i class="nav-icon i-Time-Window"></i><span
                                    class="nav-text">Schedule Plan</span></a>
                            <div class="triangle"></div>
                        </li>
                    @endif
                    @if ($authUser->role == 2)
                        @php
                            $registrationCommittee = DB::table('committees')
                                ->where('committee_name', 'Registration Committee')
                                ->first();

                            $checkRegistrationCommittee = DB::table('committee_members')
                                ->where([
                                    'conference_id' => $latestConference->id,
                                    'committee_id' => $registrationCommittee->id,
                                    'user_id' => $authUser->id,
                                    'status' => 1,
                                ])
                                ->first();
                            $scientificCommittee = DB::table('committees')
                                ->where('committee_name', 'Scientific Committee')
                                ->first();
                            $checkScientificCommitee = DB::table('committee_members')
                                ->where([
                                    'conference_id' => $latestConference->id,
                                    'committee_id' => $scientificCommittee->id,
                                    'user_id' => $authUser->id,
                                    'status' => 1,
                                ])
                                ->first();
                        @endphp
                        @if (!empty($checkRegistrationCommittee))
                            @php
                                $checkRegistrationChairperson = DB::table('designations')
                                    ->whereId($checkRegistrationCommittee->designation_id)
                                    ->first();
                            @endphp
                            @if ($checkRegistrationChairperson->designation == 'Registration Committee Chairperson')
                                <li class="nav-item" data-item="conference"><a class="nav-item-hold"
                                        href="#"><i class="nav-icon i-Conference"></i><span
                                            class="nav-text">Conference</span></a>
                                    <div class="triangle"></div>
                                </li>
                            @endif
                        @endif
                        @if (!empty($latestConference))
                            @php
                                $checkRegistration = DB::table('conference_registrations')
                                    ->where([
                                        'user_id' => auth()->user()->id,
                                        'conference_id' => $latestConference->id,
                                        'status' => 1,
                                    ])
                                    ->first();
                            @endphp
                        @endif
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item=""><a
                                class="nav-item-hold"
                                href="{{ empty($checkRegistration) ? route('conference-registration.create') : route('conference-registration.index') }}"><i
                                    class="nav-icon i-Receipt"></i><span class="nav-text">Conference
                                    Registration</span></a>
                            <div class="triangle"></div>
                        </li>
                        @php
                            $disabled = '';
                            if (empty($latestConference)) {
                                $disabled = 'disabled';
                            }
                            // $country = DB::table('countries')->whereId($authUser->userDetail->country_id)->first();
                            // if ($country->country_name == 'Nepal') {
                            //     if (empty($checkRegistration)) {
                            //         $disabled = 'disabled';
                            //     } elseif (!empty($checkRegistration) && $checkRegistration->registrant_type == 1) {
                            //         $disabled = 'disabled';
                            //     }
                            // }
                        @endphp
                        <li class="nav-item {{ $disabled }}" data-item=""><a class="nav-item-hold"
                                href="{{ route('submission.index') }}"><i class="nav-icon i-File"></i><span
                                    class="nav-text">Submission</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item=""><a
                                class="nav-item-hold" href="{{ route('workshop-registration.index') }}"><i
                                    class="nav-icon i-Receipt"></i><span class="nav-text">Workshop
                                    Registrations</span></a>
                            <div class="triangle"></div>
                        </li>
                        <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}" data-item=""><a
                                class="nav-item-hold" href="{{ route('front.accommodation') }}" target="_blank"><i
                                    class="nav-icon i-Hotel"></i><span class="nav-text">Accommodation</span></a>
                            <div class="triangle"></div>
                        </li>
                        @if (!empty($checkScientificCommitee))
                            @php
                                $checkScientificChairperson = DB::table('designations')
                                    ->whereId($checkScientificCommitee->designation_id)
                                    ->first();
                            @endphp
                            @if ($checkScientificChairperson->designation == 'Scientific Committee Chairperson')
                                <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"
                                    data-item="schedule"><a class="nav-item-hold" href="#"><i
                                            class="nav-icon i-Time-Window"></i><span class="nav-text">Schedule
                                            Plan</span></a>
                                    <div class="triangle"></div>
                                </li>
                            @endif
                            {{-- <li class="nav-item {{empty($latestConference) ? 'disabled' : ''}}" data-item=""><a class="nav-item-hold" href="{{route('admin.signedUpUsersList')}}"><i
                                        class="nav-icon i-Mens"></i><span class="nav-text">Signed Up Users</span></a>
                                <div class="triangle"></div>
                            </li>
                            <li class="nav-item {{empty($latestConference) ? 'disabled' : ''}}" data-item="workshop"><a class="nav-item-hold" href="{{ route('workshop.index') }}"><i
                                        class="nav-icon i-Conference"></i><span class="nav-text">Workshops</span></a>
                                <div class="triangle"></div>
                            </li> --}}
                        @endif
                        {{-- <li class="nav-item {{empty($latestConference) ? 'disabled' : ''}}" data-item=""><a class="nav-item-hold" href="{{ route('workshop.index') }}"><i
                                    class="nav-icon i-Conference"></i><span class="nav-text">Apply Workshop</span></a>
                            <div class="triangle"></div>
                        </li> --}}
                    @endif
                </ul>
            </div>
            <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
                <ul class="childNav" data-parent="conference">
                    @if ($authUser->role == 1)
                        <li class="nav-item"><a href="{{ route('conference.index') }}"><i
                                    class="nav-icon i-Conference"></i><span class="item-name">Conference</span></a>
                        </li>
                    @endif
                    <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"><a
                            href="{{ route('conferenceRegistration.participants', 'attendees') }}"><i
                                class="nav-icon i-Mens"></i><span class="item-name">Attendees</span></a></li>
                    <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"><a
                            href="{{ route('conferenceRegistration.participants', 'speakers') }}"><i
                                class="nav-icon i-Mens"></i><span class="item-name">Speakers</span></a></li>
                    <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"><a
                            href="{{ route('conferenceRegistration.byAdmin') }}"><i
                                class="nav-icon i-Receipt"></i><span
                                class="item-name">Registration/Invitation</span></a></li>
                    <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"><a
                            href="{{ route('conferenceRegistration.participants', 'invited-attendees') }}"><i
                                class="nav-icon i-Mens"></i><span class="item-name">Invited Attendees</span></a></li>
                    <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"><a
                            href="{{ route('conferenceRegistration.participants', 'invited-speakers') }}"><i
                                class="nav-icon i-Mens"></i><span class="item-name">Invited Speakers</span></a></li>
                    <li class="nav-item {{ empty($latestConference) ? 'disabled' : '' }}"><a
                            href="{{ route('conferenceRegistration.registerExceptionalCase') }}"><i
                                class="nav-icon i-Receipt"></i><span class="item-name">Register in Exceptional
                                Case</span></a></li>
                    {{-- <li class="nav-item {{empty($latestConference) ? 'disabled' : ''}}"><a href="{{ route('sponsor-invitation.index') }}"><i
                                class="nav-icon i-Dollar"></i><span class="item-name">Sponsors Invitation</span></a></li> --}}
                </ul>
                <ul class="childNav" data-parent="member">
                    <li class="nav-item"><a href="{{ route('member-type.index') }}"><i
                                class="nav-icon i-Type-Pass"></i><span class="item-name">Type</span></a></li>
                    <li class="nav-item"><a href="{{ route('member-type-price.index') }}"><i
                                class="nav-icon i-Dollar"></i><span class="item-name">Price</span></a></li>
                </ul>
                <ul class="childNav" data-parent="submission">
                    <li class="nav-item"><a href="{{ route('conference.submissionSetting') }}"><i
                                class="nav-icon i-Check"></i><span class="item-name">Submission Setting</span></a>
                    </li>
                    <li class="nav-item"><a href="{{ route('submission.index') }}"><i
                                class="nav-icon i-File"></i><span class="item-name">Submission</span></a></li>
                </ul>
                <ul class="childNav" data-parent="workshop">
                    <li class="nav-item"><a href="{{ route('workshop.index') }}"><i
                                class="nav-icon i-Conference"></i><span class="item-name">Workshops</span></a></li>
                    <li class="nav-item"><a href="{{ route('workshop-registration.byAdmin') }}"><i
                                class="nav-icon i-Receipt"></i><span class="item-name">Register For New
                                Users</span></a></li>
                    <li class="nav-item"><a href="{{ route('workshop-registration.forSignedUpUsers') }}"><i
                                class="nav-icon i-Receipt"></i><span class="item-name">Register For Signed Up
                                Users</span></a></li>
                </ul>
                <ul class="childNav" data-parent="workshopForUser">
                    <li class="nav-item"><a href="{{ route('workshop-registration.index') }}"><i
                                class="nav-icon i-Receipt"></i><span class="item-name">Workshop
                                Registration</span></a></li>
                    <li class="nav-item"><a href="{{ route('workshop.index') }}"><i
                                class="nav-icon i-Conference"></i><span class="item-name">Organize Workshop</span></a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="schedule">
                    <li class="nav-item"><a href="{{ route('scientific-session.index') }}"><i
                                class="nav-icon i-Timer1"></i><span class="item-name">Scientific Session</span></a>
                    </li>
                    {{-- <li class="nav-item"><a href="{{ route('schedule.index') }}"><i
                                class="nav-icon i-Timer1"></i><span class="item-name">Schedule</span></a>
                    </li> --}}
                    <li class="nav-item"><a href="{{ route('hall.index') }}"><i
                                class="nav-icon i-Green-House"></i><span class="item-name">Halls</span></a>
                    </li>
                    <li class="nav-item"><a href="{{ route('scientific-session-category.index') }}"><i
                                class="nav-icon i-Green-House"></i><span class="item-name">Category</span></a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="sponsors">
                    <li class="nav-item"><a href="{{ route('sponsor-category.index') }}"><i
                                class="nav-icon i-Network"></i><span class="item-name">Category</span></a></li>
                    <li class="nav-item"><a href="{{ route('sponsor.index') }}"><i
                                class="nav-icon i-Dollar"></i><span class="item-name">Sponsors</span></a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="committees">
                    <li class="nav-item"><a href="{{ route('committee.index') }}"><i
                                class="nav-icon i-Green-House"></i><span class="item-name">Committee</span></a></li>
                    <li class="nav-item"><a href="{{ route('designation.index') }}"><i
                                class="nav-icon i-Mens"></i><span class="item-name">Designations</span></a>
                    </li>
                </ul>
                <ul class="childNav" data-parent="certificates">
                    {{-- <li class="nav-item"><a href="{{ route('background.index') }}"><i
                                class="nav-icon i-File"></i><span class="item-name">Background Theme</span></a></li> --}}
                    <li class="nav-item"><a href="{{ route('signature.index') }}"><i
                                class="nav-icon i-File"></i><span class="item-name">Signatures</span></a>
                    </li>
                    {{-- <li class="nav-item"><a href="{{ route('certificate.index') }}"><i
                                class="nav-icon i-File"></i><span class="item-name">Certificates</span></a>
                    </li> --}}
                </ul>
            </div>
            <div class="sidebar-overlay"></div>
        </div>
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <!-- ============ Body content start ============= -->
            @yield('content')

            <!-- Footer Start -->
            <div class="flex-grow-1"></div>
            <div class="app-footer">
                <div class="footer-bottom border-top pt-3 d-flex flex-column flex-sm-row align-items-center">
                    <span class="flex-grow-1"></span>
                    <div class="d-flex align-items-center">
                        <img class="logo" src="{{ asset('backend') }}/dist-assets/images/logo.png" alt="">
                        <div>
                            <p class="m-0">&copy; <?php echo date('Y'); ?> {{ config('app.name') }}</p>
                            <p class="m-0">All rights reserved</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- fotter end -->
        </div>
    </div><!-- ============ Search UI Start ============= -->
    <div class="search-ui">
        <div class="search-header">
            <img src="{{ asset('backend') }}/dist-assets/images/logo.png" alt="" class="logo">
            <button class="search-close btn btn-icon bg-transparent float-right mt-2">
                <i class="i-Close-Window text-22 text-muted"></i>
            </button>
        </div>
        <input type="text" placeholder="Type here" class="search-input" autofocus>
        <div class="search-title">
            <span class="text-muted">Search results</span>
        </div>
    </div>
    <!-- ============ Search UI End ============= -->
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/sidebar.large.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/echarts.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/echart.options.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/datatables.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/dashboard.v4.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/widgets-statistics.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/apexcharts.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/apexSparklineChart.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/customizer.script.min.js"></script>

    <script src="{{ asset('backend') }}/dist-assets/js/plugins/datatables.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/datatables.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/toastr.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/toastr.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/tagging.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/tagging.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/sweetalert2.js"></script>
    <script src="{{ asset('plugin-links') }}/jquery-timepicker-1.14.0/jquery.timepicker.min.js"></script>

    <script src="{{ asset('plugin-links') }}/jquery.form.min.js"></script>
    <script src="{{ asset('plugin-links') }}/select2-4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $("#image").change(function() {
            let reader = new FileReader();

            $("#imgPreview").html('');

            reader.onload = function(e) {
                let fileExtension = $("#image").val().split('.').pop().toLowerCase();

                if (fileExtension === 'pdf') {
                    $("#imgPreview").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/pdf.png') }}" class="img-fluid" /></div>'
                    );
                } else if (fileExtension === 'ppt' || fileExtension === 'pptx' || fileExtension === 'pptm') {
                    $("#imgPreview").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/ppt.png') }}" class="img-fluid" /></div>'
                    );
                } else if (fileExtension === 'doc' || fileExtension === 'docx') {
                    $("#imgPreview").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/word.png') }}" class="img-fluid" /></div>'
                    );
                } else {
                    $("#imgPreview").append('<div class="col-3 mt-2"><img src="' + e.target.result +
                        '" class="img-fluid" /></div>');
                }
            };

            reader.readAsDataURL(this.files[0]);
        });

        $("#image2").change(function() {
            let reader = new FileReader();

            $("#imgPreview2").html('');

            reader.onload = function(e) {
                let fileExtension2 = $("#image2").val().split('.').pop().toLowerCase();

                if (fileExtension2 === 'pdf') {
                    $("#imgPreview2").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/pdf.png') }}" class="img-fluid" /></div>'
                    );
                } else if (fileExtension2 === 'ppt' || fileExtension2 === 'pptx' || fileExtension2 === 'pptm') {
                    $("#imgPreview2").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/ppt.png') }}" class="img-fluid" /></div>'
                    );
                } else if (fileExtension2 === 'doc' || fileExtension2 === 'docx') {
                    $("#imgPreview2").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/word.png') }}" class="img-fluid" /></div>'
                    );
                } else {
                    $("#imgPreview2").append('<div class="col-3 mt-2"><img src="' + e.target.result +
                        '" class="img-fluid" /></div>');
                }
            };

            reader.readAsDataURL(this.files[0]);
        });

        $("#image3").change(function() {
            let reader = new FileReader();

            $("#imgPreview3").html('');

            reader.onload = function(e) {
                let fileExtension = $("#image3").val().split('.').pop().toLowerCase();

                if (fileExtension === 'pdf') {
                    $("#imgPreview3").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/pdf.png') }}" class="img-fluid" /></div>'
                    );
                } else if (fileExtension === 'ppt' || fileExtension === 'pptx' || fileExtension === 'pptm') {
                    $("#imgPreview3").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/ppt.png') }}" class="img-fluid" /></div>'
                    );
                } else if (fileExtension === 'doc' || fileExtension === 'docx') {
                    $("#imgPreview3").append(
                        '<div class="col-3 mt-2"><img src="{{ asset('default-images/word.png') }}" class="img-fluid" /></div>'
                    );
                } else {
                    $("#imgPreview3").append('<div class="col-3 mt-2"><img src="' + e.target.result +
                        '" class="img-fluid" /></div>');
                }
            };

            reader.readAsDataURL(this.files[0]);
        });

        $('.delete').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert it.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parent('form').submit();
                }
            })
        });

        $("#images").change(function(e) {
            e.preventDefault();
            let files = e.target.files

            $("#imagesPreview").html('')

            for (let file of files) {
                $("#imagesPreview").append(
                    `<div class="col-1 mt-2"><img src="${URL.createObjectURL(file)}" class="img-fluid" /></div>`
                );
            }
        });

        $('.imgDelete').click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure to delete this item?',
                text: "You won't be able to revert it.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = $(this).attr('href');
                }
            })
        });

        $('.rejectApplicant').click(function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to reject this application?')) {
                location.href = $(this).attr('href');
            }
        });

        $('.approveApplicant').click(function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to approve this application?')) {
                location.href = $(this).attr('href');
            }
        });

        // $('.multipleSelect').({
        //     placeholder: "-- Select --",
        //     allowClear: true
        // });
    </script>

    @if (Session::has('status'))
        <script>
            toastr.success("{!! Session::get('status') !!}");
        </script>
    @endif
    @if (Session::has('delete'))
        <script>
            toastr.error("{!! Session::get('delete') !!}");
        </script>
    @endif

    <script src="{{ asset('plugin-links') }}/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: '{{ route('ckeditor.fileUpload', ['_token' => csrf_token()]) }}',
            filebrowserUploadMethod: "form"
        });
    </script>

    @yield('scripts')

</body>

</html>
