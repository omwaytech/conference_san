@extends('layouts.front')

@section('content')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=keyboard_arrow_down" />

    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{ route('front.index') }}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Scientific Sessions
                            </a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">Scientific Sessions
                            </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rts-section-gapBottom rts-blog-area-one">
        <div class="container">
            <div class="row g-48 mt--0 justify-content-sm-center justify-content-md-start">
                <a href="{{asset('default-images/scientific-session.pdf')}}" target="_blank"><h4>-> Click here to download scientific sessions.</h4></a>
            </div>
            <div class="row g-48 mt--0 justify-content-sm-center justify-content-md-start">
                <div class="block_1">
                    <div class="schedule-warp">

                        {{-- @if ($sessionDays->isNotEmpty())
                            @foreach ($sessionDays as $sessionDay)
                                <div class="day-one">DAY {{$loop->iteration}}: {{\Carbon\Carbon::parse($sessionDay['day'])->format('F j, Y')}}</div>
                                @foreach ($sessionDay['sessions'] as $session)
                                    <div class="schedule-card">
                                        <div class="insidebox">
                                            @php
                                                $hallName = '-';
                                                if (!empty($session['hall'])) {
                                                    $hallName = DB::table('halls')->whereIn('id', json_decode($session['hall']))->pluck('hall_name')->implode(', ');
                                                }
                                            @endphp
                                            <span class="schedule-tag" style="margin-right: 15px">Hall: {{ $hallName }}</span>
                                            <span class="schedule-tag">Topic: {{ !empty($session['topic']) ? $session['topic'] : '-' }}</span>
                                            <span class="schedule-start" style="margin: 0px 15px">Time: {{ $session['time'] }}</span>
                                            <span class="schedule-start">Duration: {{ $session['duration'] }} mins</span>
                                        </div>
                                    </div>
                                @endforeach
                                <br>
                            @endforeach
                        @else
                            <p class="text-danger">Scientic Program Not Scheduled Yet.</p>
                        @endif --}}

                        <div class="col-lg-12">
                            <div class="accordion-faq-area-border-bottom-style style-four">
                                <div class="accordion" id="accordionExamples">
                                    @if (isset($dates) && count($dates) > 0)
                                        @foreach ($dates as $dateIndex => $date)
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading-{{ $dateIndex }}">
                                                    <button
                                                        class="accordion-button {{ $dateIndex === 0 ? '' : 'collapsed' }}"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-{{ $dateIndex }}"
                                                        aria-expanded="{{ $dateIndex === 0 ? 'true' : 'false' }}"
                                                        aria-controls="collapse-{{ $dateIndex }}">
                                                        <div style="font-size: 20px">
                                                            Day {{ $dateIndex + 1 }}
                                                        </div>
                                                        <div class="d-flex align-items-center ms-auto">
                                                            <span class="session-time">
                                                                {{ $date }}
                                                            </span>
                                                        </div>
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{ $dateIndex }}"
                                                    class="accordion-collapse collapse {{ $dateIndex === 0 ? 'show' : '' }}"
                                                    aria-labelledby="heading-{{ $dateIndex }}"
                                                    data-bs-parent="#accordionExamples">
                                                    <div class="accordion-body">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            @foreach ($halls as $hallIndex => $hall)
                                                                <li class="nav-item">
                                                                    <a class="nav-link {{ $hallIndex === 0 ? 'active' : '' }}"
                                                                        id="tab-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                        data-bs-toggle="tab"
                                                                        href="#content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                        role="tab"
                                                                        aria-controls="content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                        aria-selected="{{ $hallIndex === 0 ? 'true' : 'false' }}">
                                                                        {{ $hall->hall_name ?? 'Hall ' . ($hallIndex + 1) }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-bs-toggle="tab"
                                                                    href="#tab-{{ $dateIndex }}" role="tab">
                                                                    General Activity
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content mt-3">
                                                            @foreach ($halls as $hallIndex => $hall)
                                                                <div class="tab-pane fade {{ $hallIndex === 0 ? 'show active' : '' }}"
                                                                    id="content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                    role="tabpanel"
                                                                    aria-labelledby="tab-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                    @php
                                                                        $scientificSessions = $hall
                                                                            ->scientificSession()
                                                                            ->where('day', $date)
                                                                            ->orderByRaw("STR_TO_DATE(time, '%h:%i%p') ASC")
                                                                            ->get();
                                                                    @endphp
                                                                    <div class="accordion mt-3"
                                                                        id="innerAccordion-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                        @foreach ($scientificSessions as $sessionIndex => $session)
                                                                            @php
                                                                                $chairpersons = json_decode(
                                                                                    $session->chairperson,
                                                                                    true,
                                                                                );
                                                                                $coordinators = json_decode(
                                                                                    $session->co_chairperson,
                                                                                    true,
                                                                                );
                                                                                $participants = json_decode(
                                                                                    $session->participants,
                                                                                    true,
                                                                                );

                                                                                $chairpersons = is_array($chairpersons)
                                                                                    ? $chairpersons
                                                                                    : [];
                                                                                $coordinators = is_array($coordinators)
                                                                                    ? $coordinators
                                                                                    : [];
                                                                                $participants = is_array($participants)
                                                                                    ? $participants
                                                                                    : [];

                                                                                $chairpersonDetails = \App\Models\User::whereIn(
                                                                                    'id',
                                                                                    $chairpersons,
                                                                                )
                                                                                    ->select(
                                                                                        'f_name',
                                                                                        'm_name',
                                                                                        'l_name',
                                                                                    )
                                                                                    ->get();
                                                                                $coordinatorDetails = \App\Models\User::whereIn(
                                                                                    'id',
                                                                                    $coordinators,
                                                                                )
                                                                                    ->select(
                                                                                        'f_name',
                                                                                        'm_name',
                                                                                        'l_name',
                                                                                    )
                                                                                    ->get();
                                                                                $participantDetails = \App\Models\User::whereIn(
                                                                                    'id',
                                                                                    $participants,
                                                                                )
                                                                                    ->select(
                                                                                        'f_name',
                                                                                        'm_name',
                                                                                        'l_name',
                                                                                    )
                                                                                    ->get();
                                                                            @endphp
                                                                            @if ($session->type != 5)
                                                                                {{-- @dd($session) --}}
                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header"
                                                                                        id="session-{{ $session->id }}">
                                                                                        <button
                                                                                            class=" collapsed d-flex justify-content-between align-items-center"
                                                                                            type="button"
                                                                                            data-bs-toggle="collapse"
                                                                                            data-bs-target="#session-collapse-{{ $session->id }}"
                                                                                            aria-expanded="true"
                                                                                            aria-controls="session-collapse-{{ $session->id }}">
                                                                                            <div style="font-size: 15px">
                                                                                                {{-- {{ \Illuminate\Support\Str::limit($session->topic, 15) }} --}}
                                                                                                @if ($session->type == 1)
                                                                                                    Oral Presentation
                                                                                                    ({{ $session->category->category_name }})
                                                                                                @elseif($session->type == 2)
                                                                                                    Poster Presentation
                                                                                                    ({{ $session->category->category_name }})
                                                                                                @elseif($session->type == 3)
                                                                                                    Panel Discussion
                                                                                                    ({{ $session->category->category_name }})
                                                                                                @elseif($session->type == 4)
                                                                                                    Debate
                                                                                                    ({{ $session->category->category_name }})
                                                                                                @elseif($session->type == 5)
                                                                                                    General Activity
                                                                                                    ({{ $session->category->category_name }})
                                                                                                @endif
                                                                                            </div>
                                                                                            <div
                                                                                                class="d-flex align-items-center ms-auto">
                                                                                                <span class="session-time">
                                                                                                    {{ $session->time }}
                                                                                                    ({{ $session->duration }})
                                                                                                </span>
                                                                                                <span
                                                                                                    class="material-symbols-outlined">
                                                                                                    keyboard_arrow_down
                                                                                                </span>
                                                                                            </div>
                                                                                        </button>
                                                                                    </h2>
                                                                                    <div id="session-collapse-{{ $session->id }}"
                                                                                        class="accordion-collapse collapse"
                                                                                        aria-labelledby="session-{{ $session->id }}"
                                                                                        data-bs-parent="#innerAccordion-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                                        <div class="accordion-body">
                                                                                            @if ($session->type == 1 || $session->type == 2)
                                                                                                @if ($chairpersonDetails->isNotEmpty())
                                                                                                    <h6>Chairperson</h6>
                                                                                                    <ul>
                                                                                                        @foreach ($chairpersonDetails as $chairperson)
                                                                                                            <li>
                                                                                                                {{ $chairperson->f_name }}
                                                                                                                {{ $chairperson->m_name }}
                                                                                                                {{ $chairperson->l_name }}
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif

                                                                                                @if ($coordinatorDetails->isNotEmpty())
                                                                                                    <h6>Co-Ordinator</h6>
                                                                                                    <ul>
                                                                                                        @foreach ($coordinatorDetails as $coordinator)
                                                                                                            <li>
                                                                                                                {{ $coordinator->f_name }}
                                                                                                                {{ $coordinator->m_name }}
                                                                                                                {{ $coordinator->l_name }}
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                                @if ($participantDetails->isNotEmpty())
                                                                                                    <h6>Presenter</h6>
                                                                                                    <ul>
                                                                                                        @foreach ($participantDetails as $participant)
                                                                                                            <li>
                                                                                                                {{ $participant->f_name }}
                                                                                                                {{ $participant->m_name }}
                                                                                                                {{ $participant->l_name }}
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                                {{-- @dd($participantDetails) --}}
                                                                                            @endif
                                                                                            @if ($session->type == 3 || $session->type == 4)
                                                                                                @if (!empty($chairpersonDetails))
                                                                                                    <h6>Moderator</h6>
                                                                                                    <ul>
                                                                                                        @foreach ($chairpersonDetails as $participant)
                                                                                                            <li>
                                                                                                                {{ $participant->f_name }}
                                                                                                                {{ $participant->m_name }}
                                                                                                                {{ $participant->l_name }}
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                                @if (!empty($participantDetails))
                                                                                                    <h6>{{ $session->type == 3 ? 'Panelists' : 'Opponents' }}
                                                                                                    </h6>
                                                                                                    <ul>
                                                                                                        @foreach ($participantDetails as $participant)
                                                                                                            <li>
                                                                                                                {{ $participant->f_name }}
                                                                                                                {{ $participant->m_name }}
                                                                                                                {{ $participant->l_name }}
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <div class="tab-pane fade" id="tab-{{ $dateIndex }}"
                                                                role="tabpanel">
                                                                <div class="accordion" id="generalActivitiesAccordion">
                                                                    @php
                                                                        $generalActivities = \App\Models\ScientificSession::where(
                                                                            'type',
                                                                            5,
                                                                        )
                                                                            ->where('day', $date)
                                                                            ->orderByRaw("STR_TO_DATE(time, '%h:%i%p') ASC")
                                                                            ->get();
                                                                    @endphp
                                                                    @foreach ($generalActivities as $sessionIndex => $general)
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header"
                                                                                id="generalActivity-{{ $general->id }}">
                                                                                <button
                                                                                    class="collapsed d-flex justify-content-between align-items-center"
                                                                                    type="button" data-bs-toggle="collapse"
                                                                                    data-bs-target="#generalActivityCollapse-{{ $general->id }}"
                                                                                    aria-expanded="true"
                                                                                    aria-controls="generalActivityCollapse-{{ $general->id }}">
                                                                                    <div style="font-size: 15px">
                                                                                        {{-- {{ \Illuminate\Support\Str::limit($general->topic, 20) }} --}}
                                                                                        {{ $general->topic }}
                                                                                    </div>
                                                                                    <div
                                                                                        class="d-flex align-items-center ms-auto">
                                                                                        <span class="session-time">
                                                                                            {{ $general->time }}
                                                                                            ({{ $general->duration }})
                                                                                        </span>
                                                                                    </div>
                                                                                </button>
                                                                            </h2>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No dates or halls available.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- <div class="accordion-faq-area-border-bottom-style style-four">
                                <div class="accordion" id="accordionExamples">
                                    <!-- Static Date Section 1 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-1">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-1" aria-expanded="true"
                                                aria-controls="collapse-1">
                                                <div style="font-size: 20px">
                                                    Day 1
                                                </div>
                                                <div class="d-flex align-items-center ms-auto">
                                                    <span class="session-time">2025-01-01</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-1" class="accordion-collapse collapse show"
                                            aria-labelledby="heading-1" data-bs-parent="#accordionExamples">
                                            <div class="accordion-body">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="tab-1-1" data-bs-toggle="tab"
                                                            href="#content-1-1" role="tab" aria-controls="content-1-1"
                                                            aria-selected="true">
                                                            Hall 1
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-1-2" data-bs-toggle="tab"
                                                            href="#content-1-2" role="tab" aria-controls="content-1-2"
                                                            aria-selected="false">
                                                            Hall 2
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content mt-3">
                                                    <!-- Static Hall 1 Content -->
                                                    <div class="tab-pane fade show active" id="content-1-1" role="tabpanel"
                                                        aria-labelledby="tab-1-1">
                                                        <h5>Scientific Sessions in Hall 1</h5>
                                                        <div class="accordion mt-3" id="innerAccordion-1-1">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="session-101">
                                                                    <button
                                                                        class="d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-101"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-101">
                                                                        <div style="font-size: 15px">Session Topic 1</div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">10:00 AM</span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-101"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-101"
                                                                    data-bs-parent="#innerAccordion-1-1">
                                                                    <div class="accordion-body">
                                                                        This is a description of Session Topic 1.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="session-102">
                                                                    <button
                                                                        class="d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-102"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-102">
                                                                        <div style="font-size: 15px">Session Topic 2</div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">11:00 AM</span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-102"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-102"
                                                                    data-bs-parent="#innerAccordion-1-1">
                                                                    <div class="accordion-body">
                                                                        This is a description of Session Topic 2.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Static Hall 2 Content -->
                                                    <div class="tab-pane fade" id="content-1-2" role="tabpanel"
                                                        aria-labelledby="tab-1-2">
                                                        <h5>Scientific Sessions in Hall 2</h5>
                                                        <div class="accordion mt-3" id="innerAccordion-1-2">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="session-201">
                                                                    <button
                                                                        class="d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-201"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-201">
                                                                        <div style="font-size: 15px">Session Topic A</div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">2:00 PM</span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-201"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-201"
                                                                    data-bs-parent="#innerAccordion-1-2">
                                                                    <div class="accordion-body">
                                                                        This is a description of Session Topic A.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="session-202">
                                                                    <button
                                                                        class="d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-202"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-202">
                                                                        <div style="font-size: 15px">Session Topic B</div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">3:00 PM</span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-202"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-202"
                                                                    data-bs-parent="#innerAccordion-1-2">
                                                                    <div class="accordion-body">
                                                                        This is a description of Session Topic B.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Static Date Section 2 -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-2">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-2"
                                                aria-expanded="false" aria-controls="collapse-2">
                                                <div style="font-size: 20px">Day 2</div>
                                                <div class="d-flex align-items-center ms-auto">
                                                    <span class="session-time">2025-01-02</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-2" class="accordion-collapse collapse"
                                            aria-labelledby="heading-2" data-bs-parent="#accordionExamples">
                                            <div class="accordion-body">
                                                <!-- Content for Day 2 -->
                                                <p>No sessions available for Day 2.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .accordion-button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }

        .accordion-button .ms-auto {
            display: flex;
            align-items: center;
            /* Aligns time and arrow on the same line */
        }

        .session-time {
            margin-right: 8px;
            /* Adds space between the time and arrow */
            font-size: 14px;
            color: #555;
            /* Customize time appearance */
        }

        .accordion-arrow {
            transform: rotate(0deg);
            /* Keep default arrow rotation */
            transition: transform 0.3s ease;
            /* Smooth rotation effect */
        }

        /* Optional: Rotate arrow when active */
        .accordion-button:not(.collapsed) .accordion-arrow {
            transform: rotate(180deg);
        }

        .nav-link.full-background {
            background-color: #007bff;
            /* Customize as needed */
            color: #fff !important;
        }
    </style>
@endsection
