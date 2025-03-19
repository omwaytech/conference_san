@extends('layouts.dash')

@section('title')
    Register Workshop
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            @php
                $authUser = App\Models\User::whereId(auth()->user()->id)->first();
                $price = DB::table('workshop_registration_prices')
                    ->where(['workshop_id' => $workshop->id, 'member_type_id' => $authUser->userDetail->member_type_id])
                    ->first();
            @endphp
            <h1>Register Workshop ({{ $workshop->title }}) (Price:
                {{ $authUser->userDetail->memberType->delegate == 'National' ? 'Rs.' : '$' }}
                {{ !empty($price->price) ? $price->price : 'Price Not Allocated' }})</h1>
        </div>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-5">
                    <div class="card mb-4">
                        <div class="card-body">

                            @if ($authUser->userDetail->memberType->delegate == 'National')
                                <h2>QR for bank details:</h2>
                                <img src="{{ asset('default-images/qr.jpg') }}" alt="qr-image" height="500" width="80%"
                                    class="mb-3">
                            @endif
                            @if ($authUser->userDetail->memberType->delegate == 'International')
                            <h2>Payment Through Bank Transfer</h2>
                            <p><b>Bank Name:</b> Himalayan Bank, Limited. <br>
                                <b>Branch :</b> Patan Branch, Pulchowk, Lalitpur <br>
                                <b>Account Name:</b> NEPAL SOCIETY OF OBSTET AND GYNAECO <br>
                                <b>Account No:</b> 00600316790043 <br>
                                <b>Swift code:</b> HIMANPKA
                            </p><br>
                            @endif

                            @if ($authUser->userDetail->memberType->delegate == 'International')
                                <h2>Payment Through Card</h2>
                                <p>We Accept<br>
                                    <img src="https://www.setopati.com/themes/setopati/images/card.png" height="40"><br>
                                    <!-------------------------Payment Form Integration Starts------------------------------->
                                    <form class="jotform-form"
                                        action="https://merchant.omwaytechnologies.com/payment_request.php" method="post"
                                        enctype="multipart/form-data" name="form_payment" id="" accept-charset="utf-8"
                                        target="_blank">
                                        <input type="hidden" name="formID" value="92921030145569">
                                        <div class="form-all">
                                            <ul style="margin:0px; padding:0px;">

                                                <li id="yes_vacancy" style="list-style:none; margin:0px; padding:0px;">
                                                    <div class="form-sub-label-container" style="background-color:#fff;">
                                                        <div class="vacancy_content">
                                                            <h2><?php echo isset($_GET['payment']) ? ($_GET['payment'] == 'success' ? ' - <font color="green">Payment Success</font>' : ' - <font color="red">Payment failed or canceled</font>') : ''; ?></h2>



                                                            <!--</table>-->
                                                            <div id="vacancy_body">
                                                                <div class="vacancy_bodycontent">
                                                                    <div class="vacancy_desc" hidden>
                                                                        <span>
                                                                            <input type="tel" id="api_key" name="api_key"
                                                                                class="form-textbox validate[required]"
                                                                                size="50"
                                                                                value="de94032bd3aa4d86929a99fc56ec21e8"
                                                                                readonly>
                                                                            <label class="form-sub-label" for="api_key"
                                                                                id="sublabel_api" style="min-height:13px"> API
                                                                                Key </label>
                                                                        </span>
                                                                    </div>
                                                                    <div class="vacancy_desc" hidden>
                                                                        <span>
                                                                            <input type="tel" id="merchant_id"
                                                                                name="merchant_id"
                                                                                class="form-textbox validate[required]"
                                                                                size="50" value="9104238068" readonly>
                                                                            <label class="form-sub-label" for="merchant_id"
                                                                                id="sublebel_merchant" style="min-height:13px">
                                                                                Merchant Id </label>
                                                                        </span>
                                                                    </div>
                                                                    <div class="vacancy_desc" hidden>
                                                                        <span>
                                                                            <select name="input_currency" id="input_currency"
                                                                                data-validation="required"
                                                                                class="form-dropdown validate[required]">
                                                                                <option value="NPR">NPR</option>
                                                                                <option value="USD" selected>USD</option>
                                                                            </select>
                                                                            <label class="form-sub-label" for="currency"
                                                                                id="sublabel_curr" style="min-height:13px">
                                                                                Currency </label>
                                                                        </span>
                                                                    </div>
                                                                    <div class="vacancy_desc">
                                                                        <span>
                                                                            <label class="form-sub-label" for="input_amount"
                                                                                id="sublabel_amount"
                                                                                style="min-height:13px; color: red;">Total
                                                                                Workshop Amount (USD)</label>
                                                                            <input type="tel" id="dataToSend"
                                                                                name="input_amount"
                                                                                class="form-textbox validate[required] form-control"
                                                                                size="50" value="{{ @$price->price }}"
                                                                                placeholder="Please calculate price first"
                                                                                width="100" height="100" required
                                                                                style=" pointer-events: none;">

                                                                        </span>
                                                                    </div>
                                                                    <br>

                                                                    <div class="vacancy_desc" hidden>
                                                                        <span>
                                                                            <select name="input_3d" id="input_3d"
                                                                                data-validation="required"
                                                                                class="form-dropdown validate[required]">
                                                                                <option value="Y">Yes</option>
                                                                            </select>
                                                                            <label class="form-sub-label" for="input_3d"
                                                                                id="sublabel_amount" style="min-height:13px"> 3D
                                                                                Secure </label>
                                                                        </span>
                                                                    </div>
                                                                    <div class="vacancy_desc" hidden>
                                                                        <span>
                                                                            <input type="tel" id="success_url"
                                                                                name="success_url" class="form-textbox"
                                                                                size="50"
                                                                                value="https://conference.nesog.org.np/dash/conference-registration/register/?payment=success">
                                                                            <label class="form-sub-label" for="success_url"
                                                                                id="sublebel_success_url"
                                                                                style="min-height:13px"> Success URL </label>
                                                                        </span>
                                                                    </div>
                                                                    <div class="vacancy_desc" hidden>
                                                                        <span>
                                                                            <input type="tel" id="fail_url"
                                                                                name="fail_url" class="form-textbox"
                                                                                size="50"
                                                                                value="https://conference.nesog.org.np/dash/conference-registration/create/?payment=failed">
                                                                            <label class="form-sub-label" for="fail_url"
                                                                                id="sublebel_fail_url"
                                                                                style="min-height:13px"> Failed URL </label>
                                                                        </span>
                                                                    </div>
                                                                    <div class="vacancy_desc" hidden>
                                                                        <span>
                                                                            <input type="tel" id="cancel_url"
                                                                                name="cancel_url" class="form-textbox"
                                                                                size="50"
                                                                                value="https://conference.nesog.org.np/dashboard/?payment=cancel">
                                                                            <label class="form-sub-label" for="cancel_url"
                                                                                id="sublebel_cancel_url"
                                                                                style="min-height:13px"> Cancel URL </label>
                                                                        </span>
                                                                    </div>
                                                                    <div class="vacancy_desc" hidden>
                                                                        <span>
                                                                            <input type="tel" id="backend_url"
                                                                                name="backend_url" class="form-textbox"
                                                                                size="50"
                                                                                value="https://conference.nesog.org.np/dashboard/?payment=backend">
                                                                            <label class="form-sub-label" for="backend_url"
                                                                                id="sublebel_backendurl"
                                                                                style="min-height:13px"> Backend URL </label>
                                                                        </span>
                                                                    </div>

                                                                    <div class="vacancy_desc">

                                                                        <!--<button id="input_apply" type="submit" class="form-submit-button" data-component="button">-->
                                                                        <!--Pay Now-->
                                                                        <!--               </button>  -->
                                                                        <button id="input_apply" type="submit"
                                                                            class="btn btn-primary" data-component="button">
                                                                            Pay Now
                                                                        </button>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>


                                            </ul>
                                        </div>
                                        <input type="hidden" id="simple_spc" name="simple_spc" value="92921030145569">

                                        <div class="formFooter-heightMask">
                                        </div>

                                    </form>
                                    <!-------------------------Payment Form Integration Ends------------------------------->
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="card mb-4">
                        <div class="card-body">
                            {{-- @if ($authUser->userDetail->memberType->delegate == 'National')
                                <a href="{{route('workshop-registration.fonePay', [$workshop->slug, !empty($price->price) ? $price->price : 0])}}" class="btn btn-primary mb-2">Proceed For Online Payment ?</a>
                            @endif --}}
                            <form
                                action="{{ isset($workshop_registration) ? route('workshop-registration.update', $workshop_registration->id) : route('workshop-registration.store') }}"
                                id="submitFormData" method="POST" enctype="multipart/form-data">
                                @csrf
                                @isset($workshop_registration)
                                    @method('patch')
                                @endisset
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="workshop_id">Workshops <code>*</code></label>
                                        <select name="workshop_id"
                                            class="form-control @error('workshop_id') is-invalid @enderror">
                                            @if (isset($workshop_registration))
                                                <option value="{{ $workshop_registration->workshop_id }}">
                                                    {{ $workshop_registration->workshop->title }}</option>
                                            @else
                                                <option value="{{ $workshop->id }}">{{ $workshop->title }}</option>
                                            @endif
                                        </select>
                                        @error('workshop_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="transaction_id">Transaction ID/Bill No/Reference Code
                                            <code>*</code></label>
                                        <input type="text"
                                            class="form-control @error('transaction_id') is-invalid @enderror"
                                            name="transaction_id"
                                            value="{{ isset($workshop_registration) ? $workshop_registration->transaction_id : old('transaction_id') }}" />
                                        @error('transaction_id')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="payment_voucher">Payment Voucher <code>* (Only: PDF/JPG/PNG) (Max: 250
                                                KB)</code></label>
                                        <input type="file"
                                            class="form-control @error('payment_voucher') is-invalid @enderror"
                                            name="payment_voucher" id="image" />
                                        @error('payment_voucher')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <div class="row" id="imgPreview">
                                            @if (isset($workshop_registration))
                                                <div class="col-3 mt-2">
                                                    @php
                                                        $explodeFileName = explode(
                                                            '.',
                                                            $workshop_registration->payment_voucher,
                                                        );
                                                    @endphp
                                                    @if ($explodeFileName[1] == 'pdf')
                                                        <a href="{{ asset('storage/workshop/registration/payment-voucher/' . $workshop_registration->payment_voucher) }}"
                                                            target="_blank"><img
                                                                src="{{ asset('default-images/pdf.png') }}"
                                                                alt="voucher" class="img-fluid"></a>
                                                    @else
                                                        <a href="{{ asset('storage/workshop/registration/payment-voucher/' . $workshop_registration->payment_voucher) }}"
                                                            target="_blank"><img
                                                                src="{{ asset('storage/conference/registration/payment-voucher/' . $conference_registration->payment_voucher) }}"
                                                                alt="voucher" class="img-fluid"></a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="meal_type">Meal Preference <code>*</code></label>
                                        <select name="meal_type" class="form-control" id="meal_type">
                                            <option value="" hidden>-- Select Veg/Non-veg --</option>
                                            <option value="1"
                                                @if (isset($workshop_registration)) {{ $workshop_registration->meal_type == '1' ? 'selected' : '' }} @else @selected(old('meal_type') == '1') @endif>
                                                Veg</option>
                                            <option value="2"
                                                @if (isset($workshop_registration)) {{ $workshop_registration->meal_type == '2' ? 'selected' : '' }} @else @selected(old('meal_type') == '2') @endif>
                                                Non-veg</option>
                                        </select>
                                        @error('meal_type')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" id="submitButton"
                                            class="btn btn-primary">{{ isset($workshop_registration) ? 'Update' : 'Submit' }}</button>
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

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                var error = '{{$error}}';
                toastr.error(error);
            </script>
        @endforeach
    @endif

    <script>
        $(document).ready(function() {
            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#submitFormData").submit();
            });
        });
    </script>
@endsection
