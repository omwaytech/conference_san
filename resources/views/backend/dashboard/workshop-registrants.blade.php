@extends('layouts.dash')

@section('title')
    Registered Attendees
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left"> 
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Registered Attendees (Workshop: {{$workshop->title}})</h4>
                        <div class="ml-auto">
                            <a href="{{ route('home') }}" class="btn btn-danger"> Back</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Registrant Name</th>
                                    <th scope="col">Member Type</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Payment Voucher</th>
                                    <th scope="col">Verified Status</th>
                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead> 
                            <tbody>
                                @foreach ($registrations as $registration)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$registration->user->fullName($registration, 'user')}}</td>
                                        <td>{{$registration->user->userDetail->memberType->type ?? null}}</td>
                                        <td>{{$registration->transaction_id}}</td>
                                        <td>
                                            @if ($registration->payment_voucher == 'Fone-Pay')
                                                Fone-Pay
                                            @elseif (!empty($registration->payment_voucher))
                                                @php
                                                    $extension = explode('.', $registration->payment_voucher);
                                                @endphp
                                                @if ($extension[1] == 'pdf')
                                                    <a href="{{asset('storage/workshop/registration/payment-voucher/'.$registration->payment_voucher)}}" target="_blank"><img src="{{asset('default-images/pdf.png')}}" height="60" alt="voucher"></a>
                                                @else
                                                    <a href="{{asset('storage/workshop/registration/payment-voucher/'.$registration->payment_voucher)}}" target="_blank"><img src="{{asset('storage/workshop/registration/payment-voucher/'.$registration->payment_voucher)}}" height="60" alt="voucher"></a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if ($registration->verified_status == 1)
                                                <span class="badge bg-success">Verified</span>
                                            @elseif ($registration->verified_status == 2)
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                @if ($registration->workshop->user_id == auth()->user()->id || auth()->user()->role == 1)
                                                    <a href="#" class="verifyRegistrant" data-id="{{$registration->id}}" data-toggle="modal" data-target="#openModal"><span class="badge bg-warning">Unverified</span></a>
                                                @else
                                                    <span class="badge bg-warning">Unverified</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{!empty($registration->remarks) ? $registration->remarks : '-'}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal fade" id="openModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content" id="modalContent">
                                {{-- modal body goes here --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $(document).on("click", ".verifyRegistrant", function (e) {
            e.preventDefault();
            $(".modal-dialog").removeClass('custom-modal-width');
            var url = '{{route('workshop-registration.verifyForm')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });
    });
</script>
@endsection
