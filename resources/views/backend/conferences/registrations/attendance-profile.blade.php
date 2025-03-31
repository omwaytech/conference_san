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
</head>

<body class="text-left">
    <div class="app-admin-wrap layout-sidebar-large">
        <!-- =============== Left side End ================-->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-profile-1 mb-4">
                        <div class="card-body text-center">
                            <div class="avatar box-shadow-2 mb-3"><img src="{{ asset('default-images/avatar.png') }}"
                                    alt="" />
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
                                    <span class="badge badge-warning p-3" style="font-size: 100%">Attendance Done</span>
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
                                        $totalLunchRemaining = $participant->total_attendee - $checkMeal->lunch_taken;
                                        $totalDinnerRemaining = $participant->total_attendee - $checkMeal->dinner_taken;
                                    }
                                @endphp
                                <h5>Total Lunch Remaining: <span style="color: red">{{ $totalLunchRemaining }}</span>
                                    -------&&&&------- Total Dinner Remaining: <span
                                        style="color: red">{{ $totalDinnerRemaining }}</span></h5>
                                <hr>
                                <div>
                                    @if (date('H:i') < '16:00')
                                        @if ($totalLunchRemaining > 0)
                                            <a href="#" class="takeMeal" data-id="{{ $participant->id }}"><button
                                                    class="btn btn-primary btn-rounded">Take Lunch</button></a>
                                        @else
                                            <span class="badge badge-warning p-3" style="font-size: 100%">Lunch
                                                Completed</span>
                                        @endif
                                    @else
                                        @if ($totalDinnerRemaining > 0)
                                            <a href="#" class="takeMeal" data-id="{{ $participant->id }}"><button
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
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('backend') }}/dist-assets/js/plugins/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/plugins/toastr.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/scripts/toastr.script.min.js"></script>
    <script src="{{ asset('backend') }}/dist-assets/js/sweetalert2.js"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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

    @if (Session::has('status'))
        <script>
            toastr.success("{!! Session::get('status') !!}");
        </script>
    @endif

</body>

</html>
