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
                            <div class="avatar box-shadow-2 mb-3"><img
                                    src="{{ asset('default-images/avatar.png') }}" alt="" />
                            </div>
                            <h5 class="m-0">{{$sponsor->name}}</h5>
                            <p class="mt-0">{{$sponsor->category->category_name}}</p>
                            @if (date('Y-m-d') == $conference->start_date)
                                @if (now()->format('H:i:s') < 16)
                                    <h3 style="text-decoration: underline">For Lunch Verification Day 1:</h3>
                                    <h5>Remaining Lunch Slots: {{$sponsor->dinner_remaining}}</h5>
                                    @if ($sponsor->dinner_remaining > 0)
                                        <a href="{{route('sponsor.takeDinner', [$sponsor->id, 'day1', 'lunch'])}}" id="takeDinner"><button class="btn btn-primary btn-rounded">Take Lunch</button></a>
                                    @else
                                        <span class="badge badge-warning p-3" style="font-size: 100%">Lunch Completed</span>
                                    @endif
                                @else
                                    <h3 style="text-decoration: underline">For Dinner Verification Day 1:</h3>
                                    <h5>Remaining Dinner Slots: {{$sponsor->dinner_remaining_3}}</h5>
                                    @if ($sponsor->dinner_remaining_3 > 0)
                                        <a href="{{route('sponsor.takeDinner', [$sponsor->id, 'day1', 'dinner'])}}" id="takeDinner3"><button class="btn btn-primary btn-rounded">Take Dinner</button></a>
                                    @else
                                        <span class="badge badge-warning p-3" style="font-size: 100%">Dinner Completed</span>
                                    @endif
                                @endif
                            @endif
                            @if (date('Y-m-d') == $conference->end_date)
                                @if (now()->format('H:i:s') < 16)
                                    <h3 style="text-decoration: underline">For Lunch Verification Day 2:</h3>
                                    <h5>Remaining Lunch Slots: {{$sponsor->dinner_remaining_2}}</h5>
                                    @if ($sponsor->dinner_remaining_2 > 0)
                                        <a href="{{route('sponsor.takeDinner', [$sponsor->id, 'day2', 'lunch'])}}" id="takeDinner2"><button class="btn btn-primary btn-rounded">Take Lunch</button></a>
                                    @else
                                        <span class="badge badge-warning p-3" style="font-size: 100%">Lunch Completed</span>
                                    @endif
                                @else
                                    <h3 style="text-decoration: underline">For Dinner Verification Day 2:</h3>
                                    <h5>Remaining Dinner Slots: {{$sponsor->dinner_remaining_4}}</h5>
                                    @if ($sponsor->dinner_remaining_4 > 0)
                                        <a href="{{route('sponsor.takeDinner', [$sponsor->id, 'day2', 'dinner'])}}" id="takeDinner4"><button class="btn btn-primary btn-rounded">Take Dinner</button></a>
                                    @else
                                        <span class="badge badge-warning p-3" style="font-size: 100%">Dinner Completed</span>
                                    @endif
                                @endif
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

    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers:
                { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            $('#takeAttendance').click(function(e) {
                e.preventDefault();
                if (confirm("Are you sure to take attendance? You won't be able to revert it.")) {
                    var id = $(this).data('id');
                    var day = 'day1';
                    var data = {
                        id: id,
                        day: day
                    };
                    var url = '{{ route('conference-registration.takeAttendanceInConference') }}';
                    $.post(url, data, function (response) {
                        toastr.success("Attendance done successfully.");
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    });
                }
            });

            $('#takeDinner').click(function(e) {
                e.preventDefault();
                if (confirm("Are you sure to proceed for lunch? You won't be able to revert it.")) {
                    location.href = $(this).attr('href');
                }
            });

            $('#takeDinner3').click(function(e) {
                e.preventDefault();
                if (confirm("Are you sure to proceed for dinner? You won't be able to revert it.")) {
                    location.href = $(this).attr('href');
                }
            });

            $('#takeAttendance2').click(function(e) {
                e.preventDefault();
                if (confirm("Are you sure to take attendance? You won't be able to revert it.")) {
                    var id = $(this).data('id');
                    var day = 'day2';
                    var data = {
                        id: id,
                        day: day
                    };
                    var url = '{{ route('conference-registration.takeAttendanceInConference') }}';
                    $.post(url, data, function (response) {
                        toastr.success("Attendance done successfully.");
                        setTimeout(function () {
                            window.location.reload();
                        }, 1000);
                    });
                }
            });

            $('#takeDinner2').click(function(e) {
                e.preventDefault();
                if (confirm("Are you sure to proceed for lunch? You won't be able to revert it.")) {
                    location.href = $(this).attr('href');
                }
            });

            $('#takeDinner4').click(function(e) {
                e.preventDefault();
                if (confirm("Are you sure to proceed for dinner? You won't be able to revert it.")) {
                    location.href = $(this).attr('href');
                }
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
