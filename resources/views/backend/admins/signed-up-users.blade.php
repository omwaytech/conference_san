@extends('layouts.dash')

@section('title')
    Signed Up Users
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Signed Up Users</h4> 
                        <div class="ml-auto">
                            <a href="{{ route('admin.excelExport') }}" class="btn btn-primary"><i class="nav-icon i-File"></i> Excel Export</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Has Registered Conference?</th>
                                    <th scope="col">Number Of Workshops Registration</th>
                                    <th scope="col">Last Login</th>
                                    <th scope="col">Is Expert?</th>
                                    @if (auth()->user()->role == 1)
                                        <th scope="col" style="width: 17%">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$user->fullName($user)}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>
                                            @if (!empty($user->conferenceRegistration))
                                                <span class="badge bg-success">Registered</span>
                                            @else
                                                <span class="badge bg-warning">Not Registered</span>
                                            @endif
                                        </td>
                                        <td>{{$user->workshopRegistration->count()}}</td>
                                        <td>{{!empty($user->last_login_at) ? \Carbon\Carbon::parse($user->last_login_at)->format('d M, Y, h:i a') : '-'}}</td>
                                        {{-- for expert start --}}
                                        <td>
                                            @php
                                                $isExpert = DB::table('experts')->where(['user_id' => $user->id, 'conference_id' => $latestConference->id])->first();
                                            @endphp
                                            @if (!empty($isExpert))
                                                @if ($isExpert->status == 1)
                                                    <a href="#" class="btn btn-success btn-sm mt-1 makeExpert" data-id="{{$user->id}}" data-name="{{ $user->fullName($user) }}" data-type="remove"><i class="nav-icon i-Yes"></i></a>
                                                @else
                                                    <a href="#" class="btn btn-warning btn-sm mt-1 makeExpert" data-id="{{$user->id}}" data-name="{{ $user->fullName($user) }}" data-type="assign"><i class="nav-icon i-Close-Window"></i></a>
                                                @endif
                                            @else
                                                <a href="#" class="btn btn-warning btn-sm mt-1 makeExpert" data-id="{{$user->id}}" data-name="{{ $user->fullName($user) }}" data-type="assign"><i class="nav-icon i-Close-Window"></i></a>
                                            @endif
                                        </td>
                                        {{-- for expert end --}}
                                        @if (auth()->user()->role == 1)
                                            <td>
                                                <a href="{{route('home.editProfileByAdmin', $user->id)}}" class="btn btn-success btn-sm mb-1" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                                <button class="btn btn-danger btn-sm resetPassword mb-1" data-id="{{$user->id}}" type="button">Reset Password</button>
                                                @if (empty($user->conferenceRegistration))
                                                    <button class="btn btn-primary btn-sm inviteUserForConference mb-1" data-id="{{$user->id}}" data-toggle="modal" data-target="#openModal" type="button">Invite User For Conference</button>
                                                    @endif
                                                    <button class="btn btn-primary btn-sm passDesgination mb-1" data-id="{{$user->id}}" data-toggle="modal" data-target="#openModal" type="button">Pass Desgination</button>
                                            </td>
                                        @endif
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".resetPassword").click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure to reset password of this member?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Assign!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var userId = $(this).data('id');
                    var url = '{{route('admin.resetPassword')}}';
                    var data = {
                        userId: userId
                    };
                    $.post(url, data, function (response) {
                        if (response.type == 'success') {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                        window.location.reload();
                    });
                }
            });
        });

        $(document).on('click', '.makeExpert', function(e) {
            e.preventDefault();
            var name = $(this).data('name');
            var userId = $(this).data('id');
            var type = $(this).data('type');
            Swal.fire({
                title: "Do you want to " + type + " '" + name + "' as an Expert?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Assign!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '{{route('admin.makeExpert')}}';
                    var data = {
                        userId: userId
                    };
                    $.post(url, data, function (response) {
                        if (response.type == 'success') {
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.reload();
                            }, 1000);
                        } else {
                            toastr.error(response.message);
                        }
                    });
                }
            })
        });

        $(document).on("click", ".inviteUserForConference", function (e) {
            e.preventDefault();
            var url = '{{route('admin.inviteUserForConference')}}';
            var _token = '{{csrf_token()}}';
            var id = $(this).data('id');
            var data = {_token:_token, id:id};
            $.post(url, data, function(response){
                $('#modalContent').html(response);
            });
        });
        $(document).on("click", ".passDesgination", function (e) {
            e.preventDefault();
            var url = '{{route('admin.passDesgination')}}';
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
