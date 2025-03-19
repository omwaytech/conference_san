@extends('layouts.dash')

@section('title')
    {{isset($sponsor_category) ? 'Edit' : 'Add'}} Sponsor Category
@endsection

@section('content')
    <div class="main-content">
        <div class="breadcrumb">
            <h1>{{isset($sponsor_category) ? 'Edit' : 'Add'}} Sponsor Category</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{isset($sponsor_category) ? route('sponsor-category.update', $sponsor_category->id) : route('sponsor-category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($sponsor_category)
                            @method('patch')
                        @endisset
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="category_name">Category Name <code>*</code></label>
                                <input type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" id="category_name" value="{{isset($sponsor_category) ? $sponsor_category->category_name : old('category_name')}}" placeholder="Enter Sponsor Category Name" />
                                @error('category_name')
                                    <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">{{isset($sponsor_category) ? 'Update' : 'Submit'}}</button>
                                <a href="{{route('sponsor-category.index')}}" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
