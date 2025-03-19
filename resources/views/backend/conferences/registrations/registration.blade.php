@extends('layouts.dash')

@section('title')
    Add Registration/Invitations
@endsection

@section('content')
    <div class="main-content">
        {{-- @if (!old())
            <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" id="modalContent"> 
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Enter email address of user to fetch his/her data. <span class="text-danger"></span></h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <form id="verifyForm">
                                @csrf
                                <div class="row">
                                    <input type="hidden" id="registrationId" name="id" value="">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="email">User's Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="userEmail" placeholder="Enter user's email address">
                                        <p class="text-danger email"></p>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" id="fetchData" class="btn btn-primary">Fetch Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}
        <div class="breadcrumb">
            <h1>Add Registration/Invitations
                ({{ !empty($latestConference) ? $latestConference->conference_theme : 'No any conference added yet.' }})
            </h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('conferenceRegistration.byAdminSubmit') }}" method="POST" id="onSiteRegisterForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-2 form-check mb-3">
                                <input type="checkbox" class="form-check-input" name="invited_guest" id="invited_guest"
                                    value="1" @if (old('invited_guest') == 1) checked @endif />
                                <label for="invited_guest" class="form-check-label">Is Invited Guest ? </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name_prefix_id">Name Prefix <code>*</code></label>
                                <select name="name_prefix_id" class="form-control" id="name_prefix_id">
                                    <option value="" hidden>-- Select Name Prefix --</option>
                                    @foreach ($prefixesAll as $prefix)
                                        <option value="{{ $prefix->id }}" @selected(old('name_prefix_id') == $prefix->id)>
                                            {{ $prefix->prefix }}</option>
                                    @endforeach
                                </select>
                                @error('name_prefix_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="gender">Select Gender <code>*</code></label><br>
                                <span class="mr-3">
                                    <input type="radio" @if (old('gender') == 'M') checked @endif id="male"
                                        name="gender" value="M">
                                    <label for="male">Male</label>
                                </span>
                                <span class="mr-3">
                                    <input type="radio" @if (old('gender') == 'F') checked @endif id="female"
                                        name="gender" value="F">
                                    <label for="female">Female</label>
                                </span>
                                <input type="radio" @if (old('gender') == 'O') checked @endif id="other"
                                    name="gender" value="O">
                                <label for="other">Other</label>
                                @error('gender')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="f_name">First Name <code>*</code></label>
                                <input type="text" class="form-control @error('f_name') is-invalid @enderror"
                                    name="f_name" id="f_name" value="{{ old('f_name') }}"
                                    placeholder="Enter first name" />
                                @error('f_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="m_name">Middle Name </label>
                                <input type="text" class="form-control @error('m_name') is-invalid @enderror"
                                    name="m_name" id="m_name" value="{{ old('m_name') }}"
                                    placeholder="Enter middle name" />
                                @error('m_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="l_name">Last Name <code>*</code></label>
                                <input type="text" class="form-control @error('l_name') is-invalid @enderror"
                                    name="l_name" id="l_name" value="{{ old('l_name') }}"
                                    placeholder="Enter last name" />
                                @error('l_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email <code>*</code></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') }}" placeholder="Enter email" />
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="phone">Phone <code>*</code></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" id="phone" value="{{ old('phone') }}" placeholder="Enter phone" />
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="council_number">Council Number <code id="councilNumberRequired">*</code></label>
                                <input type="text" class="form-control @error('council_number') is-invalid @enderror"
                                    name="council_number" id="council_number" value="{{ old('council_number') }}"
                                    placeholder="Enter nesog number" />
                                @error('council_number')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="country_id">Country <code>*</code></label>
                                <select class="form-control" name="country_id" id="country_id">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" @selected(old('country_id') == $country->id)>
                                            {{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3" hidden>
                                <label for="delegate">Delegate <code>*</code></label>
                                <select name="delegate" class="form-control selectDelegateAdmin" id="delegate">
                                    <option value="" hidden>-- Select Delegate --</option>
                                    <option value="National" @selected(old('delegate') == 'National')>National</option>
                                    <option value="International" @selected(old('delegate') == 'International')>International</option>
                                </select>
                                @error('delegate')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="member_type_id">Member Type <code>*</code></label>
                                <select name="member_type_id" class="form-control member_type_id"
                                    id="memberTypes"></select>
                                @error('member_type_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3" hidden id="memberShipNumberDiv">
                                <label for="san_number">Membership Number <code>*</code></label>
                                <input type="text" class="form-control" name="san_number" id="san_number"
                                    value="{{ !empty(old('san_number')) ? old('san_number') : @$user->userDetail->san_number }}"
                                    required>
                                @error('san_number')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="registrant_type">Registrant Type <code>*</code></label>
                                <select name="registrant_type" class="form-control" id="registrant_type">
                                    <option value="" hidden>-- Select Registrant Type --</option>
                                    <option value="1" @selected(old('registrant_type') == '1')>Attendee</option>
                                    <option value="2" @selected(old('registrant_type') == '2')>Speaker/Presenter</option>
                                </select>
                                @error('registrant_type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3 hideDiv">
                                <label for="transaction_id">Transaction ID/Bill No/Reference Code <code>*</code></label>
                                <input type="text" class="form-control @error('transaction_id') is-invalid @enderror"
                                    name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}"
                                    placeholder="Enter transaction id or bill number" />
                                @error('transaction_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3 hideDiv">
                                <label for="amount">Amount <code>*</code></label>
                                <input type="text" class="form-control" name="amount" id="amount"
                                    value="{{ !empty(old('amount')) ? old('amount') : @$user->userDetail->amount }}"
                                    placeholder="Enter Amount" required>
                                @error('amount')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="meal_type">Meal Preference <code>*</code></label>
                                <select name="meal_type" class="form-control" id="meal_type">
                                    <option value="" hidden>-- Select Veg/Non-veg --</option>
                                    <option value="1"
                                        @if (isset($conference_registration)) {{ $conference_registration->meal_type == '1' ? 'selected' : '' }} @else @selected(old('meal_type') == '1') @endif>
                                        Veg</option>
                                    <option value="2"
                                        @if (isset($conference_registration)) {{ $conference_registration->meal_type == '2' ? 'selected' : '' }} @else @selected(old('meal_type') == '2') @endif>
                                        Non-veg</option>
                                </select>
                                @error('meal_type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="additional_guests">Number Of Guests <code>(Excluding Registrant)</code></label>
                                <select name="additional_guests" id="additional_guests"
                                    class="form-control @error('additional_guests') is-invalid @enderror">
                                    <option value="">-- Select Number Of Guests --</option>
                                    <option value="1" @selected(old('additional_guests') == 1)>1</option>
                                    <option value="2" @selected(old('additional_guests') == 2)>2</option>
                                    <option value="3" @selected(old('additional_guests') == 3)>3</option>
                                    <option value="4" @selected(old('additional_guests') == 4)>4</option>
                                    <option value="5" @selected(old('additional_guests') == 5)>5</option>
                                </select>
                                @error('additional_guests')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3 hideDiv">
                                <label for="payment_voucher">Payment Voucher <code>(Only JPG/PNG/PDF) (Max: 250
                                        KB)</code></label>
                                <input type="file" class="form-control @error('payment_voucher') is-invalid @enderror"
                                    name="payment_voucher" id="image2" />
                                @error('payment_voucher')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="row" id="imgPreview2"></div>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="affiliation">Institute Designation</label>
                                <input type="text" class="form-control" name="affiliation" id="affiliation"
                                    value="{{ !empty(old('affiliation')) ? old('affiliation') : @$user->userDetail->affiliation }}"
                                    required>
                                @error('affiliation')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" name="department" id="department"
                                    value="{{ !empty(old('department')) ? old('department') : @$user->userDetail->department }}"
                                    required>
                                @error('department')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="institute_name">Institute Name</label>
                                <input type="text" class="form-control" name="institute_name" id="institute_name"
                                    value="{{ !empty(old('institute_name')) ? old('institute_name') : @$user->userDetail->institute_name }}"
                                    required>
                                @error('institute_name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="address">Institute Address</label>
                                <input type="text" class="form-control" name="address" id="address"
                                    value="{{ !empty(old('address')) ? old('address') : @$user->userDetail->address }}"
                                    required>
                                @error('address')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3 speakerAdditionalSection" hidden>
                                <label for="description">Short CV Description <code>*</code></label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{ isset($participant) ? $participant->description : old('description') }}</textarea>
                                @error('description')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="row" id="accompanyPersonsDetail">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" id="submitButton" class="btn btn-primary"
                                    {{ empty($latestConference) ? 'disabled' : '' }}>Submit</button>
                                <button type="reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (old('person_name'))
        <script>
            var personsValue = @json(old('person_name', []));
            var errorMessages = @json($errors->get('person_name.*'));
        </script>
    @else
        <script>
            var personsValue = @json([]);
            var errorMessages = @json([]);
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#openModal').modal('show');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".timepicker").timepicker({
                step: 15,
                minTime: '06:00am',
            });

            $("#invited_guest").change(function(e) {
                e.preventDefault();
                if ($(this).is(":checked")) {
                    $('.hideDiv').attr('hidden', true)
                    $('#councilNumberRequired').text('')
                } else {
                    $('.hideDiv').attr('hidden', false)
                    $('#councilNumberRequired').text('*')
                }
            });
            $("#invited_guest").trigger('change');

            $("#country_id").change(function(e) {
                e.preventDefault();
                var countryId = $(this).val();
                if (countryId != '') {
                    if (countryId == 125) {
                        $("#delegate").val("National");
                    } else {
                        $("#delegate").val("International");
                    }
                    $("#delegate").change(function(e) {
                        e.preventDefault();
                        $("#nesogNumberDiv").attr('hidden', true);
                        var selectedDelegate = $(this).val();
                        var memberTypeId = '{{ old('member_type_id') }}';
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('front.getMemberTypes') }}',
                            data: {
                                selectedDelegate: selectedDelegate
                            },
                            success: function(response) {
                                var memberTypes = $('#memberTypes');
                                memberTypes.empty();
                                if (response.type == 'success') {
                                    var data = response.data.types;
                                    var optionsHtml =
                                        '<option value="" hidden>-- Select Member Type --</option>';
                                    $.each(data, function(index, item) {
                                        var selected = (item.id ==
                                            memberTypeId) ? 'selected' : '';
                                        optionsHtml += '<option value="' + item
                                            .id + '" ' + selected + '>' + item
                                            .type + '</option>';
                                    });
                                    memberTypes.append(optionsHtml);

                                    $("#memberTypes").change(function(e) {
                                        e.preventDefault();
                                        var memberTypeId = $(this).val();
                                        if (memberTypeId == 1 || memberTypeId ==
                                            2) {
                                            $("#memberShipNumberDiv").attr(
                                                'hidden', false);
                                        } else {
                                            $("#memberShipNumberDiv").attr(
                                                'hidden', true);
                                        }
                                    });
                                    $("#memberTypes").trigger('change');
                                }
                            }
                        });
                    });
                    $("#delegate").trigger('change');
                }
            });
            $("#country_id").trigger('change');


            $("#memberTypes").change(function(e) {
                e.preventDefault();
                var memberTypeId = $(this).val();
                if (memberTypeId == 1) {
                    $("#nesogNumberDiv").attr('hidden', false);
                } else if (memberTypeId == 2 || memberTypeId == 3) {
                    $("#nesogNumberDiv").attr('hidden', true);
                } else if (memberTypeId == 4 || memberTypeId == 5) {
                    $("#nesogNumberDiv").attr('hidden', true);
                }
            });
            $("#memberTypes").trigger('change');

            $(".numericValue").on("keydown", function(event) {
                // Allow backspace, delete, tab, escape, and enter keys
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode ==
                    27 || event.keyCode == 13 ||
                    // Allow Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow home, end, left, right
                    (event.keyCode >= 35 && event.keyCode <= 39) ||
                    // Allow numbers from the main keyboard (0-9) and the numpad (96-105)
                    (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <=
                        105)) {
                    return;
                } else {
                    event.preventDefault();
                }
            });

            $("#registrant_type").change(function(e) {
                e.preventDefault();
                if ($(this).val() == 2) {
                    $(".speakerAdditionalSection").attr('hidden', false);
                } else {
                    $(".speakerAdditionalSection").attr('hidden', true);
                }
            });
            $("#registrant_type").trigger("change");

            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#onSiteRegisterForm").submit();
            });

            $("#fetchData").click(function(e) {
                e.preventDefault();
                var url = '{{ route('conferenceRegistration.fetchUserData') }}';
                var email = $("#userEmail").val();
                var data = {
                    email: email
                };
                $.post(url, data, function(response) {
                    $('#openModal').modal('hide');
                    if (response.user != null) {
                        toastr.success('User data fetched successfully.');
                        $("#name").val(response.user.name);
                        $("#email").val(response.user.email);
                        $("#phone").val(response.userDetail.phone);
                        $("#institute_name").val(response.userDetail.institute_name);
                        $("#address").val(response.userDetail.address);
                        $("#affiliation").val(response.userDetail.affiliation);
                        $("#council_number").val(response.userDetail.council_number);
                        $("#delegate").val(response.delegate);
                        $("#delegate").trigger('change');
                        $("#memberTypes").val(response.type);
                        $("#country_id").val(response.country);
                    } else {
                        toastr.error('User has not signed up yet.');
                        $("#email").val(email);
                    }
                });
            });

            $("#additional_guests").change(function(e) {
                $("#accompanyPersonsDetail").empty();
                var totalAccompanyPersons = $(this).val();
                if (totalAccompanyPersons >= 1) {
                    var title =
                        '<div class="col-md-12 mt-3"><h3 class="text-danger">Accompanying Person Details:</h3><h5 class="text-danger">Note: All names are reuired</h5></div>';
                    $("#accompanyPersonsDetail").append(title);
                    for (let index = 0; index < totalAccompanyPersons; index++) {
                        var oldValue = personsValue[index] || '';
                        var errorMessage = errorMessages['person_name.' + index] ? errorMessages[
                            'person_name.' + index][0] : '';;
                        var htmlCode = '<div class="col-md-7 form-group mb-3">' +
                            '<label for="person_name">Name <code>*</code></label>' +
                            '<input type="text" class="form-control" name="person_name[]" value="' +
                            oldValue + '" placeholder="Enter accompany person name" required/>' +
                            '<p class="text-danger">' + errorMessage + '</p>' +
                            '</div>';

                        $("#accompanyPersonsDetail").append(htmlCode);
                    }
                }
            });
            $("#additional_guests").trigger("change");
        });
    </script>
@endsection
