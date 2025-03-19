@extends('layouts.dash')

@section('title')
    {{ isset($conference_registration) ? 'Edit Conference Registration' : 'Register Conference' }}
@endsection

@section('styles')
    <style>
        @keyframes blink {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        #paymentGuide {
            animation: blink 1s infinite;
            /* You can adjust the duration and iteration count */
        }
    </style>
@endsection

@section('content')
    @if (!old() && !isset($conference_registration))
        {{-- modal start --}}
        <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true" data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" id="modalContent">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Do you also want to present your submission
                                or just attend conference?</h5>
                        </div>
                        <div class="modal-body">
                            <form action="" id="chooseRegistratantType">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="registrantType">Registrant Type <code>*</code></label>
                                    <select name="registrant_type" class="form-control" id="registrantType">
                                        <option value="" hidden>-- Select Registrant Type --</option>
                                        <option value="1">Attendee</option>
                                        <option value="2">Speaker</option>
                                    </select>
                                    <button type="submit" id="chooseRegistrantButton"
                                        class="btn btn-primary mt-3">Submit</button>
                                    <a href="{{ route('home') }}" class="btn btn-danger mt-3">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal end --}}
    @endif

    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{ isset($conference_registration) ? 'Edit Conference Registration' : 'Register Conference' }}
                ({{ !empty($latestConference) ? $latestConference->conference_theme : 'No any conference added yet.' }})
            </h1>
        </div>
        @php
            $authUser = App\Models\User::whereId(auth()->user()->id)->first();
            $amount = '';
            if (!empty($latestConference)) {
                if ($latestConference->early_bird_registration_deadline >= date('Y-m-d')) {
                    $amount = !empty($memberTypePrice->early_bird_amount) ? $memberTypePrice->early_bird_amount : '';
                } elseif ($latestConference->regular_registration_deadline >= date('Y-m-d')) {
                    $amount = !empty($memberTypePrice->regular_amount) ? $memberTypePrice->regular_amount : '';
                }
            }
        @endphp
        <div class="separator-breadcrumb border-top"></div>
        <h5 class="text-danger text-center" id="paymentGuide" hidden>Please calculate price first for payment.</h5>
        <div class="col-md-12">
            <div>
                <h2>Modes of Payment:</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4 position-relative">
                            <label for="sbiBankRadio">
                                <h4 class="text-center mt-2" style="color: blue">Bank Transfer</h4>
                                <div class="text-center">
                                    <img src="{{ asset('default-images/sbi.png') }}" alt="sbi bank logo">
                                </div>
                                <div class="position-absolute" style="bottom: 40px; right: 20px;">
                                    <input class="form-check-input" type="radio" name="paymentMode" value="sbiBank"
                                        id="sbiBankRadio" style="transform: scale(2);">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 position-relative">
                            <label for="fonePayRadio">
                                <h4 class="text-center mt-2" style="color: blue">Online QR Scan</h4>
                                <div class="text-center">
                                    <img src="{{ asset('default-images/fonepay.png') }}" style="width: 70%;"
                                        alt="fonepay logo">
                                    <p>Cross Border Support</p>
                                </div>
                                <div class="position-absolute" style="bottom: 40px; right: 20px;">
                                    <input class="form-check-input" type="radio" name="paymentMode" value="fonePay"
                                        id="fonePayRadio" style="transform: scale(2);">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 position-relative">
                            <label for="dollarCardRadio">
                                <h4 class="text-center mt-2" style="color: blue">Dollar Card</h4>
                                <p style="padding-left: 10%;">We Accept</p>
                                <div class="text-center">
                                    <img src="{{ asset('default-images/dollar-card.png') }}" style="width: 70%;"
                                        alt="dollar card logo">
                                </div>
                                <div class="position-absolute" style="bottom: 40px; right: 20px;">
                                    <input class="form-check-input" type="radio" name="paymentMode" value="dollarCard"
                                        id="dollarCardRadio" style="transform: scale(2);">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="processingDiv" {{ !old() ? 'hidden' : '' }}>
                <div class="col-md-5">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="sbiProcessingDiv">
                                <h2><code>(For Manual Payment)</code> SBI bank details:</h2>
                                <p>
                                <h3>How to Pay the Registration fee from India?</h3>
                                <h5>1) Go to SBI online banking Platform </h5>
                                <h5>2) Choose International FUND transfer: India Nepal Remittance </h5>
                                <h5>3) Choose the Nepal SBI Bank Ltd (NSBL) option </h5>
                                <h5>4) Add the details of the Beneficiary </h5>
                                <b>Bank Name:</b> Nepal SBI Bank Ltd <br>
                                <b>Branch :</b> Newroad, Kathmandu <br>
                                <b>Account Name:</b> SOCIETY OF ANAESTHESIOLOGISTS OF NEPAL <br>
                                <b>Account No:</b> 17825240201046 <br>
                                <b>Swift code:</b> NSBINPKA <br>
                                <b>Address:</b> NMA building (Siddhi Sadan), Exhibition Road, Kathmandu Nepal.<br>
                                <b>Phone number:</b> +977 9841397587<br>
                                <b>Fax:</b> +977 9841397587<br>
                                <b>Email:</b> nepalanesthesiologists@gmail.com<br>
                                <b>Date of Birth:</b> 14th Nov, 1947<br>
                                <h4 class="text-success">NOTE: Bank charge is Rs 20 Indian Currency as the service charge.
                                    SAN will also receive the full amount of money. </h4>
                                </p><br>
                            </div>

                            @if (!old())
                                <div class="dollarCardProcessingDiv">
                                    <h2><code>(For Registration Via Card Payment)</code><br>Payment Through Dollar Card</h2>
                                    <p>We Accept<br>
                                        <img src="{{ asset('default-images/dollar-card.png') }}" height="40"><br>
                                    </p>
                                </div>
                                <div class="fonePayProcessingDiv">
                                    <h2><code>(For Registration Via Online QR Scan)</code><br>Payment Through QR Scan</h2>
                                    <img src="{{ asset('default-images/fonepay.png') }}" height="40">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form
                                action="{{ isset($conference_registration) ? route('conference-registration.update', $conference_registration->id) : route('conference-registration.store') }}"
                                method="POST" id="registrationForm" enctype="multipart/form-data">
                                @csrf
                                @isset($conference_registration)
                                    @method('patch')
                                @endisset
                                <div class="row mb-4">
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="total_attendee">Accompany Person <code>(Excluding
                                                You)</code></label>
                                        <select name="total_attendee" id="total_attendee"
                                            class="form-control @error('total_attendee') is-invalid @enderror">
                                            @if (!isset($conference_registration))
                                                <option value="">-- Select Number Of Guests --</option>
                                                <option value="0" @selected(old('total_attendee') === 0)>0</option>
                                                <option value="1" @selected(old('total_attendee') == 1)>1</option>
                                                <option value="2" @selected(old('total_attendee') == 2)>2</option>
                                                <option value="3" @selected(old('total_attendee') == 3)>3</option>
                                                <option value="4" @selected(old('total_attendee') == 4)>4</option>
                                                <option value="5" @selected(old('total_attendee') == 5)>5</option>
                                            @else
                                                @if ($conference_registration->total_attendee == 1)
                                                    <option value="">-- Select Number Of Guests --</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                @else
                                                    <option value="">-- Select Number Of Guests --</option>
                                                    <option value="1" @selected($conference_registration->total_attendee - 1 == 1)>1</option>
                                                    <option value="2" @selected($conference_registration->total_attendee - 1 == 2)>2</option>
                                                    <option value="3" @selected($conference_registration->total_attendee - 1 == 3)>3</option>
                                                    <option value="4" @selected($conference_registration->total_attendee - 1 == 4)>4</option>
                                                    <option value="5" @selected($conference_registration->total_attendee - 1 == 5)>5</option>
                                                @endif
                                            @endif
                                        </select>
                                        @error('total_attendee')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 form-group mt-4">
                                        <button id="calculatePrice" class="btn btn-primary"
                                            {{ empty($latestConference) ? 'disabled' : '' }}>Calculate Price</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="priceTable" hidden>
                                            <h4>Calculated Price: </h4>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Type</th>
                                                        <th>No. of Persons</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="calculatedData">
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr style="border-top: 3px solid red;">
                                    </div>

                                    <h3 class="col-md-12 sbiProcessingDiv"><code>Manual Registration Form:</code></h3>
                                    <div class="col-md-6 form-group mb-3 sbiProcessingDiv d-none" hidden>
                                        <label for="registrant_type">Registrant Type <code>*</code></label>
                                        <select name="registrant_type" class="form-control" id="registrant_type">
                                            <option value="" hidden>-- Select Registrant Type --</option>
                                            <option value="1"
                                                @if (isset($conference_registration)) {{ $conference_registration->registrant_type == '1' ? 'selected' : '' }} @else @selected(old('registrant_type') == '1') @endif>
                                                Attendee</option>
                                            <option value="2"
                                                @if (isset($conference_registration)) {{ $conference_registration->registrant_type == '2' ? 'selected' : '' }} @else @selected(old('registrant_type') == '2') @endif>
                                                Speaker</option>
                                        </select>
                                        @error('registrant_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3 sbiProcessingDiv">
                                        <label for="transaction_id">Transaction ID/Bill No./Reference Code
                                            <code>*</code></label>
                                        <input type="text"
                                            class="form-control @error('transaction_id') is-invalid @enderror"
                                            name="transaction_id" id="transaction_id"
                                            value="{{ isset($conference_registration) ? $conference_registration->transaction_id : old('transaction_id') }}"
                                            placeholder="Enter transaction id" />
                                        @error('transaction_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3 sbiProcessingDiv">
                                        <label for="payment_voucher">Payment Voucher <code>* (Only JPG/PNG/PDF) (Max:
                                                250
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
                                                        $explodeFileName = explode(
                                                            '.',
                                                            $conference_registration->payment_voucher,
                                                        );
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

                                    <div class="col-md-6 form-group mb-3 sbiProcessingDiv">
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
                                    <div class="col-md-12 form-group mb-3 speakerAdditionalSection sbiProcessingDiv">
                                        <label for="description">Short CV Description<code>*</code></label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                            cols="30" rows="10">{{ isset($conference_registration) ? $conference_registration->description : old('description') }}</textarea>
                                        @error('description')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 sbiProcessingDiv">
                                        <div class="row" id="accompanyPersonsDetail">

                                        </div>
                                    </div>
                                    <div class="col-md-12 sbiProcessingDiv">
                                        <button type="submit" id="submitButton" class="btn btn-primary"
                                            @if (empty($latestConference) || @$latestConference->regular_registration_deadline < date('Y-m-d')) disabled @endif>Submit</button>
                                        <a href="{{ route('conference-registration.index') }}"
                                            class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if (!old())
                            <div class="card-body">
                                <div class="fonePayProcessingDiv">
                                    <form action="{{ route('conference-registration.fonePay') }}" method="POST"
                                        enctype="multipart/form-data" id="fonePayForm">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="registrant_type" id="registrant_type_fonepay">
                                            <input type="hidden" name="accompany_person" id="accompany_person">
                                            <div class="col-md-12 form-group mb-3" hidden>
                                                <label for="amount">Amount
                                                    <code>* (Click on "Calculate Price" to get amount value)</code></label>
                                                <input type="text"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    name="amount" id="fonePayAmount"
                                                    value="{{ isset($conference_registration) ? $conference_registration->amount : old('amount') }}"
                                                    placeholder="Enter amount" readonly />
                                                @error('amount')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" id="submitFonePay" class="btn btn-primary mb-1"
                                                    disabled>Pay Now Via QR Scan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="dollarCardProcessingDiv">
                                    <form action="{{ route('conference-registration.onlinePayment') }}" method="POST"
                                        enctype="multipart/form-data" id="internationalPaymentForm">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="registrant_type"
                                                id="registrant_type_international">
                                            <input type="hidden" name="accompany_person" id="accompany_person_2">
                                            <div class="col-md-12 form-group mb-3" hidden>
                                                <label for="amount">Amount
                                                    <code>* (Click on "Calculate Price" to get amount value)</code></label>
                                                <input type="text"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    name="amount" id="internationalAmount"
                                                    value="{{ isset($conference_registration) ? $conference_registration->amount : old('amount') }}"
                                                    placeholder="Enter amount" readonly />
                                                @error('amount')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" id="submitButtonInternationalPayment"
                                                    class="btn btn-primary" disabled>Pay Now Via Dollar Card</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    @if ($checkPayment == 'failed')
        <script>
            toastr.error("Your payment has been failed.");
        </script>
    @endif

    @if ($checkPayment == 'cancelled')
        <script>
            toastr.error("Your payment has been cancelled.");
        </script>
    @endif

    @if ($checkPayment == 'terminated')
        <script>
            toastr.error("Your payment has been terminated.");
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

    @if (old('person_name'))
        <script>
            var personsValue = @json(old('person_name', []));
            var errorMessages = @json($errors->get('person_name.*'));
        </script>
    @elseif(isset($conference_registration) && $conference_registration->accompanyPersons->where('status', 1))
        @php
            $accompanyingPersons = $conference_registration->accompanyPersons
                ->where('status', 1)
                ->pluck('person_name')
                ->toArray();
        @endphp
        <script>
            var personsValue = @json($accompanyingPersons);
            var errorMessages = @json([]);
        </script>
    @else
        <script>
            var personsValue = @json([]);
            var errorMessages = @json([]);
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $("#openModal").modal('show');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#total_attendee").on("keydown", function(event) {
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

            var totalPrice = 0;

            $("#calculatePrice").click(function(e) {
                var selectedPaymentMode = $('input[name="paymentMode"]:checked').val();
                e.preventDefault();
                var registrationPrice = '{{ @$amount }}';
                var guestPrice = '{{ @$memberTypePrice->guest_amount }}';
                var additionalGuest = $("#total_attendee").val();
                var calculatedData = $("#calculatedData");
                var delegate = '{{ @$memberTypePrice->memberType->delegate }}';
                var currencyCondition = (delegate == 'National' ? 'Rs. ' : '$ ');
                var preTotalPrice = registrationPrice;
                var memberType = '{{ @$memberTypePrice->memberType->type }}';
                if (registrationPrice == '' || guestPrice == '') {
                    toastr.error("Price has not been updated by admin.");
                } else {
                    $("#priceTable").attr('hidden', false);
                    calculatedData.empty();
                    calculatedData.append('<tr>' +
                        '<td>1</td>' +
                        '<td>' + memberType + '</td>' +
                        '<td>1</td>' +
                        '<td>' + currencyCondition + registrationPrice + '</td>' +
                        '</tr>');
                    if (additionalGuest > 0) {
                        var guestsTotalPrice = additionalGuest * guestPrice;
                        if (selectedPaymentMode == 'sbiBank') {
                            preTotalPrice = parseInt(registrationPrice) + parseInt(guestsTotalPrice);
                            calculatedData.append('<tr>' +
                                '<td>2</td>' +
                                '<td>Additional Guests</td>' +
                                '<td>' + additionalGuest + '</td>' +
                                '<td>' + currencyCondition + guestsTotalPrice + '</td>' +
                                '</tr>');
                        } else if (selectedPaymentMode == 'fonePay') {
                            preTotalPrice = parseInt(registrationPrice) + parseInt(guestsTotalPrice);
                            calculatedData.append('<tr>' +
                                '<td>2</td>' +
                                '<td>Additional Guests</td>' +
                                '<td>' + additionalGuest + '</td>' +
                                '<td>' + currencyCondition + guestsTotalPrice + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>3</td>' +
                                '<td>Service Charge</td>' +
                                '<td></td>' +
                                '<td>1.65%</td>' +
                                '</tr>');
                        } else if (selectedPaymentMode == 'dollarCard') {
                            preTotalPrice = parseInt(registrationPrice) + parseInt(guestsTotalPrice);
                            var additionalCharge = preTotalPrice * 0.035;
                            totalPrice = parseInt(preTotalPrice) + additionalCharge;
                            calculatedData.append('<tr>' +
                                '<td>2</td>' +
                                '<td>Additional Guests</td>' +
                                '<td>' + additionalGuest + '</td>' +
                                '<td>' + currencyCondition + guestsTotalPrice + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>3</td>' +
                                '<td>Service Charge</td>' +
                                '<td></td>' +
                                '<td>' + currencyCondition + additionalCharge.toFixed(2) + '</td>' +
                                '</tr>');
                        }
                        var totalAttendee = parseInt(additionalGuest) + 1;
                    } else {
                        var totalAttendee = 1;
                        if (selectedPaymentMode == 'sbiBank') {
                            totalPrice = parseInt(preTotalPrice);
                        } else if (selectedPaymentMode == 'fonePay') {
                            totalPrice = parseInt(preTotalPrice);
                            calculatedData.append('<tr>' +
                                '<td>2</td>' +
                                '<td>Service Charge</td>' +
                                '<td></td>' +
                                '<td>1.65%</td>' +
                                '</tr>');
                        } else if (selectedPaymentMode == 'dollarCard') {
                            var additionalCharge = preTotalPrice * 0.035;
                            totalPrice = parseInt(preTotalPrice) + additionalCharge;
                            calculatedData.append('<tr>' +
                                '<td>2</td>' +
                                '<td>Service Charge</td>' +
                                '<td></td>' +
                                '<td>' + currencyCondition + additionalCharge.toFixed(2) + '</td>' +
                                '</tr>');
                            totalPrice = totalPrice.toFixed(2)
                        }
                    }


                    if (selectedPaymentMode == 'sbiBank' || selectedPaymentMode == 'fonePay') {
                        // convert usd to indian currency start
                        var indianFonePayUrl = '{{ route('conference-registration.convertUsdToInr') }}';
                        var currencyData = {
                            'usd': preTotalPrice,
                            'paymentMode': selectedPaymentMode
                        };
                        $.post(indianFonePayUrl, currencyData, function(response) {
                            console.log(response);
                            $("#fonePayAmount").val(response.amount);
                            if (response.type == 'success') {
                                inrAmount = response.amount;
                                calculatedData.append('<tr>' +
                                    '<td></td>' +
                                    '<td>Total</td>' +
                                    '<td>' + totalAttendee + '</td>' +
                                    '<td> INR ' + inrAmount + '</td>' +
                                    '</tr>');
                                $("#submitFonePay").attr('disabled', false);
                            } else {
                                toastr.error(response.message);
                                calculatedData.append('<tr>' +
                                    '<td></td>' +
                                    '<td>Total</td>' +
                                    '<td>' + totalAttendee + '</td>' +
                                    '<td> INR ' + totalPrice + '</td>' +
                                    '</tr>');
                            }
                        });
                        // convert usd to indian currency end
                    } else {
                        $("#internationalAmount").val(totalPrice);
                        $("#submitButtonInternationalPayment").attr('disabled', false);
                        calculatedData.append('<tr>' +
                            '<td></td>' +
                            '<td>Total</td>' +
                            '<td>' + totalAttendee + '</td>' +
                            '<td>' + currencyCondition + totalPrice + '</td>' +
                            '</tr>');
                    }

                }
            });

            $("#registrant_type").change(function(e) {
                e.preventDefault();
                if ($(this).val() == 2) {
                    $(".speakerAdditionalSection").removeClass('d-none');
                } else {
                    $(".speakerAdditionalSection").addClass('d-none');
                }
            });
            $("#registrant_type").trigger("change");

            $("#total_attendee").change(function(e) {
                $("#accompanyPersonsDetail").empty();
                var totalAccompanyPersons = $(this).val();
                $("#accompany_person").val(totalAccompanyPersons);
                $("#accompany_person_2").val(totalAccompanyPersons);
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
            $("#total_attendee").trigger("change");

            $("#chooseRegistrantButton").on('click', function(e) {
                e.preventDefault();
                var registrantValue = $("#registrantType").val();
                if (registrantValue == '') {
                    toastr.error('Select one value to continue.');
                } else if (registrantValue == 1) {
                    $("#openModal").modal('hide');
                    $('#registrant_type').val('1');
                    $('#registrant_type_fonepay').val('1');
                    $('#registrant_type_international').val('1');
                } else {
                    var data = new FormData($('#chooseRegistratantType')[0]);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{ route('conference-registration.chooseRegistrantType') }}',
                        data: data,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('#chooseRegistrantButton').attr('disabled', true);
                            $('#chooseRegistrantButton').append(
                                '<span class="spinner spinner-danger ml-2" style="height: 17px; width: 17px;"></span>'
                            );
                        },
                        success: function(response) {
                            $('#chooseRegistrantButton').attr('disabled', false);
                            $('#chooseRegistrantButton').text('Submit');
                            if (response.checkSubmission == 'not-submitted') {
                                toastr.error('Submit your presentation');
                                setTimeout(function() {
                                    window.location.href =
                                        '{{ route('submission.create') }}';
                                }, 1000);
                            } else {
                                $("#openModal").modal('hide');
                                $('#registrant_type').val('2');
                                $("#registrant_type").trigger("change");
                                $('#registrant_type_fonepay').val('2');
                                $('#registrant_type_international').val('2');
                            }
                        }
                    });
                }
            });

            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#registrationForm").submit();
            });

            $("#submitButtonInternationalPayment").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#internationalPaymentForm").submit();
            });

            $('input[name="paymentMode"]').change(function() {
                var selectedValue = $(this).val();
                $("#processingDiv").attr('hidden', false);
                $(".sbiProcessingDiv").attr('hidden', true);
                $(".dollarCardProcessingDiv").attr('hidden', true);
                $(".fonePayProcessingDiv").attr('hidden', true);
                if (selectedValue == "sbiBank") {
                    $(".sbiProcessingDiv").attr('hidden', false);
                } else if (selectedValue == "fonePay") {
                    $(".fonePayProcessingDiv").attr('hidden', false);
                } else if (selectedValue == "dollarCard") {
                    $(".dollarCardProcessingDiv").attr('hidden', false);
                }
            });
        });
    </script>
@endsection
