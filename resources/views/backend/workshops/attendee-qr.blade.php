<!DOCTYPE html>
<html lang="en" dir="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance </title>
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
                                    src="{{ asset('backend') }}/dist-assets/images/faces/16.jpg" alt="" />
                            </div>
                            <h5 class="m-0">{{$attendee->name}}</h5>
                            <p class="mt-0">{{$attendee->affiliation}}</p>
                            @if ($attendee->attendance_status === 0)
                                <a href="{{route('takeAttendance', $attendee->id)}}"><button class="btn btn-primary btn-rounded">Take Attendance</button></a>
                            @else
                                <div>
                                    <span class="badge badge-warning p-3" style="font-size: 100%">Attendance Done</span>
                                </div>
                                <br>
                                <h3 style="text-decoration: underline">For Lunch/Dinner Verification:</h3>
                                <h5>Remaining Lunch/Dinner Slots: {{$attendee->dinner_remaining}}</h5>
                                @if ($attendee->dinner_remaining > 0)
                                    <a href="{{route('takeDinner', $attendee->id)}}" id="takeDinner"><button class="btn btn-primary btn-rounded">Take Lunch/Dinner</button></a>
                                @else
                                    <span class="badge badge-warning p-3" style="font-size: 100%">Lunch/Dinner Completed</span>
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
            $('#takeDinner').click(function(e) {
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
