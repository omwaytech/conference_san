@extends('layouts.dash')

@section('title')
    Register Workshop
@endsection

@section('content')
    <div class="main-content">
        {{-- @if (!old())
            <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" id="modalContent">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Enter email address of user to fetch his/her data. <span class="text-danger">(For Signed Up Users)</span></h5>
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
            <h1>Register Workshop</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{route('workshop-registration.byAdminSubmit')}}" method="POST" id="onSiteRegisterForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="workshop_id">Workshop <code>*</code></label>
                                <select name="workshop_id" class="form-control" id="workshop_id">
                                    <option value="" hidden>-- Select Workshop --</option>
                                    @foreach ($workshops as $workshop)
                                        <option value="{{$workshop->id}}" @selected(old('workshop_id') == $workshop->id)>{{$workshop->title}}</option>
                                    @endforeach
                                </select>
                                @error('workshop_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="name_prefix_id">Name Prefix <code>*</code></label>
                                <select name="name_prefix_id" class="form-control" id="name_prefix_id">
                                    <option value="" hidden>-- Select Name Prefix --</option>
                                    @foreach ($prefixesAll as $prefix)
                                        <option value="{{$prefix->id}}" @selected(old('name_prefix_id') == $prefix->id)>{{$prefix->prefix}}</option>
                                    @endforeach
                                </select>
                                @error('name_prefix_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="f_name">First Name <code>*</code></label>
                                <input type="text" class="form-control @error('f_name') is-invalid @enderror" name="f_name" id="f_name" value="{{old('f_name')}}" placeholder="Enter first name" />
                                @error('f_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="m_name">Middle Name </label>
                                <input type="text" class="form-control @error('m_name') is-invalid @enderror" name="m_name" id="m_name" value="{{old('m_name')}}" placeholder="Enter first name" />
                                @error('m_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="l_name">Last Name <code>*</code></label>
                                <input type="text" class="form-control @error('l_name') is-invalid @enderror" name="l_name" id="l_name" value="{{old('l_name')}}" placeholder="Enter first name" />
                                @error('l_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email <code>*</code></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email')}}" placeholder="Enter email" />
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="phone">Phone <code>*</code></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{old('phone')}}" placeholder="Enter phone" />
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="institute_name">Institute Name <code>*</code></label>
                                <input type="text" class="form-control @error('institute_name') is-invalid @enderror" name="institute_name" id="institute_name" value="{{old('institute_name')}}" placeholder="Enter institute name" />
                                @error('institute_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="address">Institute Address <code>*</code></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{old('address')}}" placeholder="Enter institute address" />
                                @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="affiliation">Affiliation <code>*</code></label>
                                <input type="text" class="form-control @error('affiliation') is-invalid @enderror" name="affiliation" id="affiliation" value="{{old('affiliation')}}" placeholder="Enter affiliation" />
                                @error('affiliation')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="council_number">Council Number <code id="councilNumberRequired">*</code></label>
                                <input type="text" class="form-control @error('council_number') is-invalid @enderror" name="council_number" id="council_number" value="{{old('council_number')}}" placeholder="Enter nesog number" />
                                @error('council_number')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="country_id">Country <code>*</code></label>
                                <select class="form-control" name="country_id" id="country_id">
                                    <option value="">-- Select Country --</option>
                                    @foreach ($countries as $country)
                                        <option value="{{$country->id}}" @selected(old('country_id') == $country->id)>{{$country->country_name}}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <p class="text-danger">{{$message}}</p>
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
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="member_type_id">Member Type <code>*</code></label>
                                <select name="member_type_id" class="form-control member_type_id" id="memberTypes"></select>
                                @error('member_type_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3" hidden id="memberShipNumberDiv">
                                <label for="san_number">Membership Number <code>*</code></label>
                                <input type="text" class="form-control" name="san_number" id="san_number" value="{{!empty(old('san_number')) ? old('san_number') : @$user->userDetail->san_number}}" required>
                                @error('san_number')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="payment_voucher">Payment Voucher <code>(Only JPG/PNG/PDF) (Max: 250 KB)</code></label>
                                <input type="file" class="form-control @error('payment_voucher') is-invalid @enderror"
                                    name="payment_voucher" id="image2" />
                                @error('payment_voucher')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="row" id="imgPreview2"></div>
                            </div>
                            <div class="col-md-4 form-group mb-3" id="hideDiv">
                                <label for="transaction_id">Transaction ID/Bill No/Reference Code <code>*</code></label>
                                <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" name="transaction_id" id="transaction_id" value="{{old('transaction_id')}}" placeholder="Enter transaction id or bill number" />
                                @error('transaction_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3 speakerAdditionalSection" hidden>
                                <label for="image">Image <code>* (Only JPG/PNG) (Max: 500
                                        KB)</code></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    name="image" id="image" />
                                @error('image')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($conference_registration))
                                        <div class="col-3 mt-2">
                                            <a href="{{ asset('storage/users/' . $conference_registration->user->userDetail->image) }}"
                                                target="_blank"><img
                                                    src="{{ asset('storage/users/' . $conference_registration->user->userDetail->image) }}"
                                                    alt="image" class="img-fluid"></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3 speakerAdditionalSection" hidden>
                                <label for="description">Description <code>*</code></label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{isset($participant) ? $participant->description : old('description')}}</textarea>
                                @error('description')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
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
    <script>
        $(document).ready(function () {
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

            $("#invited_guest").change(function (e) {
                e.preventDefault();
                if ($(this).is(":checked")) {
                    $('#hideDiv').attr('hidden', true)
                    $('#councilNumberRequired').text('')
                } else {
                    $('#hideDiv').attr('hidden', false)
                    $('#councilNumberRequired').text('*')
                }
            });
            $("#invited_guest").trigger('change');

            // $("#delegate").change(function(e) {
            //     e.preventDefault();
            //     $("#memberShipNumberDiv").attr('hidden', true);
            //     var selectedDelegate = $(this).val();
            //     var memberTypeId = '{{ old('member_type_id') }}';
            //     if (selectedDelegate == "International") {
            //         $("#countryDiv").attr('hidden', false);
            //     } else {
            //         $("#countryDiv").attr('hidden', true);
            //     }
            //     $.ajax({
            //         type: 'POST',
            //         url: '{{ route('front.getMemberTypes') }}',
            //         data: {
            //             selectedDelegate: selectedDelegate
            //         },
            //         success: function(response) {
            //             var memberTypes = $('#memberTypes');
            //             memberTypes.empty();
            //             if (response.type == 'success') {
            //                 var data = response.data.types;
            //                 var optionsHtml = '<option value="" hidden>-- Select Member Type --</option>';
            //                 $.each(data, function(index, item) {
            //                     var selected = (item.id == memberTypeId) ? 'selected' : '';
            //                     optionsHtml += '<option value="' + item.id + '" ' + selected + '>' + item.type + '</option>';
            //                 });
            //                 memberTypes.append(optionsHtml);
            //             }
            //         }
            //     });
            // });
            // $("#delegate").trigger('change');
            $("#country_id").change(function (e) {
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
                        $("#memberShipNumberDiv").attr('hidden', true);
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
                                    var optionsHtml = '<option value="" hidden>-- Select Member Type --</option>';
                                    $.each(data, function(index, item) {
                                        var selected = (item.id == memberTypeId) ? 'selected' : '';
                                        optionsHtml += '<option value="' + item.id + '" ' + selected + '>' + item.type + '</option>';
                                    });
                                    memberTypes.append(optionsHtml);

                                    $("#memberTypes").change(function (e) {
                                        e.preventDefault();
                                        var memberTypeId = $(this).val();
                                        if (memberTypeId == 1 || memberTypeId == 2) {
                                            $("#memberShipNumberDiv").attr('hidden', false);
                                        } else {
                                            $("#memberShipNumberDiv").attr('hidden', true);
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

            $("#memberTypes").change(function (e) {
                e.preventDefault();
                var memberTypeId = $(this).val();
                if (memberTypeId == 1) {
                    $("#memberShipNumberDiv").attr('hidden', false);
                } else if (memberTypeId == 2 || memberTypeId == 3) {
                    $("#memberShipNumberDiv").attr('hidden', true);
                } else if (memberTypeId == 4 || memberTypeId == 5) {
                    $("#memberShipNumberDiv").attr('hidden', true);
                }
            });
            $("#memberTypes").trigger('change');

            $(".numericValue").on("keydown", function(event) {
                // Allow backspace, delete, tab, escape, and enter keys
                if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
                    // Allow Ctrl+A
                    (event.keyCode == 65 && event.ctrlKey === true) ||
                    // Allow home, end, left, right
                    (event.keyCode >= 35 && event.keyCode <= 39) ||
                    // Allow numbers from the main keyboard (0-9) and the numpad (96-105)
                    (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
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

            $("#submitButton").click(function (e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#onSiteRegisterForm").submit();
            });

            $("#fetchData").click(function (e) {
                e.preventDefault();
                var url = '{{route('conferenceRegistration.fetchUserData')}}';
                var email = $("#userEmail").val();
                var data = { email:email };
                $.post(url, data, function (response) {
                    $('#openModal').modal('hide');
                    if (response.user != null) {
                        toastr.success('User data fetched successfully.');
                        $("#f_name").val(response.user.f_name);
                        $("#m_name").val(response.user.m_name);
                        $("#l_name").val(response.user.l_name);
                        $("#email").val(response.user.email);
                        $("#phone").val(response.userDetail.phone);
                        $("#institute_name").val(response.userDetail.institute_name);
                        $("#address").val(response.userDetail.address);
                        $("#affiliation").val(response.userDetail.affiliation);
                        $("#council_number").val(response.userDetail.council_number);
                        $("#delegate").val(response.delegate);
                        $("#delegate").trigger('change');
                        $("#countryDiv").trigger('change');
                        $("#memberTypes").val(response.type);
                        $("#country_id").val(response.country);
                        $("#country_id").trigger('change');
                        $("#memberTypes").val(response.member_type_id);
                    } else {
                        toastr.error('User has not signed up yet.');
                        $("#email").val(email);
                    }
                });
            });
        });
    </script>
@endsection
