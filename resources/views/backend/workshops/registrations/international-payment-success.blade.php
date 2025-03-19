@extends('layouts.dash')

@section('title')
    Register Workshop
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            @php
                $onlinePayment = session()->get('workshopOnlinePayment');
                $workshop = DB::table('workshops')->where('id', $onlinePayment['workshop_id'])->first();
            @endphp
            <h1>Register Workshop ({{$workshop->title}})</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form action="{{ route('workshop-registration.submit') }}" method="POST" id="registrationForm"
                                enctype="multipart/form-data">
                                @csrf
                                @isset($conference_registration)
                                    @method('patch')
                                @endisset
                                <input type="hidden" name="workshop_id" value="{{$onlinePayment['workshop_id']}}">
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
                                            <code>* ({{auth()->user()->userDetail->country->country_name == 'Nepal' ? 'Rs.' : '$'}})</code></label>
                                        <input type="text"
                                            class="form-control @error('amount') is-invalid @enderror"
                                            name="amount" id="amount"
                                            value="{{ old('amount') ? old('amount') : $onlinePayment['amount'] }}"
                                            placeholder="Enter transaction id" readonly />
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
                                    <div class="col-md-12">
                                        <button type="submit" id="submitButton" class="btn btn-primary" >Submit</button>
                                        <a href="{{ route('workshop-registration.index') }}"
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
@endsection
