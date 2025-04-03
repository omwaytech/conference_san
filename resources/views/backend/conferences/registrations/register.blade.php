@extends('layouts.dash')

@section('title')
    {{ isset($conference_registration) ? 'Edit Conference Registration' : 'Register Conference' }}
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{ isset($conference_registration) ? 'Edit Conference Registration' : 'Register Conference' }}
                ({{ !empty($latestConference) ? $latestConference->conference_theme : 'No any conference added yet.' }})
            </h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form
                                action="{{ isset($conference_registration) ? route('conference-registration.update', $conference_registration->id) : route('conference-registration.store') }}"
                                method="POST" id="registrationForm" enctype="multipart/form-data">
                                @csrf
                                @isset($conference_registration)
                                    @method('patch')
                                @endisset
                                <div class="row">
                                    <h3 class="col-md-12" hidden>Registration Form:</h3>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="registrant_type">Registrant Type <code>*</code></label>
                                        <select name="registrant_type" class="form-control" id="registrant_type">
                                            <option value="" hidden>-- Select Registrant Type --</option>
                                            <option value="1"
                                                @if (isset($conference_registration)) {{ $conference_registration->registrant_type == '1' ? 'selected' : '' }} @else @selected(old('registrant_type') == '1') @endif>
                                                Attendee</option>
                                            <option value="2"
                                                @if (isset($conference_registration)) {{ $conference_registration->registrant_type == '2' ? 'selected' : '' }} @else @selected(old('registrant_type') == '2') @endif>
                                                Presenter/Speaker</option>
                                        </select>
                                        @error('registrant_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3"> <label for="transaction_id">Transaction ID/Bill
                                        No/Reference Code <code>*</code></label>
                                        <input type="text"
                                            class="form-control @error('transaction_id') is-invalid @enderror"
                                            name="transaction_id" id="transaction_id"
                                            value="{{ isset($conference_registration) ? $conference_registration->transaction_id : old('transaction_id') }}"
                                            placeholder="Enter transaction id" />
                                        @error('transaction_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="payment_voucher">Payment Voucher <code>* (Only JPG/PNG/PDF) (Max: 250
                                                KB)</code></label>
                                        <input type="file"
                                            class="form-control @error('payment_voucher') is-invalid @enderror"
                                            name="payment_voucher" id="image" />
                                        @error('payment_voucher')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <div class="row" id="imgPreview">
                                            @if (isset($conference_registration))
                                                <div class="col-3 mt-2">
                                                    @php
                                                        $explodeFileName = explode('.', $conference_registration->payment_voucher);
                                                    @endphp
                                                    @if ($explodeFileName[1] == 'pdf')
                                                        <a href="{{ asset('storage/conference/registration/payment-voucher/' . $conference_registration->payment_voucher) }}"
                                                            target="_blank"><img
                                                                src="{{ asset('default-images/pdf.png') }}"
                                                                alt="voucher" class="img-fluid"></a>
                                                    @else
                                                        <a href="{{ asset('storage/conference/registration/payment-voucher/' . $conference_registration->payment_voucher) }}"
                                                            target="_blank"><img
                                                                src="{{ asset('storage/conference/registration/payment-voucher/' . $conference_registration->payment_voucher) }}"
                                                                alt="voucher" class="img-fluid"></a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" id="submitButton" class="btn btn-primary"
                                            @if (empty($latestConference) || @$latestConference->regular_registration_deadline < date('Y-m-d')) disabled @endif>{{ isset($conference_registration) ? 'Update' : 'Submit' }}</button>
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
    <script>
        $(document).ready(function() {
            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#registrationForm").submit();
            });
        });
    </script>
@endsection
