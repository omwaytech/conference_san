@extends('layouts.dash')

@section('title')
    Conference Registration
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Conference Registration For Exceptional Case</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('conferenceRegistration.registerExceptionalCaseSubmit') }}" method="POST"
                        id="onSiteRegisterForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="user_id">User <code>*</code></label>
                                <select class="form-control" name="user_id" id="user_id">
                                    <option value="">-- Select User --</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                            {{ $user->fullName($user) }} ({{ $user->userDetail->council_number ?? null }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
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
                                <input type="text" class="form-control" name="transaction_id" id="transaction_id"
                                    value="{{ old('transaction_id') }}" placeholder="Enter transaction id or bill number" />
                                @error('transaction_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
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
                            <div class="col-md-4 form-group mb-3">
                                <label for="payment_voucher">Payment Voucher <code>* (Only JPG/PNG/PDF) (Max:
                                        250
                                        KB)</code></label>
                                <input type="file" class="form-control @error('payment_voucher') is-invalid @enderror"
                                    name="payment_voucher" id="image" />
                                @error('payment_voucher')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                </div>
                            </div>

                            <div class="col-md-4 form-group mb-3 hideDiv">
                                <label for="is_paid">Is Paid <code>*</code></label>
                                <select name="is_paid" id="is_paid"
                                    class="form-control @error('is_paid') is-invalid @enderror">
                                    <option value="">-- Select Is Paid --</option>
                                    <option value="1" @selected(old('is_paid') == 1)>Yes</option>
                                    <option value="2" @selected(old('is_paid') == 2)>No</option>
                                </select>
                                @error('is_paid')
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
                                <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
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
            $('#user_id').select2();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
