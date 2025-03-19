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
                            <p class="mt-0">Workshop Attendance ({{$participant->workshop->title}})</p>
                            @php
                                $checkAttendance = $participant
                                    ->attendances()
                                    ->where(['workshop_registration_id' => $participant->id, 'status' => 1])
                                    ->whereDate('created_at', date('Y-m-d'))
                                    ->first();
                            @endphp
                            @if (empty($checkAttendance))
                                <a href="#" id="takeAttendance" data-id="{{ $participant->id }}" data-type="in"><button
                                        class="btn btn-primary btn-rounded">Take Attendance In</button></a>
                            @elseif (!empty($checkAttendance) && empty($checkAttendance->out))
                                <a href="#" id="takeAttendance" data-id="{{ $participant->id }}" data-type="out"><button
                                        class="btn btn-primary btn-rounded">Take Attendance Out</button></a>
                            @else
                                <div>
                                    <span class="badge badge-warning p-3" style="font-size: 100%">Attendance Completed For Today</span>
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
                    var type = $(this).data('type');
                    if (type == 'in') {
                        var title = "Are you sure to take attendance?";
                    } else {
                        var title = "Are you sure to check out?";
                    }
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
                                id: id,
                                type: type
                            };
                            var url = '{{ route('workshop-registration.takeAttendance') }}';
                            $.post(url, data, function(response) {
                                if (type == 'in') {
                                    toastr.success("Attendance In done successfully.");
                                } else if (type == 'out') {
                                    toastr.success("Attendance Out done successfully.");
                                }
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
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
