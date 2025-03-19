@extends('layouts.dash')

@section('title')
    Register Conference
@endsection

@section('content')
    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-sm" style="margin-top: 100px">
            <div class="modal-content" id="modalContent">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Submitting your registration.....</h5>
                    </div>
                    <div class="modal-body text-center">
                        <div class="spinner-bubble spinner-bubble-primary m-5"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Register Conference</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        @php
                            $onlinePayment = session()->get('onlinePayment');
                            // dd($onlinePayment);
                        @endphp
                        <div class="card-body">
                            <form action="{{ route('conference-registration.submit') }}" method="POST"
                                id="registrationForm" enctype="multipart/form-data">
                                @csrf
                                @isset($conference_registration)
                                    @method('patch')
                                @endisset
                                <input type="hidden" name="registrant_type"
                                    value="{{ $onlinePayment['registrant_type'] }}">
                                <input type="hidden" name="accompany_person"
                                    value="{{ $onlinePayment['accompany_person'] }}">
                                <div class="row">
                                    <h3 class="col-md-12"><code>Conference Registration Form:</code></h3>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="transaction_id">Transaction ID/Bill No./Reference Code
                                            <code>*</code></label>
                                        <input type="text"
                                            class="form-control @error('transaction_id') is-invalid @enderror"
                                            name="transaction_id" id="transaction_id"
                                            value="{{ old('transaction_id') ? old('transaction_id') : $transactionId }}"
                                            placeholder="Enter transaction id" readonly />
                                        @error('transaction_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="amount">Amount
                                            <code>*
                                                ({{ auth()->user()->userDetail->country->country_name == 'Nepal' ? 'Rs.' : '$' }})</code></label>
                                        <input type="text" class="form-control @error('amount') is-invalid @enderror"
                                            name="amount" id="amount"
                                            value="{{ old('amount') ? old('amount') : $onlinePayment['amount'] }}"
                                            placeholder="Enter transaction id" readonly />
                                        @error('amount')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        {{-- </div>
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
                                    @if ($onlinePayment['registrant_type'] == 2)
                                        <div class="col-md-12 form-group mb-3 ">
                                            <label for="description">Short CV Description<code>*</code></label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                                cols="30" rows="10">{{ isset($conference_registration) ? $conference_registration->description : old('description') }}</textarea>
                                            @error('description')
                                                <p class="text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    @endif
                                    @if (!empty($onlinePayment['accompany_person']))
                                        <div class="col-12">
                                            <h5>Accompany Persons Detail
                                                <code>({{ $onlinePayment['accompany_person'] }})</code>: </h5>
                                        </div>
                                        @for ($i = 0; $i < $onlinePayment['accompany_person']; $i++)
                                            <div class="col-md-7 form-group mb-3">
                                                <label for="person_name">Name <code>*</code></label>
                                                <input type="text" class="form-control" name="person_name[]"
                                                    value="{{ old('person_name') ? old('person_name')[$i] : '' }}"
                                                    placeholder="Enter accompany person name" required />
                                                @error('person_name.' . $i)
                                                    <p class="text-danger">Accompany Person Name is required.</p>
                                                @enderror
                                            </div>
                                        @endfor
                                    @endif --}}
                                        <div class="col-md-12">
                                            <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                            <a href="{{ route('conference-registration.index') }}"
                                                class="btn btn-danger">Cancel</a>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    @if (!old())
        <script>
            toastr.success('Your payment is success. Now please proceed further for registration.');
        </script>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                var error = '{{ $error }}';
                toastr.error(error);
            </script>
        @endforeach
    @endif

    <script>
        $(document).ready(function() {
            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#registrationForm").submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#openModal").modal('show');

            // $("#submitButton").click(function(e) {
            //     e.preventDefault();
            //     $(this).attr('disabled', true);
            // });
            $("#registrationForm").submit();

            $("#registrant_type").change(function(e) {
                e.preventDefault();
                if ($(this).val() == 2) {
                    $(".speakerAdditionalSection").attr('hidden', false);
                } else {
                    $(".speakerAdditionalSection").attr('hidden', true);
                }
            });
            $("#registrant_type").trigger("change");
        });
    </script>
@endsection
