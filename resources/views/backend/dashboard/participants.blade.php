@extends('layouts.dash')

@section('title')
    @if ($status == 'unverified')
        Unverified
    @elseif ($status == 'accepted')
        Accepted
    @elseif ($status == 'total-registrants')
        Total
    @elseif ($status == 'national')
        National
    @elseif ($status == 'international')
        International
    @elseif ($status == 'accompany-persons')
        Accompanying Persons
    @endif
    Participants
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2 d-flex justify-content-between">
                        <h4 class="card-title">
                            @if ($status == 'unverified')
                                Unverified
                            @elseif ($status == 'accepted')
                                Accepted
                            @elseif ($status == 'total-registrants')
                                Total
                            @elseif ($status == 'national')
                                National
                            @elseif ($status == 'international')
                                International
                            @elseif ($status == 'accompany-persons')
                                Accompanying Persons
                            @endif
                            Participants
                        </h4>
                        <div class="">

                            <form id='exportForm' target="blank"
                                action="{{ route('conference-registration.exportTypeExcel') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="exportTypeExcel" class="form-control">
                                            <option>Select</option>
                                            <option value="1">Organizer</option>
                                            <option value="2">International</option>
                                            <option value="3">Delegate</option>
                                            <option value="4">Faculty/Speaker</option>
                                        </select>
                                    </div>
                                    <input type="hidden" value="" name="type" id="type">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary ml-2" id="exportExcel"><i
                                                class="nav-icon i-File"></i>
                                            Export Excel</button>
                                        <div class="">

                                            <button type="submit" class="btn btn-primary ml-2" id="viewPass"><i
                                                    class="nav-icon i-File"></i>
                                                View Pass</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="">
                            <a href="{{ route('conference.openConferencePortal', $conference->slug) }}"
                                class="btn btn-danger"> Back</a>
                            @if ($status == 'total-registrants' || $status == 'national' || $status == 'international')
                                @php
                                    if ($status == 'total-registrants') {
                                        $parameter = 'all';
                                    } elseif ($status == 'national') {
                                        $parameter = 'national';
                                    } elseif ($status == 'international') {
                                        $parameter = 'international';
                                    }
                                @endphp
                                <a href="{{ route('conference-registration.exportExcel', $parameter) }}"
                                    class="btn btn-primary ml-2"><i class="nav-icon i-File"></i> Export Excel</a>
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
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $registrant->user->fullName($registrant, 'user') }}</td>
                                        <td>{{ @$registrant->user->userDetail->memberType->type }}</td>
                                        <td>{{ $registrant->user->email }}</td>
                                        <td>
                                            @if ($registrant->payment_voucher == 'FonePay')
                                                Fone-Pay
                                            @elseif ($registrant->payment_voucher == 'Card Payment')
                                                Card Payment
                                            @elseif (!empty($registrant->payment_voucher))
                                                @php
                                                    $explodeFileName = explode('.', $registrant->payment_voucher);
                                                @endphp
                                                @if ($explodeFileName[1] == 'pdf')
                                                    <a href="{{ asset('storage/conference/registration/payment-voucher/' . $registrant->payment_voucher) }}"
                                                        target="_blank"><img src="{{ asset('default-images/pdf.png') }}"
                                                            alt="voucher" height="50" width="40"></a>
                                                @else
                                                    <a href="{{ asset('storage/conference/registration/payment-voucher/' . $registrant->payment_voucher) }}"
                                                        target="_blank"><img
                                                            src="{{ asset('storage/conference/registration/payment-voucher/' . $registrant->payment_voucher) }}"
                                                            alt="voucher" height="50" width="40"></a>
                                                @endif
                                            @else
                                                Registered By Admin
                                            @endif
                                        </td>
                                        <td>ID: {{ $registrant->transaction_id }} <br> Amount:
                                            @if (!empty($registrant->amount))
                                                {{ @$registrant->user->userDetail->country->country_name == 'Nepal' ? 'Rs. ' : '$' }}{{ $registrant->amount }}
                                            @elseif(empty($registrant->amount) && $registrant->payment_voucher == 'Fone-Pay')
                                                Check Fone-Pay
                                            @else
                                                Check Voucher
                                            @endif
                                        </td>
                                        <td>{{ $registrant->total_attendee }} <br>
                                            {{-- <button class="btn btn-sm btn-primary editNumber" data-id="{{$registrant->id}}" data-toggle="modal" data-target="#openModal">Edit Number</button> --}}
                                        </td>
                                        <td>{{ $registrant->created_at }}</td>
                                        <td>
                                            @if ($registrant->verified_status == 1)
                                                <span class="badge bg-success">Verified</span>
                                            @elseif ($registrant->verified_status == 2)
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <a href="{{ route('conferenceRegistration.verifyForm', $registrant->id) }}"
                                                    class="verifyRegistrant" data-id="{{ $registrant->id }}"
                                                    data-toggle="modal" data-target="#openModal"
                                                    title="Verify Registrant"><span
                                                        class="badge bg-warning">Unverified</span></a>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info viewData" type="button" title="View Data"
                                                data-id="{{ $registrant->id }}" data-toggle="modal"
                                                data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                            @if ($status == 'unverified')
                                                <button class="btn btn-sm btn-primary mt-1 sendCorrectionMail"
                                                    type="button" data-id="{{ $registrant->id }}" data-toggle="modal"
                                                    data-target="#openModal">Send Correction Mail</button>
                                            @endif
                                            @if ($status == 'accepted' && empty($registrant->payment_voucher))
                                                <button class="btn btn-sm btn-primary addVoucher mt-1"
                                                    data-id="{{ $registrant->id }}" data-toggle="modal"
                                                    data-target="#openModal">Add Voucher</button>
                                            @endif

                                            {{-- @if ($status == 'accepted' || $status == 'total-registrants')
                                                <button class="btn btn-sm btn-primary mt-1 addRole" data-id="{{$registrant->id}}" data-toggle="modal" data-target="#openModal">Add Role</button>
                                            @endif
                                            <br> --}}
                                            {{-- @if ($status == 'accepted')
                                                <button class="btn btn-sm btn-primary takeAttendance mt-1" data-id="{{$registrant->id}}" data-toggle="modal" data-target="#openModal">Take Attendance</button></td>
                                            @endif --}}
                                            {{-- @dd($registrant->registrant_type == 1) --}}
                                            @if ($registrant->registrant_type == 1 || $registrant->registrant_type == 2)
                                                <button class="btn btn-sm btn-primary convertToSpeaker mt-1"
                                                    data-id="{{ $registrant->id }}" type="submit">
                                                    Convert To ChairPerson
                                                </button>
                                            @endif
                                            <a href="{{ route('conference-registration.generateCertificate', $registrant->token) }}"
                                                class="btn btn-primary btn-sm mt-1"><i class="nav-icon i-File"></i> Generate
                                                Certificate</a>
                                            {{-- <a href="{{ route('conference-registration.sendIndividualCertificate', $registrant->token) }}" class="btn btn-primary btn-sm mt-1"><i class="nav-icon i-File"></i> Generate Certificate</a> --}}
                                            <button class="btn btn-sm btn-primary sendCertificate mt-1"
                                                data-id="{{ $registrant->id }}" type="submit">
                                                Send Certificate
                                            </button>
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
            $(document).on("click", ".convertToSpeaker", function(e) {
                e.preventDefault();
                var title = 'Are you sure to convert an participant to chairperson?';
                Swal.fire({
                    title: title,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Send it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = '{{ route('conferenceRegistration.convertToChairperson') }}';
                        var _token = '{{ csrf_token() }}';
                        var id = $(this).data('id');
                        var data = {
                            _token: _token,
                            id: id
                        };
                        $.post(url, data, function(response) {
                            if (response.type == 'success') {
                                toastr.success(response.message);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        });
                    }
                })
            });
            $(document).on("click", ".sendCertificate", function(e) {
                e.preventDefault();
                var title = 'Are you sure to send certificate?';
                Swal.fire({
                    title: title,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Convert!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = '{{ route('conferenceRegistration.sendIndividualCertificate') }}';
                        var _token = '{{ csrf_token() }}';
                        var id = $(this).data('id');
                        var data = {
                            _token: _token,
                            id: id
                        };
                        $.post(url, data, function(response) {
                            if (response.type == 'success') {
                                toastr.success(response.message);
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        });
                    }
                })
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

            $(document).on("click", ".addVoucher", function(e) {
                e.preventDefault();
                var url = '{{ route('conferenceRegistration.addPaymentVoucher') }}';
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

            $(document).on("click", ".addRole", function(e) {
                e.preventDefault();
                var url = '{{ route('conferenceRegistration.addRole') }}';
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

            $('#viewPass').click(function() {
                $('#type').val('1');
            });
            $('#exportExcel').click(function() {
                $('#type').val('2');
            });
        });
    </script>
@endsection
