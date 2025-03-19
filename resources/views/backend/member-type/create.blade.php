@extends('layouts.dash')

@section('title')
    {{isset($member_type) ? 'Edit' : 'Add'}} Member Type
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($member_type) ? 'Edit' : 'Add'}} Member Type</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($member_type) ? route('member-type.update', $member_type->id) : route('member-type.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($member_type)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-2 form-group mb-3">
                                <label for="delegate">Delegate <code>*</code></label>
                                <select name="delegate" class="form-control" id="delegate">
                                    <option value="" hidden>-- Select Delegate --</option>
                                    <option value="International" @if(isset($member_type)) {{$member_type->delegate == 'International' ? 'selected' : ''}} @else @selected(old('delegate') == 'International') @endif>International</option>
                                    <option value="National" @if(isset($member_type)) {{$member_type->delegate == 'National' ? 'selected' : ''}} @else @selected(old('delegate') == 'National') @endif>National</option>
                                </select>
                                @error('delegate')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="type">Member Type <code>*</code></label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror" name="type" id="type" value="{{isset($member_type) ? $member_type->type : old('type')}}" placeholder="Enter member type" />
                                @error('type')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($member_type) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('member-type.index')}}" class="btn btn-danger">Cancel</a>
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
        $("#delegate").change(function (e) {
            e.preventDefault();
            if ($(this).val() === 'International') {
                $('.currency').text('in $')
            } else if ($(this).val() === 'National') {
                $('.currency').text('in Rs.')
            }
        });
        $("#delegate").trigger('change');

        $("#amount").on("keydown", function(event) {
            // Allow backspace, delete, tab, escape, and enter keys
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
                // Allow Ctrl+A
                (event.keyCode == 65 && event.ctrlKey === true) ||
                // Allow home, end, left, right
                (event.keyCode >= 35 && event.keyCode <= 39) ||
                // Allow numbers from the main keyboard (0-9) and the numpad (96-105)
                (event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105)) {
            return;
            } else {
            event.preventDefault();
            }
        });
    });
</script>
@endsection
