<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Profile</title>
    <link href="{{ asset('backend') }}/dist-assets/css/themes/lite-purple.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('backend') }}/dist-assets/css/plugins/toastr.css" />
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/plugins/swiper.min.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/plugins/magnific-popup.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/plugins/metismenu.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/vendor/bootstrap.min.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/plugins/fontawesome.min.css" as="style">
    <link rel="stylesheet preload" href="{{ asset('frontend') }}/assets/css/style.css" as="style">

    <!-- jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="row">
                <div class="col-md-12">
                    @if (auth()->user() && auth()->user()->id == 2)

                        <div class="card card-profile-1 mb-4">
                            <div class="card-body text-center">

                                <div class="avatar box-shadow-2 mb-3"><img
                                        src="{{ asset('default-images/avatar.png') }}" alt="" />
                                </div>
                                <h5 class="m-0">{{ $participant->user->fullName($participant, 'user') }}</h5>
                                <p class="mt-0">{{ $participant->user->userDetail->affiliation }}</p>
                                <p class="mt-0">{{ $participant->registration_id }}</p>
                                <p class="mt-0">Conference Attendance</p>
                                @php
                                    $checkAttendance = $participant
                                        ->attendances()
                                        ->where(['conference_registration_id' => $participant->id, 'status' => 1])
                                        ->whereDate('created_at', date('Y-m-d'))
                                        ->first();
                                @endphp
                                @if (empty($checkAttendance))
                                    <a href="#" id="takeAttendance" data-id="{{ $participant->id }}"><button
                                            class="btn btn-primary btn-rounded">Take Attendance</button></a>
                                @else
                                    <div>
                                        <span class="badge badge-warning p-3" style="font-size: 100%">Attendance
                                            Done</span>
                                    </div>
                                    <div>
                                        @if (empty($participant->conferenceRegistrationKit))
                                            <a href="#" id="takeConferenceKit"
                                                data-id="{{ $participant->id }}"><button
                                                    class="btn btn-primary btn-rounded mt-3">Take Conference
                                                    Kit</button></a>
                                        @else
                                            <span class="badge badge-warning p-3 mt-3"
                                                style="font-size: 100%">Conference Kit
                                                Taken</span>
                                        @endif
                                    </div>
                                    <br>
                                    @php
                                        $totalLunchRemaining = $participant->total_attendee;
                                        $totalDinnerRemaining = $participant->total_attendee;
                                        $checkMeal = $participant
                                            ->meals()
                                            ->where(['conference_registration_id' => $participant->id])
                                            ->whereDate('created_at', date('Y-m-d'))
                                            ->first();
                                        if (!empty($checkMeal)) {
                                            $totalLunchRemaining =
                                                $participant->total_attendee - $checkMeal->lunch_taken;
                                            $totalDinnerRemaining =
                                                $participant->total_attendee - $checkMeal->dinner_taken;
                                        }
                                    @endphp
                                    <h5>Total Lunch Remaining: <span
                                            style="color: red">{{ $totalLunchRemaining }}</span>
                                        -------&&&&------- Total Dinner Remaining: <span
                                            style="color: red">{{ $totalDinnerRemaining }}</span></h5>
                                    <hr>
                                    <div>
                                        @if (date('H:i') < '16:00')
                                            @if ($totalLunchRemaining > 0)
                                                <a href="#" class="takeMeal"
                                                    data-id="{{ $participant->id }}"><button
                                                        class="btn btn-primary btn-rounded">Take Lunch</button></a>
                                            @else
                                                <span class="badge badge-warning p-3" style="font-size: 100%">Lunch
                                                    Completed</span>
                                            @endif
                                        @else
                                            @if ($totalDinnerRemaining > 0)
                                                <a href="#" class="takeMeal"
                                                    data-id="{{ $participant->id }}"><button
                                                        class="btn btn-primary btn-rounded">Take Dinner</button></a>
                                            @else
                                                <span class="badge badge-warning p-3" style="font-size: 100%">Dinner
                                                    Completed</span>
                                            @endif
                                        @endif
                                    </div>
                                @endif

                            </div>
                        </div>
                    @else
                        <!-- Search Button -->
                        <div class="d-flex justify-content-center">
                            <button
                                class="btn btn-outline-success rounded-pill shadow-sm w-auto px-5 py-3 fs-5 d-flex align-items-center gap-2"
                                data-bs-toggle="modal" data-bs-target="#searchModal" style="width: fit-content;">
                                <i class="fas fa-search"></i> Search Scientific Sessions
                            </button>
                        </div>

                        <!-- Search Modal -->
                        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header d-flex justify-content-center position-relative">
                                        <h6 class="modal-title text-center w-100 fw-bold" id="searchModalLabel">
                                            Search Scientific Sessions</h6>
                                        <button type="button" class="btn-close position-absolute end-0 me-3"
                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <!-- Search Input -->
                                            <input type="text" id="searchInput"
                                                class="form-control border border-black rounded-6 shadow-sm"
                                                placeholder="Enter topic or speaker name to search...">
                                        </div>

                                        <!-- Search Results -->
                                        <div id="searchResults" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="rts-section-gapBottom rts-blog-area-one">
                            <div class="container">
                                <div class="row g-48 mt--0 justify-content-sm-center justify-content-md-start">
                                    <div class="block_1">
                                        <div class="schedule-warp">
                                            @foreach ($dates as $dateIndex => $date)
                                                <div class="col-lg-12">
                                                    <div class="accordion-faq-area-border-bottom-style style-four">
                                                        <div class="accordion"
                                                            id="accordionExample-{{ $dateIndex }}">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header"
                                                                    id="heading-{{ $dateIndex }}">
                                                                    <button class="accordion-button" type="button"
                                                                        data-bs-toggle="collapse"
                                                                        data-bs-target="#collapse-{{ $dateIndex }}"
                                                                        aria-expanded="false"
                                                                        aria-controls="collapse-{{ $dateIndex }}">
                                                                        <div style="font-size:20px">
                                                                            Day {{ $loop->index + 1 }}
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="collapse-{{ $dateIndex }}"
                                                                    class="accordion-collapse collapse show"
                                                                    aria-labelledby="heading-{{ $dateIndex }}">
                                                                    <div class="accordion-body">

                                                                        <!-- Navigation Tabs -->
                                                                        <ul class="nav nav-tabs" role="tablist"
                                                                            id="hallTabs-{{ $dateIndex }}">
                                                                            @foreach ($halls as $hallIndex => $hall)
                                                                                <li class="nav-item">
                                                                                    <a class="nav-link @if ($loop->first) active @endif"
                                                                                        id="tab-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                                        data-bs-toggle="tab"
                                                                                        href="#content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                                        role="tab"
                                                                                        aria-controls="content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                                                        {{ $hall['hall_name'] }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>

                                                                        <div class="tab-content mt-3">
                                                                            @foreach ($halls as $hallIndex => $hall)
                                                                                <div class="tab-pane fade @if ($loop->first) show active @endif"
                                                                                    id="content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                                    role="tabpanel"
                                                                                    aria-labelledby="tab-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                                    <div class="text-start">
                                                                                        <a href="{{ route('front.export.pdf', ['hall_id' => $hall->id, 'date' => $date]) }}"
                                                                                            class="btn btn-lg btn-success"
                                                                                            target="_blank">
                                                                                            Export PDF for
                                                                                            {{ $hall->hall_name }}
                                                                                        </a>
                                                                                    </div>
                                                                                    @foreach ($hall->scientificSession->where('day', $date)->where('status', 1)->sortBy(fn($session) => \Carbon\Carbon::createFromFormat('h:ia', $session->time))->groupBy('category_id') as $category_id => $sessions)
                                                                                        <div class="accordion mt-3"
                                                                                            id="innerAccordion-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                                            <div
                                                                                                class="accordion-item collapsed">
                                                                                                <h2 class="accordion-header"
                                                                                                    id="category-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}">
                                                                                                    <button
                                                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                                                        type="button"
                                                                                                        data-bs-toggle="collapse"
                                                                                                        data-bs-target="#category-collapse-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}"
                                                                                                        aria-expanded="false"
                                                                                                        aria-controls="category-collapse-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}">
                                                                                                        <div
                                                                                                            class="title-text">
                                                                                                            {{ $sessions->first()->category->category_name }}

                                                                                                            @if ($sessions->first()->category->moderator)
                                                                                                                <br />Moderators:
                                                                                                                <small>
                                                                                                                    <i>{{ $sessions->first()->category->moderator }}</i>
                                                                                                                </small>
                                                                                                            @endif
                                                                                                            @if ($sessions->first()->category->co_chairperson)
                                                                                                                <br />Co-chairperson:
                                                                                                                <small>
                                                                                                                    <i>{{ $sessions->first()->category->co_chairperson }}</i>
                                                                                                                </small>
                                                                                                            @endif
                                                                                                            @if ($sessions->first()->category->chairperson)
                                                                                                                <br />Chairperson:
                                                                                                                <small>
                                                                                                                    <i>{{ $sessions->first()->category->chairperson }}</i>
                                                                                                                </small>
                                                                                                            @endif
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="d-flex align-items-center ms-auto">
                                                                                                            <span
                                                                                                                class="session-time">
                                                                                                                {{ $sessions->first()->category->duration }}
                                                                                                            </span>
                                                                                                            {{-- @dd($sessions->whereNotNull('topic')) --}}

                                                                                                            @if ($sessions->whereNotNull('topic')->isNotEmpty())
                                                                                                                <i
                                                                                                                    class="fa-solid fa-chevron-down"></i>
                                                                                                            @endif

                                                                                                        </div>
                                                                                                    </button>
                                                                                                    @if ($sessions->whereNull('topic')->isNotEmpty())
                                                                                                        @if ($session->day == \Carbon\Carbon::now()->toDateString())
                                                                                                            @if ($sessions->first()->poll->isNotEmpty())
                                                                                                                <div
                                                                                                                    class="d-flex justify-content-end">
                                                                                                                    <div
                                                                                                                        class="col-md-2">
                                                                                                                        <button
                                                                                                                            style="background-color: #ffc107; color: white;"
                                                                                                                            class="btn btn-xs btn-warning poll"
                                                                                                                            type="button"
                                                                                                                            data-toggle="modal"
                                                                                                                            data-target="#openModals"
                                                                                                                            data-id="{{ $sessions->first()->id }}">
                                                                                                                            Poll
                                                                                                                        </button>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            @endif
                                                                                                        @endif
                                                                                                    @endif
                                                                                                </h2>
                                                                                                <div id="category-collapse-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}"
                                                                                                    class="accordion-collapse collapse"
                                                                                                    aria-labelledby="category-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}"
                                                                                                    data-bs-parent="#innerAccordion-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                                                    <div
                                                                                                        class="accordion-body">
                                                                                                        @if ($hall->id == 6)
                                                                                                            @php
                                                                                                                $groupedSessions = $sessions
                                                                                                                    ->where(
                                                                                                                        'status',
                                                                                                                        1,
                                                                                                                    )
                                                                                                                    ->groupBy(
                                                                                                                        'screen',
                                                                                                                    )
                                                                                                                    ->map(
                                                                                                                        function (
                                                                                                                            $items,
                                                                                                                        ) {
                                                                                                                            return [
                                                                                                                                'moderator' => optional(
                                                                                                                                    $items->first(),
                                                                                                                                )
                                                                                                                                    ->moderator,
                                                                                                                                'sessions' => $items,
                                                                                                                            ];
                                                                                                                        },
                                                                                                                    );
                                                                                                            @endphp

                                                                                                            @foreach ($groupedSessions as $screen => $screenSessions)
                                                                                                                <div
                                                                                                                    class="screen-info">
                                                                                                                    <p>{{ $screen }}
                                                                                                                        @if ($screenSessions['moderator'])
                                                                                                                            -
                                                                                                                            <i>
                                                                                                                                {{ $screenSessions['moderator'] }}</i>
                                                                                                                        @endif
                                                                                                                    </p>
                                                                                                                    <ul>
                                                                                                                        @foreach ($screenSessions['sessions'] as $session)
                                                                                                                            <li>
                                                                                                                                <b>{{ $session->duration }}</b>
                                                                                                                                -
                                                                                                                                {{ $session->topic }}<br>
                                                                                                                                @if ($session->participants)
                                                                                                                                    <small>
                                                                                                                                        <i>{{ trim($session->participants, '"') }}</i>
                                                                                                                                    </small>
                                                                                                                                @endif
                                                                                                                                {{-- @dd($date) --}}
                                                                                                                                @if ($session->day == \Carbon\Carbon::now()->toDateString())
                                                                                                                                    @if ($session->poll->isNotEmpty())
                                                                                                                                        <div
                                                                                                                                            class="d-flex justify-content-end">
                                                                                                                                            <div
                                                                                                                                                class="col-md-2">
                                                                                                                                                <button
                                                                                                                                                    class="btn btn-xs btn-warning poll"
                                                                                                                                                    type="button"
                                                                                                                                                    data-toggle="modal"
                                                                                                                                                    data-target="#openModals"
                                                                                                                                                    data-id="{{ $session->id }}">
                                                                                                                                                    Poll
                                                                                                                                                </button>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    @endif
                                                                                                                                @endif
                                                                                                                            </li>
                                                                                                                        @endforeach
                                                                                                                    </ul>
                                                                                                                </div>
                                                                                                            @endforeach
                                                                                                        @else
                                                                                                            <ul>
                                                                                                                @foreach ($sessions->where('status', 1) as $session)
                                                                                                                    @if ($session->topic)
                                                                                                                        <li>
                                                                                                                            <b>{{ $session->duration }}</b>
                                                                                                                            -
                                                                                                                            {{ $session->topic }}</br>

                                                                                                                            @if ($session->participants)
                                                                                                                                <small>
                                                                                                                                    <i>{{ trim($session->participants, '"') }}</i>
                                                                                                                                </small>
                                                                                                                            @endif
                                                                                                                            @if ($session->day == \Carbon\Carbon::now()->toDateString())
                                                                                                                                @if ($session->poll->isNotEmpty())
                                                                                                                                    <div
                                                                                                                                        class="d-flex justify-content-end">
                                                                                                                                        <div
                                                                                                                                            class="col-md-2">
                                                                                                                                            <button
                                                                                                                                                style=""
                                                                                                                                                class="btn btn-xs btn-warning poll"
                                                                                                                                                type="button"
                                                                                                                                                data-toggle="modal"
                                                                                                                                                data-target="#openModals"
                                                                                                                                                data-id="{{ $session->id }}">
                                                                                                                                                Poll
                                                                                                                                            </button>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                @endif
                                                                                                                            @endif
                                                                                                                        </li>
                                                                                                                    @endif
                                                                                                                @endforeach
                                                                                                            </ul>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="openModals" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitless" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" id="modalContent">
                                            {{-- modal body goes here --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <style type="text/css">
        .accordion-item {}

        .title-text {
            font-size: 15px;
            text-align: left;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs.nav-link {
            border-radius: 10px !important;
            background: #FF6354;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            background: #FF6354 !important;
            color: #fff !important;
        }

        .accordion-body {
            margin-top: 0px !important;
            padding-top: 0px !important;
        }

        .accordion-body ul {
            padding: 0px;
        }

        .accordion-body ul li {
            padding: 10px 20px;
            background: #fff;
            list-style: none;
            color: #26268e;
            border-radius: 10px;
        }

        .accordion-body ul li b {
            background: #26268e;
            color: #fff;
            font-size: 12px;
            font-weight: normal;
            padding: 2px 2px 2px 5px;
            margin-right: 4px;
        }

        .accordion-body ul li small i {
            color: #FF6354;
        }

        .accordion-body ul li.nav-item {
            padding: 0px;
            font-weight: bold;
            margin-left: 0px;
            margin-right: 5px;
            border-radius: 10px !important;
        }

        .accordion-body ul li.nav-item a {
            color: #fff !important;
            padding: 8px 20px !important;
            border-radius: 10px !important;
            overflow: hidden !important;
            background-color: #26268e;
        }

        .accordion-button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }

        .accordion-button .ms-auto {
            display: flex;
            align-items: center;

        }

        .session-time {
            margin-right: 8px;
            font-size: 14px;
            color: #555;

        }

        .accordion-item.collapsed {
            background-color: rgba(38, 38, 142, 0.1) !important;

        }

        .accordion-arrow {
            transform: rotate(0deg);
            transition: transform 0.3s ease;

        }


        .accordion-button:not(.collapsed) .accordion-arrow {
            transform: rotate(180deg);
        }

        .nav-link.full-background {
            background-color: #007bff;

            color: #fff !important;
        }
    </style>

    <script src="{{ asset('backend') }}/dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/toastr.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/toastr.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/sweetalert2.js"></script>
    <!-- jquery js -->
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/jquery.min.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/bootstrap.min.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/metismenu.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/jqueryui.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/waypoint.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/swiper.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/theia-sticky-sidebar.min.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/gsap.min.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/scrolltigger.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/split-text.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/split-type.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/vendor/waw.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/counter-up.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/magnific-popup.js"></script>
    <!-- contact form js -->
    <script defer src="{{ asset('frontend') }}/assets/js/plugins/contact-form.js"></script>
    <script defer src="{{ asset('frontend') }}/assets/js/main.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#takeConferenceKit').click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure to provide conference kit?",
                    text: "You won't be able to revert it.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data('id');
                        var data = {
                            id: id,
                            _token: '{{ csrf_token() }}'
                        };
                        var url = '{{ route('conference-registration.takeConferenceKit') }}';
                        $.post(url, data, function(response) {
                            toastr.success("Conference kit provided successfully.");
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        });
                    }
                })
            });

            $('#takeAttendance').click(function(e) {
                e.preventDefault();
                let $this = $(this); // Store reference to the clicked <a> tag
                $this.addClass('disabled').css({
                    "pointer-events": "none",
                    "opacity": "0.6"
                });
                Swal.fire({
                    title: "Are you sure to take attendance?",
                    text: "You won't be able to revert it.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Do it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data('id');
                        var data = {
                            id: id
                        };
                        var url = '{{ route('conference-registration.takeAttendance') }}';
                        $.post(url, data, function(response) {
                            toastr.success("Attendance done successfully.");
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        });
                    } else {
                        $this.removeClass('disabled').css({
                            "pointer-events": "auto",
                            "opacity": "1"
                        });
                    }
                })
            });

            $('.takeMeal').click(function(e) {
                e.preventDefault();
                let $this = $(this);
                $this.addClass('disabled').css({
                    "pointer-events": "none",
                    "opacity": "0.6"
                });
                Swal.fire({
                    title: "Are you sure to take meal?",
                    text: "You won't be able to revert it.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Take!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var id = $(this).data('id');
                        var data = {
                            id: id
                        };
                        var url = '{{ route('conference-registration.takeMeal') }}';
                        $.post(url, data, function(response) {
                            toastr.success("Meal taken successfully.");
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        });
                    } else {
                        $this.removeClass('disabled').css({
                            "pointer-events": "auto",
                            "opacity": "1"
                        });
                    }
                })
            });
        });
    </script>
    <script>
        $('#searchInput').on('keyup', function() {
            let query = $(this).val().trim();

            if (query.length > 0) {
                $.ajax({
                    url: '{{ route('front.scientificSession.search') }}',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        displayResults(data);
                    },
                    error: function(error) {
                        console.error('Error fetching search results:', error);
                    }
                });
            } else {
                $('#searchResults').html('<p class="text-muted text-center">No results found found.</p>');
            }
        });

        function displayResults(results) {
            let resultsContainer = $('#searchResults');
            resultsContainer.empty();

            if (results.length === 0) {
                resultsContainer.html('<p class="text-muted text-center">No results found.</p>');
                return;
            }

            let limitedResults = results.slice(0, 4);
            $.each(limitedResults, function(index, result) {
                let sessionDate = result.day;
                let dayNumber = getDayNumber(sessionDate);

                let item = `
                    <div class="border-bottom py-2">
                        <strong><i class="fas fa-book-open"></i> ${result.topic}</strong> <br>
                        <span class="text-muted me-5"><i class="far fa-calendar-alt"></i> ${dayNumber}</span>
                        <span class="text-muted me-5"><i class="fas fa-map-marker-alt"></i> ${result.hall ? result.hall.hall_name : ''}</span>
                        <span class="text-muted me-5"><i class="far fa-clock"></i> ${result.duration ? result.duration : ''}</span>
                        ${result.participants && result.participants ? `<span class="text-muted"><i class="fas fa-user"></i> <b>${result.participants ? result.participants.replace(/^"|"$/g, '') : ''}</b></span></br>` : ''}</br>
                        <span class="text-muted"><i class="fas fa-tag"></i> <b>Theme</b>: ${result.category ? result.category.category_name : ''}</span> </br>
                        ${result.category && result.category.chairperson ? `<span class="text-muted"><i class="fas fa-user-tie"></i> <b>Chairperson</b>: ${result.category.chairperson}</span><br>` : ''}
                        ${result.category && result.category.co_chairperson ? `<span class="text-muted"><i class="fas fa-user-friends"></i> <b>Co-Chairperson</b>: ${result.category.co_chairperson}</span><br>` : ''}
                        ${result.category && result.category.moderator ? `<span class="text-muted"><i class="fas fa-user-check"></i> <b>Moderator</b>: ${result.category.moderator}</span><br>` : ''}</br>
                    </div>
                `;
                resultsContainer.append(item);
            });
        }
        let dates = @json($dates);

        function getDayNumber(sessionDate) {
            // Loop through the array of dates and check if the session date matches any in the list
            let dayNumber = 'N/A'; // Default if no match is found

            dates.forEach(function(date, index) {
                if (sessionDate === date) {
                    // Return "Day 1", "Day 2", etc. based on the index of the date
                    dayNumber = `Day ${index + 1}`; // Index starts from 0, so add 1 for Day numbering
                }
            });

            return dayNumber;
        }


        $(document).ready(function() {
            $(document).on("click", ".poll", function(e) {
                e.preventDefault();
                var url = '{{ route('front.poll') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                const userToken = '{{ request('token') }}';

                console.log(id)

                var data = {
                    _token: _token,
                    id: id,
                    userToken: userToken
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });
        });
    </script>

    @if (Session::has('status'))
        <script>
            toastr.success("{!! Session::get('status') !!}");
        </script>
    @endif

</body>

</html>
