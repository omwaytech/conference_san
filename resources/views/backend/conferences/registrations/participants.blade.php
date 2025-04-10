@extends('layouts.dash')

@section('title')
    @if ($type == 'attendees')
        Conference Attendees
    @elseif ($type == 'speakers')
        Conference Speakers
    @elseif ($type == 'invited-attendees')
        Conference Invited Attendees
    @elseif ($type == 'invited-speakers')
        Conference Invited Speakers
    @endif
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">
                            @if ($type == 'attendees')
                                Conference Attendees
                            @elseif ($type == 'speakers')
                                Conference Speakers
                            @elseif ($type == 'invited-attendees')
                                Conference Invited Attendees
                            @elseif ($type == 'invited-speakers')
                                Conference Invited Speakers
                            @endif
                        </h4>
                        <div class="row mt-4">
                            <form action="{{ route('conferenceRegistration.dummyPass') }}" method="POST">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-md-3 form-group ">
                                        <label for="registrant_type">Dummy Pass <code>*</code></label>
                                        <select name="registrant_type" id="registrant_type" class="form-control ">
                                            <option value="">-- Select Number Of Guests --</option>
                                            <option value="1">Delegate</option>
                                            <option value="2">Faculty</option>
                                        </select>
                                        @error('registrant_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="registrant_type">Enter Number<code>*</code></label>
                                        <input class="form-control" type="number" name="number">
                                    </div>
                                    <div class="col-md-3 form-group mt-4">
                                        <button id="calculatePrice" class="btn btn-primary">Generate Pass</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="ml-auto">
                            @if ($type == 'attendees')
                                {{-- <a href="javascript:void(0)" class="btn btn-primary ml-2 export-excel-btn"
                                    data-url="{{ route('conference-registration.exportExcel', 'attendees') }}">
                                    <i class="nav-icon i-File"></i> Export Excel
                                </a> --}}
                                <a href="{{ route('conference-registration.generatePass', 'attendees') }}"
                                    class="btn btn-primary ml-2" target="_blank"><i class="nav-icon i-File"></i> Generate
                                    Pass</a>
                            @elseif ($type == 'speakers')
                                {{-- <a href="javascript:void(0)" class="btn btn-primary ml-2 export-excel-btn"
                                    data-url="{{ route('conference-registration.exportExcel', 'presenters') }}">
                                    <i class="nav-icon i-File"></i> Export Excel
                                </a> --}}
                                <a href="{{ route('conference-registration.generatePass', 'presenters') }}"
                                    class="btn btn-primary ml-2" target="_blank"><i class="nav-icon i-File"></i> Generate
                                    Pass</a>
                            @elseif ($type == 'invited-attendees')
                                {{-- <a href="javascript:void(0)" class="btn btn-primary ml-2 export-excel-btn"
                                    data-url="{{ route('conference-registration.exportExcel', 'guest-attendees') }}">
                                    <i class="nav-icon i-File"></i> Export Excel
                                </a> --}}
                                <a href="{{ route('conference-registration.generatePass', 'guest-attendees') }}"
                                    class="btn btn-primary ml-2" target="_blank"><i class="nav-icon i-File"></i> Generate
                                    Pass</a>
                            @elseif ($type == 'invited-speakers')
                                {{-- <a href="javascript:void(0)" class="btn btn-primary ml-2 export-excel-btn"
                                    data-url="{{ route('conference-registration.exportExcel', 'guest-presenters') }}">
                                    <i class="nav-icon i-File"></i> Export Excel
                                </a> --}}
                                <a href="{{ route('conference-registration.generatePass', 'guest-presenters') }}"
                                    class="btn btn-primary ml-2" target="_blank"><i class="nav-icon i-File"></i> Generate
                                    Pass</a>
                            @endif
                            {{-- <a href="{{ route('conference-registration.generateCertificate', 'attendees') }}" class="btn btn-primary ml-2" target="_blank"><i class="nav-icon i-File"></i> Generate Certificate</a> --}}
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
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">No. of people</th>
                                    <th scope="col">Is Verified ?</th>
                                    <th scope="col">Registration Id</th>
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
                                            @if ($registrant->id == 174)
                                                Online Payment: Rs.{{ $registrant->amount }}<br>
                                                <a href="{{ asset('storage/conference/registration/payment-voucher/' . 'bibesh.jpeg') }}"
                                                    target="_blank"><img
                                                        src="{{ asset('storage/conference/registration/payment-voucher/' . 'bibesh.jpeg') }}"
                                                        alt="voucher" height="50" width="40"></a>
                                            @else
                                                @if ($registrant->payment_voucher == 'FonePay')
                                                    Fone-Pay
                                                @elseif ($registrant->payment_voucher == 'Card Payment')
                                                    Card Payment
                                                @elseif (!empty($registrant->payment_voucher))
                                                    {{-- @dd($registrant->payment_voucher) --}}
                                                    @php
                                                        $explodeFileName = explode('.', $registrant->payment_voucher);
                                                    @endphp
                                                    @if ($explodeFileName[1] == 'pdf')
                                                        <a href="{{ asset('storage/conference/registration/payment-voucher/' . $registrant->payment_voucher) }}"
                                                            target="_blank"><img
                                                                src="{{ asset('default-images/pdf.png') }}" alt="voucher"
                                                                height="50" width="40"></a>
                                                    @else
                                                        <a href="{{ asset('storage/conference/registration/payment-voucher/' . $registrant->payment_voucher) }}"
                                                            target="_blank"><img
                                                                src="{{ asset('storage/conference/registration/payment-voucher/' . $registrant->payment_voucher) }}"
                                                                alt="voucher" height="50" width="40"></a>
                                                    @endif
                                                @else
                                                    Registered By Admin
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $registrant->transaction_id }}</td>
                                        <td>{{ $registrant->total_attendee }}<br>
                                            <button class="btn btn-sm btn-primary addPerson mt-1"
                                                data-id="{{ $registrant->id }}" data-toggle="modal"
                                                data-target="#openModal" type="submit">
                                                Add Person
                                            </button>
                                        </td>
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
                                            {{ $registrant->registration_id }}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-info viewData" type="button" title="View Data"
                                                data-id="{{ $registrant->id }}" data-toggle="modal"
                                                data-target="#openModal"><i class="nav-icon i-Eye"></i></button>
                                            @if ($registrant->verified_status == 1)
                                                <a href="{{ route('conference-registration.generateIndividualPass', [$registrant->id, $type]) }}"
                                                    class="btn btn-primary btn-sm mt-1" target="_blank"><i
                                                        class="nav-icon i-File"></i> Generate Pass</a>
                                            @endif
                                            <button class="btn btn-sm btn-primary convertToSpeaker mt-1"
                                                data-id="{{ $registrant->id }}" type="submit">
                                                @if ($type == 'attendees' || $type == 'invited-attendees')
                                                    Convert To Speaker 
                                                @else
                                                    Convert To Attendee 
                                                @endif
                                            </button>
                                            <a href="{{ route('conference-registration.generateCertificate', $registrant->token) }}" class="btn btn-primary btn-sm mt-1"><i class="nav-icon i-File"></i> Generate Certificate</a>
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

            $(document).on("click", ".addPerson", function(e) { 
                e.preventDefault();
                var url = '{{ route('conferenceRegistration.addPerson') }}';
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

            var participantType = '{{ $type }}';
            $(document).on("click", ".convertToSpeaker", function(e) {
                e.preventDefault();
                if (participantType == 'attendees' || participantType == 'invited-attendees') {
                    var title = 'Are you sure to convert an attendee to speaker?';
                } else {
                    var title = 'Are you sure to convert a speaker to an attendee?';
                }
                Swal.fire({
                    title: title,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Convert!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = '{{ route('conferenceRegistration.convertToSpeakerbyAdmin') }}';
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

            $('select[name="selected_delegate_type"]').on('change', function() {
                var selected = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{ route('conferenceRegistration.getDelegateType') }}",
                    data: {
                        selected: selected
                    },
                    success: function(response) {
                        console.log(response);

                        var memberTypeSelect = $('select[name="selected_member_type"]');
                        memberTypeSelect.empty();
                        memberTypeSelect.append(
                            '<option value="" hidden>-- Select Member Type --</option>');

                        $.each(response.memberTypes, function(index, memberType) {
                            memberTypeSelect.append('<option value="' + memberType.id +
                                '">' + memberType.type + '</option>');
                        });
                    }
                });
            });


            $('.export-excel-btn').on('click', function(event) {
                event.preventDefault();

                var delegateType = $('select[name="selected_delegate_type"]').val();
                var memberType = $('select[name="selected_member_type"]').val();
                var voucherAttached = $('select[name="selected_voucher_attached"]').val();

                var baseUrl = $(this).attr('data-url');

                // Construct query parameters
                var queryParams =
                    `?delegate_type=${delegateType}&member_type=${memberType}&voucher_attached=${voucherAttached}`;
                var finalUrl = baseUrl + queryParams;
                window.location.href = finalUrl;
            });

        });
    </script>
@endsection
