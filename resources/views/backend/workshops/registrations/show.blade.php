@extends('layouts.dash')

@section('title')
    Registered Workshop
@endsection

@section('content')
    <div class="main-content">
        @if ($userDetail->country_id == 78)
            <h4 class="text-success"><b><u>Guideline To Pay Through SBI Bank (India to Nepal)</u></b></h4>
            <div class="breadcrumb">
                <a href="{{ asset('default-images/pay-from-india.pdf') }}" target="_blank">Click here to see guidelines to pay
                    fee from SBI Bank.</a>
            </div>
            <hr>
        @endif
        <div class="breadcrumb">
            <h4>Workshops</h4>
        </div>
        <div class="row">
            @foreach ($workshops as $w_item)
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                        <div class="card-body"><i class="i-Conference"></i>
                            <div style="margin-left: 6%;">
                                @php
                                    $latestConference = App\Models\Conference::latestConference();
                                @endphp
                                <h5 class="text-muted mt-2 mb-0">{{ $w_item->title }}
                                    ({{ $w_item->start_date <= $latestConference->start_date ? 'Pre-Conference Workshop' : 'Post-Conference Workshop' }})
                                </h5>
                                @php
                                    $totalQuota = $w_item->no_of_participants;
                                    $appliedQuota = $w_item->registrations->where('verified_status', 1)->count();
                                @endphp
                                <p class="text-muted mt-2 mb-0">Total Quota: {{ $totalQuota }}</p>
                                <p class="text-muted mt-2 mb-0">Applied Quota: {{ $appliedQuota }}</p>
                                <p class="text-muted mt-2 mb-0">Remaining Quota:
                                    {{ $totalQuota - $appliedQuota < 0 ? 0 : $totalQuota - $appliedQuota }}</p>
                                @php
                                    $userDetail = App\Models\UserDetail::where('user_id', auth()->user()->id)->first();
                                    $price = DB::table('workshop_registration_prices')
                                        ->where([
                                            'workshop_id' => $w_item->id,
                                            'member_type_id' => $userDetail->member_type_id,
                                        ])
                                        ->first();
                                    $priceValue = null;
                                    if (empty($price->price)) {
                                        $priceValue = 'Price Not Allocated';
                                    } else {
                                        if (@$userDetail->memberType->delegate == 'National') {
                                            $priceValue = $price->price;
                                        } elseif (@$userDetail->memberType->delegate == 'International') {
                                            $priceValue = $price->price + $price->price * 0.035;
                                        }
                                    }
                                @endphp
                                <p class="text-muted mt-2 mb-0">Price:
                                    {{ @$userDetail->memberType->delegate == 'National' ? 'Rs.' : '$' }} {{ $priceValue }}
                                </p>
                                @php
                                    $checkRegistration = $w_item->registrations
                                        ->where('user_id', auth()->user()->id)
                                        ->where('status', 1)
                                        ->first();
                                @endphp
                                @if (!empty($checkRegistration))
                                    @if ($checkRegistration->verified_status == 0)
                                        <span class="badge bg-success">Registered</span>
                                    @elseif ($checkRegistration->verified_status == 1 && $checkRegistration->attendance_status == 1)
                                        <a href="{{ route('workshop-registration.generateCertificate', $checkRegistration->id) }}"
                                            class="btn btn-info btn-sm mt-1" target="_blank"><i class="nav-icon i-File"></i>
                                            Generate Certificate</a>
                                    @elseif ($checkRegistration->verified_status == 1)
                                        <span class="badge bg-success">Accepted</span>
                                    @elseif ($checkRegistration->verified_status == 2)
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                @endif
                                @if (empty($price->price))
                                    <p>Price Not Added</p>
                                @else
                                    @if (empty($checkRegistration) && $appliedQuota <= $totalQuota)
                                        @if (@$userDetail->memberType->delegate == 'National')
                                            <a href="{{ route('workshop-registration.fonePay', [$w_item->id, $priceValue]) }}"
                                                class="btn btn-primary btn-sm">Register This Workshop</a>
                                            {{-- <a href="{{route('workshop-registration.create', $w_item->slug)}}" class="btn btn-primary btn-sm">Register This Workshop</a> --}}
                                        @else
                                            <a href="{{ route('workshop-registration.createInternational', [$w_item->id, $priceValue]) }}"
                                                class="btn btn-primary btn-sm">Register This Workshop</a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Registered Workshops</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Workshop</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Payment Voucher/Amount</th>
                                    <th scope="col">Verified Status</th>
                                    <th scope="col">Meal Type</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registrations as $registration)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $registration->workshop->title }}</td>
                                        <td>{{ $registration->transaction_id }}</td>
                                        <td>
                                            @if ($registration->payment_voucher == 'Fone-Pay')
                                                Fone-Pay
                                            @elseif (!empty($registration->payment_voucher))
                                                @php
                                                    $extension = explode('.', $registration->payment_voucher);
                                                @endphp
                                                @if ($extension[1] == 'pdf')
                                                    <a href="{{ asset('storage/workshop/registration/payment-voucher/' . $registration->payment_voucher) }}"
                                                        target="_blank"><img src="{{ asset('default-images/pdf.png') }}"
                                                            height="60" alt="voucher"></a>
                                                @else
                                                    <a href="{{ asset('storage/workshop/registration/payment-voucher/' . $registration->payment_voucher) }}"
                                                        target="_blank"><img
                                                            src="{{ asset('storage/workshop/registration/payment-voucher/' . $registration->payment_voucher) }}"
                                                            height="60" alt="voucher"></a>
                                                @endif
                                            @elseif (!empty($registration->amount))
                                                {{ @$userDetail->memberType->delegate == 'National' ? 'Rs. ' : '$' }}{{ $registration->amount }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($registration->verified_status == 1)
                                                <span class="badge bg-success">Verified</span>
                                            @elseif ($registration->verified_status == 2)
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-warning">Unverified</span>
                                            @endif
                                        </td>
                                        <td>{{ $registration->meal_type == 1 ? 'Veg' : 'Non-veg' }}</td>
                                        <td>{{ !empty($registration->remarks) ? $registration->remarks : '-' }}</td>
                                        {{-- <td>
                                            @if ($registration->verified_status == 0 || $registration->verified_status == 2)
                                                <form
                                                    action="{{ route('workshop-registration.destroy', $registration->id) }}"
                                                    method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    @if ($registration->payment_voucher == 'Fone-Pay')
                                                        @if ($registration->verified_status == 0)
                                                            <span class="badge bg-warning">Unverified</span>
                                                        @else
                                                            <span class="badge bg-danger">Rejected</span>
                                                        @endif
                                                    @else
                                                        <a href="{{ route('workshop-registration.edit', $registration->id) }}"
                                                            class="btn btn-sm btn-success mb-1" title="Edit Data"><i
                                                                class="nav-icon i-Pen-2"></i></a>
                                                        <button title="Delete Data" class="btn btn-sm btn-danger delete mb-1"
                                                            type="submit"><i class="nav-icon i-Close-Window"></i></button>
                                                    @endif
                                                </form>
                                            @else
                                                <span class="badge bg-success">Verified</span>
                                            @endif
                                        </td> --}}
                                        @if (\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($registration->workshop->end_date)))
                                            {{-- @if ($registration->workshop_id != 7) --}}
                                                <td>
                                                    <a
                                                        href="{{ route('workshop-registration.generateCertificate', $registration->id) }}">
                                                        <button type="submit" class="btn btn-primary">Generate
                                                            Certificate</button>
                                                    </a>
                                                </td>
                                            {{-- @endif --}}
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
