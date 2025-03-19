@extends('layouts.dash')

@section('title')
    {{isset($designation) ? 'Edit' : 'Add'}} Designation
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($designation) ? 'Edit' : 'Add'}} Designation</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($designation) ? route('designation.update', $designation->id) : route('designation.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($designation)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="designation">Designation <code>*</code></label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{isset($designation) ? $designation->designation : old('designation')}}" placeholder="Enter activity topic" />
                                @error('designation')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($designation) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('designation.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
