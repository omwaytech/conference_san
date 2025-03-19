@extends('layouts.dash')

@section('title')
    Register Workshop
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>Register Workshop</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('workshop-registration.forSignedUpUsersSubmit') }}" method="POST"
                        id="registrationForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="workshop_id">Workshop <code>*</code></label>
                                <select name="workshop_id" class="form-control" id="workshop_id">
                                    <option value="" hidden>-- Select Workshop --</option>
                                    @foreach ($workshops as $workshop)
                                        <option value="{{ $workshop->id }}" @selected(old('workshop_id') == $workshop->id)>
                                            {{ $workshop->title }}</option>
                                    @endforeach
                                </select>
                                @error('workshop_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="user_id">User <code>*</code></label>
                                <select name="user_id" class="form-control" id="user_id">
                                    <option value="" hidden>-- Select User --</option>
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
                                <label for="transaction_id">Transaction ID/Bill No/Reference Code <code>*</code></label>
                                <input type="text" class="form-control @error('transaction_id') is-invalid @enderror"
                                    name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}"
                                    placeholder="Enter transaction id or bill number" />
                                @error('transaction_id')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="amount">Amount <code>* (Only Numeric Value)</code></label>
                                <input type="text"
                                    class="form-control @error('amount') is-invalid @enderror numericValue" name="amount"
                                    id="amount" value="{{ old('amount') }}" placeholder="Enter amount" />
                                @error('amount')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="payment_voucher">Payment Voucher <code>(Only JPG/PNG/PDF) (Max: 250
                                        KB)</code></label>
                                <input type="file" class="form-control @error('payment_voucher') is-invalid @enderror"
                                    name="payment_voucher" id="image2" />
                                @error('payment_voucher')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div class="row" id="imgPreview2"></div>
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
        $(document).ready(function() {
            $("#user_id").select2();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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

            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#registrationForm").submit();
            });
        });
    </script>
@endsection
