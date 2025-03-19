@extends('layouts.dash')

@section('title')
    {{isset($name_prefix) ? 'Edit' : 'Add'}} Name Prefix
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($name_prefix) ? 'Edit' : 'Add'}} Name Prefix</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($name_prefix) ? route('name-prefix.update', $name_prefix->id) : route('name-prefix.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($name_prefix)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label for="prefix">Name Prefix <code>*</code></label>
                                <input type="text" class="form-control @error('prefix') is-invalid @enderror" name="prefix" id="image" placeholder="Enter Name Prefix" value="{{isset($name_prefix) ? $name_prefix->prefix : old('name_prefix')}}" />
                                @error('prefix')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($name_prefix) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('name-prefix.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
