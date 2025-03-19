@extends('layouts.dash')

@section('title')
    {{isset($sponsor_invitation) ? 'Edit' : 'Add'}} Sponsor Invitation
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($sponsor_invitation) ? 'Edit' : 'Add'}} Sponsor Invitation</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($sponsor_invitation) ? route('sponsor-invitation.update', $sponsor_invitation->id) : route('sponsor-invitation.store')}}" id="sponsorInvitationForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($sponsor_invitation)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="name">Full Name <code>*</code></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{isset($sponsor_invitation) ? $sponsor_invitation->name: old('name')}}" placeholder="Enter full name" />
                                @error('name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="email">Email <code>*</code></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{isset($sponsor_invitation) ? $sponsor_invitation->email: old('email')}}" placeholder="Enter email" />
                                @error('email')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="phone">Phone </label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{isset($sponsor_invitation) ? $sponsor_invitation->phone: old('phone')}}" placeholder="Enter phone" />
                                @error('phone')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="address">Address </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{isset($sponsor_invitation) ? $sponsor_invitation->address : old('address')}}" placeholder="Enter address" />
                                @error('address')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="image">Image <code>(Only JPG, PNG)</code></label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" />
                                @error('image')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                                <div class="row" id="imgPreview">
                                    @if (isset($sponsor_invitation))
                                        <div class="col-3 mt-2">
                                            <img src="{{asset('storage/sponsors/'.$sponsor_invitation->image)}}" alt="image" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="description">Description </label>
                                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{isset($sponsor_invitation) ? $sponsor_invitation->description : old('description')}}</textarea>
                                @error('description')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" id="submitButton" class="btn btn-primary">{{isset($sponsor_invitation) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('sponsor-invitation.index')}}" class="btn btn-danger">Cancel</a>
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
            $("#submitButton").click(function (e) {
                e.preventDefault();
                $(this).attr('disabled', true);
                $("#sponsorInvitationForm").submit();
            });
        });
    </script>
@endsection
