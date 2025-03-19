@extends('layouts.dash')

@section('title')
    @if ($times == 'first')
        Participants Registered After 12 PM, Aplril 4, 2024
    @elseif ($times == 'second')
        Participants Registered After 8 PM, Aplril 4, 2024
    @endif
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">
                            @if ($times == 'first')
                                Participants Registered After 12 PM, Aplril 4, 2024
                            @elseif ($times == 'second')
                                Participants Registered After 8 PM, Aplril 4, 2024
                            @endif
                        </h4>
                        <div class="ml-auto">
                            <a href="{{ route('home') }}" class="btn btn-danger"> Back</a>
                            @if ($times == 'first')
                                <a href="{{ route('home.generateLaterRegistrantPass', 'first') }}" target="_blank" class="btn btn-primary ml-2"><i class="nav-icon i-File"></i> Generate Pass</a>
                            @else
                                <a href="{{ route('home.generateLaterRegistrantPass', 'second') }}" target="_blank" class="btn btn-primary ml-2"><i class="nav-icon i-File"></i> Generate Pass</a>
                            @endif
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Applicant Name</th>
                                    <th scope="col">Membership Type</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Payment Voucher</th>
                                    <th scope="col">Transaction Details</th>
                                    <th scope="col">No. of people</th>
                                    <th scope="col">Submitted at</th>
                                    <th scope="col">Is Verified ?</th>
                                    <th scope="col" style="width: 9%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrants as $registrant)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$registrant->user->name}}</td>
                                        <td>{{$registrant->user->userDetail->memberType->type}}</td>
                                        <td>{{$registrant->user->email}}</td>
                                        <td>
                                            @if ($registrant->payment_voucher == 'Fone-Pay')
                                                Fone-Pay
                                            @elseif (!empty($registrant->payment_voucher))
                                                @php
                                                    $explodeFileName = explode('.', $registrant->payment_voucher);
                                                @endphp
                                                @if ($explodeFileName[1] == 'pdf')
                                                    <a href="{{asset('storage/conference/registration/payment-voucher/'.$registrant->payment_voucher)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" alt="voucher" height="50" width="40"></a>
                                                @else
                                                    <a href="{{asset('storage/conference/registration/payment-voucher/'.$registrant->payment_voucher)}}" target="_blank"><img src="{{asset('storage/conference/registration/payment-voucher/'.$registrant->payment_voucher)}}" alt="voucher" height="50" width="40"></a>
                                                @endif
                                            @else
                                                Registered By Admin
                                            @endif
                                        </td>
                                        <td>ID: {{$registrant->transaction_id}} <br> Amount:
                                            @if(!empty($registrant->amount))
                                                Rs. {{$registrant->amount}}
                                            @elseif(empty($registrant->amount) && $registrant->payment_voucher == 'Fone-Pay')
                                                Check Fone-Pay
                                            @else
                                                Check Voucher
                                            @endif
                                        </td>
                                        <td>{{$registrant->total_attendee}} <br> <button class="btn btn-sm btn-primary editNumber" data-id="{{$registrant->id}}" data-toggle="modal" data-target="#openModal">Edit Number</button></td>
                                        <td>{{$registrant->created_at}}</td>
                                        <td>
                                            @if ($registrant->verified_status == 1)
                                                <span class="badge bg-success">Verified</span>
                                            @elseif ($registrant->verified_status == 2)
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <a href="{{route('conferenceRegistration.verifyForm', $registrant->id)}}" class="verifyRegistrant" data-id="{{$registrant->id}}" data-toggle="modal" data-target="#openModal" title="Verify Registrant"><span class="badge bg-warning">Unverified</span></a>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info viewData" type="button" title="View Data" data-id="{{$registrant->id}}" data-toggle="modal" data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
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
