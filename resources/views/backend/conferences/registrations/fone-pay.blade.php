@extends('layouts.dash')

@section('title')
    Register Conference
@endsection

@section('content')
    @php
        $MD = 'P';
        $AMT = count($explodeValues) == 5 ? $explodeValues[4] : $explodeValues[1];
        $CRN = 'NPR';
        $DT = date('m/d/Y');
        $R1 = 'Conference Registration';
        $R2 = 'test';
        $totalAttendee = count($explodeValues) == 5 ? $explodeValues[2] + 1 : 1;
        
        $RU = 'https://conference.nesog.org.np/payment-success';
        $PRN = uniqid();
        $PID = '2222030014691781';
        $sharedSecretKey = '0a9cdebfa3b4472698027dd6e2ec1fe0';
        $DV = hash_hmac(
            'sha512',
            $PID . ',' . $MD . ',' . $PRN . ',' . $AMT . ',' . $CRN . ',' . $DT . ',' . $R1 . ',' . $R2 . ',' . $RU,
            $sharedSecretKey,
        );
        $paymentLiveUrl = 'https://clientapi.fonepay.com/api/merchantRequest';
        $paymentDevUrl = 'https://dev-clientapi.fonepay.com/api/merchantRequest';
    @endphp

    <div class="card-body">
        <h4 class="card-title mb-3 d-flex justify-content-center font-weight-bold">Your Payment Details</h4>
        <div class="table-responsive">
            <table class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>No. of Persons</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $explodeValues[0] }}</td>
                        <td>1</td>
                        <td>Rs. {{ $explodeValues[1] }}</td>
                    </tr>
                    @if (count($explodeValues) == 5)
                        <tr>
                            <td>2</td>
                            <td>Additional Guests</td>
                            <td>{{ $explodeValues[2] }}</td>
                            <td>Rs. {{ $explodeValues[3] }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td></td>
                        <td>Total</td>
                        <td></td>
                        <td style="font-weight:bold;">Rs. {{ $AMT }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
         <form method="GET" id ="payment-form" action="{{ $paymentLiveUrl }}">

            <label for="fonepay">
                 <input class="radio-btn" type="radio" id="fonepay" name="payment-options" value="fonepay" data-gtm-form-interact-field-id="3" required>
            <span class="circle"></span><span class="check"></span><img src="https://www.setopati.com/themes/setopati/images/fonepay.png" height="50" width="100" alt="">
            </label>
            </br>

        <input type="hidden" name="PID" value="{{ $PID }}">

        <input type="hidden" name="MD" value="{{ $MD }}">

        <input type="hidden" name="AMT" value="{{ $AMT }}">

        <input type="hidden" name="CRN" value="{{ $CRN }}">

        <input type="hidden" name="DT" value="{{ $DT }}">

        <input type="hidden" name="R1" value="{{ $R1 }}">

        <input type="hidden" name="R2" value="{{ $R2 }}">

        <input type="hidden" name="DV" value="{{ $DV }}">

        <input type="hidden" name="RU" value="{{ $RU }}">

        <input type="hidden" name="PRN" value="{{ $PRN }}">

        <input type="submit" class="btn btn-primary" value="Pay Now">
    </form>
    </div>

@endsection
