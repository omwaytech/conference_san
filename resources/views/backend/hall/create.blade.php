@extends('layouts.dash')

@section('title')
    {{isset($hall) ? 'Edit' : 'Add'}} Hall
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($hall) ? 'Edit' : 'Add'}} Hall</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($hall) ? route('hall.update', $hall->id) : route('hall.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($hall)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="hall_name">Hall Name <code>*</code></label>
                                <input type="text" class="form-control @error('hall_name') is-invalid @enderror" name="hall_name" value="{{isset($hall) ? $hall->hall_name : old('hall_name')}}" placeholder="Enter activity topic" />
                                @error('hall_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($hall) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('hall.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
