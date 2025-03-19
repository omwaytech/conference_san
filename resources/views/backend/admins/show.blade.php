@extends('layouts.dash')

@section('title')
    Admins
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="row mb-2">
                        <h4 class="card-title">Admins</h4>
                        <div class="ml-auto">
                            <a href="{{ route('admin.create') }}" class="btn btn-primary"> Add</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="zero_configuration_table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Last Login</th>
                                    <th scope="col" style="width: 17%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$admin->name}}</td>
                                        <td>{{$admin->email}}</td>
                                        <td>
                                            @php
                                                $role = json_decode($admin->role);
                                            @endphp
                                            @if (in_array(2, $role))
                                                Scientific Committee
                                            @elseif (in_array(3, $role))
                                                Expert
                                            @elseif (in_array(5, $role))
                                                Registration Committee
                                            @endif
                                        </td>
                                        <td>{{!empty($admin->last_login_at) ? \Carbon\Carbon::parse($admin->last_login_at)->format('d M, Y, h:i a') : '-'}}</td>
                                        <td>
                                            <a href="{{route('admin.edit', $admin->id)}}" class="btn btn-success" title="Edit Data"><i class="nav-icon i-Pen-2"></i></a>
                                            <button class="btn btn-danger btn-sm resetPassword" data-id="{{$admin->id}}" type="button">Reset Password</button>
                                        </td>
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
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".resetPassword").click(function (e) {
            e.preventDefault();
            if (confirm("Are you sure to reset password of this member?")) {
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
</script>
@endsection
