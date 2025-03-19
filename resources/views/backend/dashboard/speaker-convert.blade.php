@extends('layouts.dash')

@section('title')
    Convert To Speaker
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Convert To Speaker</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{route('conference-registration.convertToSpeakerSubmit')}}" method="POST" id="onSiteRegisterForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
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
                            <div class="col-md-12 form-group mb-3">
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

            $("#delegate").change(function(e) {
                e.preventDefault();
                $("#nesogNumberDiv").attr('hidden', true);
                var selectedDelegate = $(this).val();
                var memberTypeId = '{{ old('member_type_id') }}';
                if (selectedDelegate == "International") {
                    $("#countryDiv").attr('hidden', false);
                } else {
                    $("#countryDiv").attr('hidden', true);
                }
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
                        }
                    }
                });
            });
            $("#delegate").trigger('change');

            $("#memberTypes").change(function (e) {
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
        });
    </script>
@endsection
