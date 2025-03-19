@extends('layouts.dash')

@section('title')
    Attendance Status
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">
                            Atttendance Status
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
                                    <th scope="col">Day 1 Status</th>
                                    <th scope="col">Day 2 Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrants as $registrant)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$registrant->user->name}}</td>
                                        <td>{{@$registrant->user->userDetail->memberType->delegate}}</td>
                                        <td>{{@$registrant->user->userDetail->memberType->type}}</td>
                                        <td>
                                            Attendance: @if ($registrant->attendance_status == 0) <span class="badge bg-warning">Not Taken</span> @else <span class="badge bg-success">Taken</span> @endif <br>
                                            Lunch/Dinner: @if ($registrant->remaining_dinner == 0) <span class="badge bg-success">Taken</span> @else Remaining-{{$registrant->remaining_dinner}} @endif <br>
                                        </td>
                                        <td>
                                            Attendance: @if ($registrant->attendance_status_2 == 0) <span class="badge bg-warning">Not Taken</span> @else <span class="badge bg-success">Taken</span> @endif <br>
                                            Lunch/Dinner: @if ($registrant->remaining_dinner_2 == 0) <span class="badge bg-success">Taken</span> @else Remaining-{{$registrant->remaining_dinner_2}} @endif <br>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
    $(document).ready(function () {
        $(document).on("click", ".viewData", function (e) {
            e.preventDefault();
            var url = '{{route('conference-registration.show')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });

        $(document).on("click", ".sendCorrectionMail", function (e) {
            e.preventDefault();
            var url = '{{route('conferenceRegistration.sendCorrectionMailForm')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });

        $(document).on("click", ".verifyRegistrant", function (e) {
            e.preventDefault();
            var url = '{{route('conferenceRegistration.verifyForm')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });

        $(document).on("click", ".editNumber", function (e) {
            e.preventDefault();
            var url = '{{route('conferenceRegistration.editAttendeesNumber')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });

        $(document).on("click", ".takeAttendance", function (e) {
            e.preventDefault();
            var url = '{{route('conference-registration.takeAttendance')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });
    });
</script>
@endsection
