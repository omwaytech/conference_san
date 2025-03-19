@extends('layouts.dash')

@section('title')
    {{isset($admin) ? 'Edit' : 'Add'}} Admin
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($admin) ? 'Edit' : 'Add'}} Admin</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($admin) ? route('admin.update', $admin->id) : route('admin.store')}}" method="POST" enctype="multipart/form-data" id="adminForm">
                        @csrf
                        @isset($admin)
                            @method('patch')
                        @endisset
                        <div class="row">
                            @if (App\Models\User::userRole()[0] == 1)
                                @if (is_null(@$admin))
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="role">Role <code>*</code></label>
                                        <select name="role" class="form-control" id="role">
                                            <option value="" hidden>-- Select Role --</option>
                                            <option value="2" @selected(old('role') == '2')>Scientific Committee</option>
                                            <option value="3" @selected(old('role') == '3')>Expert</option>
                                            <option value="5" @selected(old('role') == '5')>Registration Committee</option>
                                        </select>
                                        @error('role')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                @endif
                            @else
                                <input type="hidden" value="2" name="role">
                            @endif
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Full Name <code>*</code></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{isset($admin) ? $admin->name : old('name')}}" placeholder="Enter executive name" />
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email <code>*</code></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{isset($admin) ? $admin->email : old('email')}}" placeholder="Enter email" />
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" id="submitButton" class="btn btn-primary">{{isset($admin) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('admin.index')}}" class="btn btn-danger">Cancel</a>
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
        $(document).ready(function () {
            $("#submitButton").click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#adminForm").submit();
            });
        });
    </script>
@endsection

