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
                            <div class="card-body"><i class="i-Mens" ></i>
                                <div style="margin-left: 6%;">  
                                    <h5 class="text-muted mt-2 mb-0">Total Registrations</h5>
                                    <a href="#"><p class="lead text-primary text-24 mb-2">{{$totalRegistrants}}</p></a>
                                    <a href="{{route('home.viewParticipants', 'total-registrants')}}" class="btn btn-primary btn-sm">View All</a>
                                    <a href="{{route('home.viewAttendanceStatus')}}" class="btn btn-primary btn-sm mt-1">View Attendance Status</a>
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
                                        <p class="text-muted mt-2 mb-0">{{$nr_item->type}}: {{$nr_item->user_count}}</p>
                                    @endforeach
                                    <a href="{{route('home.viewParticipants', 'national')}}" class="btn btn-primary btn-sm">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body">
                                <div style="margin-left: 6%;">
                                    <h5  class="text-muted mt-2 mb-0">Total International Registrants</h5 >
                                    @foreach ($totalInternationalRegistrants as $inr_item)
                                        <p class="text-muted mt-2 mb-0">{{$inr_item->type}}: {{$inr_item->user_count}}</p>
                                    @endforeach
                                    <a href="{{route('home.viewParticipants', 'international')}}" class="btn btn-primary btn-sm">View All</a>
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
                                    <a href="#"><p class="lead text-primary text-24 mb-2">{{$totalAccompanyPersons}}</p></a>
                                    <a href="{{route('home.viewParticipants', 'accompany-persons')}}" class="btn btn-primary btn-sm">View All</a>
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
                                <sup class="badge badge-danger px-2 py-2">{{count($registrants->where('verified_status', 1))}}</sup>
                            </sup>
                            <a href="{{route('home.viewParticipants', 'accepted')}}" class="float-right"><button class="btn btn-sm btn-primary" type="button">View All</button></a>
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
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$a_item->user->fullName($a_item, 'user')}}</td>
                                                <td>
                                                    <span class="badge badge-success">{{$a_item->registrant_type == 1 ? 'Attendee' : 'Presenter'}}</span>
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
                                <sup class="badge badge-danger px-2 py-2">{{count($registrants->where('verified_status', 0))}}</sup>
                            </sup>
                            <a href="{{route('home.viewParticipants', 'unverified')}}" class="float-right"><button class="btn btn-sm btn-primary" type="button">View All</button></a>
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
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$u_item->user->fullName($u_item, 'user')}}</td>
                                                <td>
                                                    <span class="badge badge-warning">{{$u_item->registrant_type == 1 ? 'Attendee' : 'Presenter'}}</span>
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
                                    <h5 class="text-muted mt-2 mb-0">{{$w_item->title}}</h5>
                                    @php
                                        $totalQuota = $w_item->no_of_participants;
                                        $appliedQuota = $w_item->registrations->count();
                                    @endphp
                                    <p class="text-muted mt-2 mb-0">Total Quota: {{$totalQuota}}</p>
                                    <p class="text-muted mt-2 mb-0">Applied Quota: {{$appliedQuota}}</p>
                                    <p class="text-muted mt-2 mb-0">Remaining Quota: {{$totalQuota - $appliedQuota < 0 ? 0 : $totalQuota - $appliedQuota}}</p>
                                    @php
                                        $withConferenceCount = DB::table('conference_registrations')->where('conference_id', $conference->id)->whereIn('user_id', $w_item->registrations->pluck('user_id')->toArray())->get()->count();

                                    @endphp
                                    <p class="text-muted mt-2 mb-0">With Conference: {{$withConferenceCount}}</p>
                                    <p class="text-muted mt-2 mb-0">Without Conference: {{$appliedQuota - $withConferenceCount}}</p>
                                    @php
                                        $verified = $w_item->registrations->where('verified_status', 1)->count()
                                    @endphp
                                    <p class="text-muted mt-2 mb-0">Verified Registrants: {{$verified}}</p>
                                    <p class="text-muted mt-2 mb-0">Unverified Registrants: {{$appliedQuota - $verified}}</p>
                                    <a href="{{route('home.workshopRegistrations', $w_item->slug)}}" class="btn btn-primary btn-sm">View All</a>
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
                                    <p class="text-muted mt-2 mb-0">Total: {{$submissions->where('presentation_type', 1)->count()}}</p>
                                    <a href="{{route('home.submission', 1)}}" class="btn btn-primary btn-sm">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                            <div class="card-body"><i class="i-File"></i>
                                <div style="margin-left: 6%;">
                                    <h5 class="text-muted mt-2 mb-0">Oral(Abstract)</h5>
                                    <p class="text-muted mt-2 mb-0">Total: {{$submissions->where('presentation_type', 2)->count()}}</p>
                                    <a href="{{route('home.submission', 2)}}" class="btn btn-primary btn-sm">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @else
            @php
                $checkConferenceRegistration = DB::table('conference_registrations')->where(['conference_id' => $conference->id, 'user_id' => $user->id, 'status' => 1])->first();
            @endphp
            @if (empty($checkConferenceRegistration))
                <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" id="modalContent">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalCenterTitle">Confirmation For Conference Registration.</h3>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <h5><b>Conference Registration Status:</b> <span class="text-danger">Not Registered</span></h5>
                                <a href="{{route('conference-registration.create')}}">Click here to register into conference</a>
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
                                <p class="text-24 mt-2 mb-0">{{$user->fullName($user)}}</p>
                                <p class="text-24 mt-2 mb-0">Welcome To Dashboard.</p>
                                @if (!empty($user->conferenceRegistration) && $user->conferenceRegistration->registrant_type == 1)
                                    <a href="{{route('conference-registration.convertToSpeaker')}}" class="btn btn-primary mt-2">Convert To Speaker?</a>
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
    $(document).ready(function () {
        $('#openModal').modal('show');
    });
</script>
@endsection
