@extends('layouts.dash')

@section('title')
    @if ($day == 'day1')
        @if ($type == 'attendance')
            Attendance Status For Day 1
        @elseif ($type == 'lunch')
            Lunch/Dinner Status For Day 1
        @endif
    @elseif ($day == 'day2')
        @if ($type == 'attendance')
            Attendance Status For Day 2
        @elseif ($type == 'lunch')
            Lunch/Dinner Status For Day 2
        @endif
    @endif
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">
                            @if ($day == 'day1')
                                @if ($type == 'attendance')
                                    Attendance Status For Day 1
                                @elseif ($type == 'lunch')
                                    Lunch/Dinner Status For Day 1
                                @endif
                            @elseif ($day == 'day2')
                                @if ($type == 'attendance')
                                    Attendance Status For Day 2
                                @elseif ($type == 'lunch')
                                    Lunch/Dinner Status For Day 2
                                @endif
                            @endif
                        </h4>
                        <div class="ml-auto">
                            <a href="{{ route('home') }}" class="btn btn-danger"> Back</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Applicant Name</th>
                                    <th scope="col">Delegate</th>
                                    <th scope="col">Membership Type</th>
                                    @if ($type == 'attendance')
                                        <th scope="col">Attendance</th>
                                    @elseif ($type == 'lunch')
                                        <th scope="col">Lunch/Dinner</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrants as $registrant)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $registrant->user->name }}</td>
                                        <td>{{ $registrant->user->userDetail->memberType->delegate }}</td>
                                        <td>{{ $registrant->user->userDetail->memberType->type }}</td>
                                        <td>
                                            @if ($day == 'day1')
                                                @if ($type == 'attendance')
                                                    @if ($status == 'taken')
                                                        <span class="badge bg-success">Taken</span>
                                                    @elseif ($status == 'remaining')
                                                        <span class="badge bg-warning">Remaining</span>
                                                    @endif
                                                @elseif ($type == 'lunch')
                                                    @if ($status == 'taken')
                                                        <span class="badge bg-success">Taken</span>
                                                    @elseif ($status == 'remaining')
                                                        <span class="badge bg-warning">Remaining</span>
                                                    @endif
                                                @endif
                                            @elseif ($day == 'day2')
                                                @if ($type == 'attendance')
                                                    @if ($status == 'taken')
                                                        <span class="badge bg-success">Taken</span>
                                                    @elseif ($status == 'remaining')
                                                        <span class="badge bg-warning">Remaining</span>
                                                    @endif
                                                @elseif ($type == 'lunch')
                                                    @if ($status == 'taken')
                                                        <span class="badge bg-success">Taken</span>
                                                    @elseif ($status == 'remaining')
                                                        <span class="badge bg-warning">Remaining</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="openModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" id="modalContent">
                                {{-- modal body goes here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $(document).on("click", ".viewData", function(e) {
                e.preventDefault();
                var url = '{{ route('conference-registration.show') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });

            $(document).on("click", ".sendCorrectionMail", function(e) {
                e.preventDefault();
                var url = '{{ route('conferenceRegistration.sendCorrectionMailForm') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });

            $(document).on("click", ".verifyRegistrant", function(e) {
                e.preventDefault();
                var url = '{{ route('conferenceRegistration.verifyForm') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });

            $(document).on("click", ".editNumber", function(e) {
                e.preventDefault();
                var url = '{{ route('conferenceRegistration.editAttendeesNumber') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });

            $(document).on("click", ".takeAttendance", function(e) {
                e.preventDefault();
                var url = '{{ route('conference-registration.takeAttendance') }}';
                var _token = '{{ csrf_token() }}';
                var id = $(this).data('id');
                var data = {
                    _token: _token,
                    id: id
                };
                $.post(url, data, function(response) {
                    $('#modalContent').html(response);
                });
            });
        });
    </script>
@endsection
