@extends('layouts.dash')

@section('title')
    {{isset($committee_member) ? 'Edit' : 'Add'}} Committee Member
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($committee_member) ? 'Edit' : 'Add'}} Committee Member </h1><br>
            @if (!isset($committee_member))
                <h4><code>(NOTE: Mutiple members can be added at a time for Member and Single Member for others.)</code></h4>
            @endif
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($committee_member) ? route('committeeMember.update', $committee_member->id) : route('committeeMember.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($committee_member)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <input type="hidden" name="committee_id" value="{{$committee->id}}">
                            <div class="col-md-6 form-group mb-3">
                                <label for="user_id">Committee Members <code>*</code></label>
                                <select name="user_id[]" class="form-control @error('user_id') is-invalid @enderror select2" multiple>
                                    @if (!isset($committee_member))
                                        <option value="" hidden>-- Select Committee Members --</option>
                                        @foreach ($users as $user)
                                            <option value="{{$user->id}}" @selected(old('user_id', @$committee_member->user_id) == $user->id)>{{$user->fullName($user)}} ({{$user->userDetail->council_number}})</option>
                                        @endforeach
                                    @else
                                        <option value="{{$committee_member->user_id}}" selected>{{$committee_member->user->fullName($committee_member, 'user')}} ({{$committee_member->user->userDetail->council_number}})</option>
                                    @endif
                                </select>
                                @error('user_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="designation_id">Designation <code>*</code></label>
                                <select name="designation_id" class="form-control @error('designation_id') is-invalid @enderror">
                                    <option value="" hidden>-- Select Designation --</option>
                                    @foreach ($designations as $designation)
                                        <option value="{{$designation->id}}" @selected(old('designation_id', @$committee_member->designation_id) == $designation->id)>{{$designation->designation}}</option>
                                    @endforeach
                                </select>
                                @error('designation_id')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="message">Message </label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" id="description" cols="30" rows="10">{{isset($committee_member) ? $committee_member->message : old('message')}}</textarea>
                                @error('message')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($committee_member) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('committeeMember.index', $committee->slug)}}" class="btn btn-danger">Cancel</a>
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
        $('.select2').select2();
    });
</script>
@endsection
