@extends('layouts.dash')

@section('title')
    Register Workshop
@endsection

@section('content')

    <div class="main-content">
        <div class="breadcrumb">
            <h1>Register Workshop ({{ $workshop->title }})</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-card alert-success text-center" role="alert">Payment success, proceed now for further registration.
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form
                                action="{{ route('workshop-registration.submitData') }}"
                                method="POST" id="registrationForm" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <h3 class="col-md-12" hidden>Registration Form:</h3>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="workshop_id">Workshop <code>*</code></label>
                                        <select name="workshop_id" class="form-control" id="workshop_id">
                                            <option value="{{$workshop->id}}" @selected(old('workshop_id') == $workshop->id)>{{$workshop->title}}</option>
                                        </select>
                                        @error('workshop_id') 
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="transaction_id">Transaction ID/Bill No/Reference Code <code>*</code></label>
                                        <input type="text"
                                            class="form-control @error('transaction_id') is-invalid @enderror"
                                            name="transaction_id" id="transaction_id"
                                            value="{{ $transactionId }}"
                                            placeholder="Enter transaction id" readonly/>
                                        @error('transaction_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="amount">Amount <code>*</code></label>
                                        <input type="text"
                                            class="form-control @error('amount') is-invalid @enderror"
                                            name="amount" id="amount"
                                            value="{{ $amount }}"
                                            placeholder="Enter amount" readonly/>
                                        @error('amount')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="meal_type">Meal Preference <code>*</code></label>
                                        <select name="meal_type" class="form-control" id="meal_type">
                                            <option value="" hidden>-- Select Veg/Non-veg --</option>
                                            <option value="1" @selected(old('meal_type') == '1')>Veg</option>
                                            <option value="2" @selected(old('meal_type') == '2')>Non-veg</option>
                                        </select>
                                        @error('meal_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
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
